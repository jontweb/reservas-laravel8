<?php

namespace App\Http\Controllers\Booking;

use Exception;
use App\Enums\ServiceStatus;
use Illuminate\Http\Request;
use App\Enums\ServicePaymentStatus;
use App\Http\Controllers\Controller;
use App\Enums\ServiceCancelPaymentStatus;
use App\Models\Booking\SchServiceBooking;
use App\Models\Employee\SchEmployeeService;
use App\Http\Repository\Booking\BookingRepository;
use App\Http\Repository\UtilityRepository;
use App\Models\Customer\CmnCustomer;
use App\Models\User;
use App\Notifications\ServiceBookingNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class SchServiceBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function bookingCalendar()
    {
        return view('booking.booking-calendar');
    }

    /**
     * Summary
     * get employee service schedule for schedule table/calendar
     * @sch_employee_id,@cmn_branch_id,@date,@sch_service_booking_id
     * Author: Kaysar
     * Date: 06-dec-2021
     */
    public function getEmployeeSchedule(Request $request)
    {
        try {
            $bookingRepo = new BookingRepository();
            $data = $bookingRepo->getEmployeeBookingSchedule($request->cmn_branch_id, $request->sch_employee_id, $request->cmn_customer_id, $request->date, 0);
            return $this->apiResponse($data, 200);
        } catch (Exception $ex) {
            return $this->apiResponse(['status' => '403', 'data' => $ex], 400);
        }
    }

    /**
     * Summary
     * get booking info by booking id
     * Author: Kaysar
     * Date: 06-dec-2021
     */
    public function getBookingInfoByServiceId(Request $request)
    {
        try {
            $bookingService = SchServiceBooking::join('cmn_customers', 'sch_service_bookings.cmn_customer_id', '=', 'cmn_customers.id')
                ->join('sch_services', 'sch_service_bookings.sch_service_id', '=', 'sch_services.id')
                ->join('cmn_branches', 'sch_service_bookings.cmn_branch_id', '=', 'cmn_branches.id')
                ->join('sch_employees', 'sch_service_bookings.sch_employee_id', '=', 'sch_employees.id')
                ->where('sch_service_bookings.id', $request->sch_service_booking_id)
                ->select(
                    'sch_service_bookings.id',
                    'cmn_branches.name as branch',
                    'sch_service_bookings.cmn_branch_id',
                    'sch_employees.full_name as employee',
                    'sch_service_bookings.sch_employee_id',
                    'cmn_customers.full_name as customer',
                    'sch_service_bookings.cmn_customer_id',
                    'cmn_customers.phone_no',
                    'cmn_customers.email',
                    'sch_service_bookings.date',
                    'sch_service_bookings.sch_service_id',
                    'sch_services.title as service',
                    'sch_services.sch_service_category_id',
                    'sch_service_bookings.start_time',
                    'sch_service_bookings.end_time',
                    'sch_service_bookings.paid_amount',
                    'sch_service_bookings.status',
                    'sch_service_bookings.remarks',
                    'sch_service_bookings.created_at',
                    'sch_service_bookings.cmn_payment_type_id',
                    'sch_service_bookings.remarks',
                    'sch_employees.specialist',
                    'sch_employees.image_url'
                )->first();
            return $this->apiResponse(['status' => '1', 'data' => $bookingService], 200);
        } catch (Exception $ex) {
            return $this->apiResponse(['status' => '403', 'data' => $ex], 400);
        }
    }



    /**
     * Summary
     * save booking service from admin panel
     * Author: Kaysar
     * Date: 06-dec-2021
     */
    public function saveBooking(Request $request)
    {
        try {
            $bookingRepo = new BookingRepository();

            //get employee wise service charge
            $serviceCharge = SchEmployeeService::where('sch_employee_id', $request->sch_employee_id)
                ->where('sch_service_id', $request->sch_service_id)->select('fees')->first();
            if ($serviceCharge == null)
                return $this->apiResponse(['status' => '-1', 'data' => "This service is not avaiable please try another one."], 400);

            $serviceTime = explode('-', $request->service_time);
            $serviceStartTime = $serviceTime[0];
            $serviceEndTime = $serviceTime[1];

            //check service is booked or not
            if ($bookingRepo->serviceIsAvaiable($request->sch_service_id, $request->sch_employee_id, $request->service_date, $serviceStartTime, $serviceEndTime) > 0 && $request->isForceBooking == 0)
                return $this->apiResponse(['status' => '-1', 'data' => "The selected service is bocked. Do you want to add another one this time?"], 200);

            //check servicce limitation
            $serviceLimitation = $bookingRepo->IsServiceLimitation($request->service_date, $request->cmn_customer_id, $request->sch_service_id, 1, 1);
            if ($serviceLimitation['allow'] < 1 && $request->isForceBooking == 0)
                return $this->apiResponse(['status' => '-1', 'data' => $serviceLimitation['message'] . " Do you want to add forchly?"], 200);

            $paymentStatus = ServicePaymentStatus::Unpaid;
            if ($request->paid_amount >= $serviceCharge->fees) {
                $paymentStatus = ServicePaymentStatus::Paid;
            } else if ($request->paid_amount > 0) {
                $paymentStatus = ServicePaymentStatus::PartialPaid;
            }
            $data = [
                'cmn_branch_id' => $request->cmn_branch_id,
                'cmn_customer_id' => $request->cmn_customer_id,
                'sch_employee_id' => $request->sch_employee_id,
                'date' => $request->service_date,
                'start_time' => $serviceStartTime,
                'end_time' => $serviceEndTime,
                'sch_service_id' => $request->sch_service_id,
                'status' => $request->status,
                'service_amount' => $serviceCharge->fees,
                'paid_amount' => $request->paid_amount,
                'payment_status' => $paymentStatus,
                'cmn_payment_type_id' => $request->cmn_payment_type_id,
                'canceled_paid_amount' => 0,
                'cancel_paid_status' => ServiceCancelPaymentStatus::Unpaid,
                'remarks' => $request->remarks,
                'created_by' => auth()->id()
            ];
            $saveBooking = SchServiceBooking::create($data);
            $bookingData = $bookingRepo->getEmployeeBookingSchedule($request->cmn_branch_id, $request->sch_employee_id, 0, null, $saveBooking->id);

            //send notification to user
            if ($request->email_notify != null && UtilityRepository::isEmailConfigured()) {
                $customer = CmnCustomer::where('id', $request->cmn_customer_id)->select('email', 'user_id')->first();
                if ($customer != null && $customer->user_id != null) {
                    $user = User::where('id', $customer->user_id)->first();
                    $serviceDate = new Carbon($request->service_date);
                    $serviceMessage = [
                        'user_name' => $user->name,
                        'message_subject' => 'Booking ' . UtilityRepository::serviceStatus($request->status) . ' Notification',
                        'message_body' => 'Your service request is ' . UtilityRepository::serviceStatus($request->status).'.',
                        'booking_info' => ' Booking No#' . $saveBooking->id . ', Service Date# ' . $serviceDate->format('D, M d, Y') . ' at ' . $serviceStartTime . ' to ' . $serviceEndTime,
                        'message_footer' => 'Thanks you for choosing our service.',
                        'action_url' => url('/client-dashboard')
                    ];
                    Notification::send($user, new ServiceBookingNotification($serviceMessage));
                }
            }
            return $this->apiResponse(['status' => '1', 'data' => $bookingData], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '501', 'data' => $qx], 400);
        }
    }

    /**
     * Summary
     * update booking service from admin panel
     * Author: Kaysar
     * Date: 11-dec-2021
     */
    public function updateBooking(Request $request)
    {
        try {
            $bookingRepo = new BookingRepository();

            //get employee wise service charge
            $serviceCharge = SchEmployeeService::where('sch_employee_id', $request->sch_employee_id)
                ->where('sch_service_id', $request->sch_service_id)->select('fees')->first();
            if ($serviceCharge == null)
                return $this->apiResponse(['status' => '-1', 'data' => "This service is not avaiable please try another one."], 400);

            $serviceTime = explode('-', $request->service_time);
            $serviceStartTime = $serviceTime[0];
            $serviceEndTime = $serviceTime[1];

            //check service is booked or not
            if ($bookingRepo->serviceIsAvaiable($request->sch_service_id, $request->sch_employee_id, $request->service_date, $serviceStartTime, $serviceEndTime) > 0 && $request->isForceBooking == 0)
                return $this->apiResponse(['status' => '-1', 'data' => "The selected service is bocked. Do you want to add another one this time?"], 200);

            //check servicce limitation
            $serviceLimitation = $bookingRepo->IsServiceLimitation($request->service_date, $request->cmn_customer_id, $request->sch_service_id, 1, 1);
            if ($serviceLimitation['allow'] < 1 && $request->isForceBooking == 0)
                return $this->apiResponse(['status' => '-1', 'data' => $serviceLimitation['message'] . " Do you want to add forchly?"], 200);

            $paymentStatus = ServicePaymentStatus::Unpaid;
            if ($request->paid_amount >= $serviceCharge->fees) {
                $paymentStatus = ServicePaymentStatus::Paid;
            } else if ($request->paid_amount > 0) {
                $paymentStatus = ServicePaymentStatus::PartialPaid;
            }

            $updateData = SchServiceBooking::where('id', $request->id)->update(
                [
                    'cmn_branch_id' => $request->cmn_branch_id,
                    'cmn_customer_id' => $request->cmn_customer_id,
                    'sch_employee_id' => $request->sch_employee_id,
                    'date' => $request->service_date,
                    'start_time' => $serviceStartTime,
                    'end_time' => $serviceEndTime,
                    'sch_service_id' => $request->sch_service_id,
                    'status' => $request->status,
                    'service_amount' => $serviceCharge->fees,
                    'paid_amount' => $request->paid_amount,
                    'payment_status' => $paymentStatus,
                    'cmn_payment_type_id' => $request->cmn_payment_type_id,
                    'canceled_paid_amount' => 0,
                    'cancel_paid_status' => ServiceCancelPaymentStatus::Unpaid,
                    'remarks' => $request->remarks,
                    'updated_by' => auth()->id()
                ]
            );
            $bookingData = $bookingRepo->getEmployeeBookingSchedule($request->cmn_branch_id, $request->sch_employee_id, 0, null, $request->id);

            //send notification to user
            if ($request->email_notify != null && UtilityRepository::isEmailConfigured()) {
                $customer = CmnCustomer::where('id', $request->cmn_customer_id)->select('email', 'user_id')->first();
                if ($customer != null && $customer->user_id != null) {
                    $user = User::where('id', $customer->user_id)->first();
                    $serviceDate = new Carbon($request->service_date);
                    $serviceMessage = [
                        'user_name' => $user->name,
                        'message_subject' => 'Booking ' . UtilityRepository::serviceStatus($request->status) . ' Notification',
                        'message_body' => 'Your service request is ' . UtilityRepository::serviceStatus($request->status).'.',
                        'booking_info' => ' Booking No#' . $request->id . ', Service Date# ' . $serviceDate->format('D, M d, Y') . ' at ' . $serviceStartTime . ' to ' . $serviceEndTime,
                        'message_footer' => 'Thanks you for choosing our service.',
                        'action_url' => url('/client-dashboard')
                    ];
                    Notification::send($user, new ServiceBookingNotification($serviceMessage));
                }
            }

            return $this->apiResponse(['status' => '1', 'data' => $bookingData], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '501', 'data' => $qx], 400);
        }
    }

    /**
     * Summary
     * cancel booking service from admin panel
     * Author: Kaysar
     * Date: 11-dec-2021
     */
    public function cancelBooking(Request $request)
    {
        try {
            $bookingRepo = new BookingRepository();
            return $this->apiResponse(['status' => '1', 'data' => $bookingRepo->ChangeBookingStatusAndReturnBookingData($request->id, ServiceStatus::Cancel,$request->email_notify)], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '501', 'data' => $qx], 400);
        }
    }

    public function doneBooking(Request $request)
    {
        try {
            $bookingRepo = new BookingRepository();
            return $this->apiResponse(['status' => '1', 'data' => $bookingRepo->ChangeBookingStatusAndReturnBookingData($request->id, ServiceStatus::Done,$request->email_notify)], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '501', 'data' => $qx], 400);
        }
    }


    /**
     * Summary
     * delete booking service from admin panel
     * Author: Kaysar
     * Date: 11-dec-2021
     */
    public function deleteBooking(Request $request)
    {
        try {
            SchServiceBooking::where('id', $request->id)->delete();
            return $this->apiResponse(['status' => '1', 'data' => ''], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '501', 'data' => $qx], 400);
        }
    }

    public function getEmployeeByService(Request $request)
    {
        try {

            $bookingRepo = new BookingRepository();
            $rtr = $bookingRepo->getEmployeeByService($request->sch_service_id, $request->cmn_branch_id,[1,2]);
            return $this->apiResponse(['status' => '1', 'data' => $rtr], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '403', 'data' => $qx], 400);
        }
    }
}
