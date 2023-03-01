<?php

namespace App\Http\Controllers\Site;

use Exception;
use Carbon\Carbon;
use App\Enums\PaymentType;
use App\Enums\ServiceStatus;
use Illuminate\Http\Request;
use App\Enums\ServiceVisibility;
use App\Models\Settings\CmnBranch;
use App\Enums\ServicePaymentStatus;
use App\Http\Controllers\Controller;
use App\Models\Customer\CmnCustomer;
use App\Models\Payment\CmnPaymentType;
use App\Models\Settings\CmnBusinessHour;
use App\Enums\ServiceCancelPaymentStatus;
use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Repository\Booking\BookingRepository;
use App\Http\Repository\Dashboard\DashboardRepository;
use App\Models\Booking\SchServiceBooking;
use App\Models\Employee\SchEmployeeOffday;
use App\Http\Repository\DateTimeRepository;
use App\Http\Repository\Language\LanguageRepository;
use App\Http\Repository\Payment\PaymentRepository;
use App\Http\Repository\Settings\SettingsRepository;
use App\Http\Repository\UtilityRepository;
use App\Models\Employee\SchEmployeeService;
use App\Models\Services\SchServiceCategory;
use App\Models\Settings\CmnBusinessHoliday;
use App\Models\Employee\SchEmployeeSchedule;
use App\Models\Settings\CmnLanguage;
use App\Models\Settings\CmnTranslation;
use App\Models\User;
use App\Models\Website\SiteAppearance;
use App\Notifications\ClientQueryNotification;
use App\Notifications\ServiceBookingNotification;
use ErrorException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{

    public function index()
    {
        if (UtilityRepository::isSiteInstalled() == false) {
            return view("vendor.installer.welcome");
        } else {
            $websiteCont = new WebsiteController();
            $dashboard = new DashboardRepository();
            return view('site.index', [
                'topService' => $websiteCont->getTopServices(),
                'clientTestimonial' => $websiteCont->getClientTestimonial(),
                'newJoiningEmployee' => $websiteCont->getNewJoiningEmployee(),
                'serviceSummary' => $dashboard->getWebsiteServiceSummary()
            ]);
        }
    }


    public function paymentComplete()
    {
        $data = [
            'message' => 'Successfully completed payment',
            'redirect_link' => 'client.dashboard',
            'redirect_text' => 'Go to dashboard'
        ];
        return view('site.success', ['data' => $data]);
    }
    public function unsuccessfulPayment()
    {
        $data = [
            'message' => 'Payment Failed!',
            'redirect_link' => 'client.dashboard',
            'redirect_text' => 'Go to dashboard'
        ];
        return view('site.error', ['data' => $data]);
    }


    public function getServiceCategory()
    {
        try {
            $data = SchServiceCategory::select(
                'id',
                'name'
            )->get();
            return $this->apiResponse(['status' => '1', 'data' => $data], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '403', 'data' => $qx], 400);
        }
    }

    public function getService(Request $request)
    {
        try {
            $bookingRepo = new BookingRepository();
            $data = $bookingRepo->getService($request->sch_service_category_id, ServiceVisibility::PublicService);
            return $this->apiResponse(['status' => '1', 'data' => $data], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '403', 'data' => $qx], 400);
        }
    }

    public function getBranch()
    {
        try {
            $data = CmnBranch::select(
                'id',
                'name'
            )->get();
            return $this->apiResponse(['status' => '1', 'data' => $data], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '403', 'data' => $qx], 400);
        }
    }


    public function getEmployeeService(Request $request)
    {
        try {

            $bookingRepo = new BookingRepository();
            $rtr = $bookingRepo->getEmployeeByService($request->sch_service_id, $request->cmn_branch_id, [1]);
            return $this->apiResponse(['status' => '1', 'data' => $rtr], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '403', 'data' => $qx], 400);
        }
    }


    public function getServiceTimeSlot(Request $request)
    {
        try {

            $bookingRepo = new BookingRepository();
            $day = (new Carbon($request->date))->format('w');
            $date = $request->date;

            //check employee holiday
            $employeeOffDay = SchEmployeeOffday::where('sch_employee_id', $request->sch_employee_id)
                ->where('start_date', '<=',  $date)->where('end_date', '>=',  $date)->exists();
            if ($employeeOffDay) {
                return $this->apiResponse(['status' => '5', 'data' => "Selected date is Staff Holiday/Leave"], 400);
            }

            //check business holiday
            $businessHoliday = CmnBusinessHoliday::where('cmn_branch_id', $request->cmn_branch_id)
                ->where('start_date', '<=', $date)->where('end_date', '>=', $date)->exists();

            if ($businessHoliday) {
                return $this->apiResponse(['status' => '5', 'data' => "Selected date is business holiday try another one."], 400);
            }

            //check weekly holiday
            $businessHours = CmnBusinessHour::where('is_off_day', 1)->where('cmn_branch_id', $request->cmn_branch_id)->where('day', $day)->exists();
            if ($businessHours) {
                return $this->apiResponse(['status' => '5', 'data' => "Selected date is weekly holiday try another one."], 400);
            }

            //get employee schedule
            $schedule = SchEmployeeSchedule::where('sch_employee_id', $request->sch_employee_id)
                ->where('day', $day)->select(
                    'start_time',
                    'end_time',
                    'break_start_time',
                    'break_end_time',
                )->first();

            //get employee service
            $service = SchEmployeeService::join('sch_services', 'sch_employee_services.sch_service_id', '=', 'sch_services.id')
                ->where('sch_services.id', $request->sch_service_id)
                ->where('sch_employee_services.sch_employee_id', $request->sch_employee_id);

            if (!$request->has('visibility')) {
                $service = $service->where('sch_services.visibility', ServiceVisibility::PublicService);
            }

            $service = $service->select(
                'sch_services.duration_in_days',
                'sch_services.duration_in_time',
                'sch_services.time_slot_in_time',
                'sch_services.padding_time_before',
                'sch_services.padding_time_after',
                'sch_employee_services.fees'
            )->first();


            $avaiableService = array();
            if ($schedule != null && $service != null) {
                $startTimeInMinute = DateTimeRepository::TotalMinuteFromTime($schedule->start_time);
                $breakStartTimeInMinute = DateTimeRepository::TotalMinuteFromTime($schedule->break_start_time);
                $breakEndTimeInMinute = DateTimeRepository::TotalMinuteFromTime($schedule->break_end_time);
                $endTimeInMinute = DateTimeRepository::TotalMinuteFromTime($schedule->end_time);
                $timeSlotInMinute = DateTimeRepository::TotalMinuteFromTime($service->time_slot_in_time);
                $paddingTimeBeforeInMinute = DateTimeRepository::TotalMinuteFromTime($service->padding_time_before);
                $paddingTimeAfterInMinute = DateTimeRepository::TotalMinuteFromTime($service->padding_time_after);

                //get time slot before break time
                $serviceStartTimeBefore = $startTimeInMinute + $paddingTimeBeforeInMinute;
                $serviceEndTimeAfter = $breakStartTimeInMinute + $paddingTimeAfterInMinute;
                for ($sTime = $serviceStartTimeBefore; $sTime <= $serviceEndTimeAfter; $sTime = ($sTime + $timeSlotInMinute + $paddingTimeAfterInMinute + $paddingTimeBeforeInMinute)) {
                    $serviceEndTimeInMinute = $sTime + $timeSlotInMinute;
                    if ($breakStartTimeInMinute >= $serviceEndTimeInMinute) {
                        $avaiableService[] = [
                            'start_time' => DateTimeRepository::MinuteToTime($sTime),
                            'end_time' => DateTimeRepository::MinuteToTime($serviceEndTimeInMinute),
                            'is_avaiable' => 1
                        ];
                    }
                }

                //get time slot after break end time
                $serviceStartTimeBefore = $breakEndTimeInMinute + $paddingTimeBeforeInMinute;
                $serviceEndTimeAfter = $endTimeInMinute + $paddingTimeAfterInMinute;
                for ($sTime = $serviceStartTimeBefore; $sTime <= $serviceEndTimeAfter; $sTime = ($sTime + $timeSlotInMinute + $paddingTimeAfterInMinute + $paddingTimeBeforeInMinute)) {
                    $serviceEndTimeInMinute = $sTime + $timeSlotInMinute;
                    if ($endTimeInMinute >= $serviceEndTimeInMinute) {
                        $avaiableService[] = [
                            'start_time' => DateTimeRepository::MinuteToTime($sTime),
                            'end_time' => DateTimeRepository::MinuteToTime($serviceEndTimeInMinute),
                            'is_avaiable' => 1
                        ];
                    }
                }

                //check service is avaiable or not
                foreach ($avaiableService as $key => $val) {
                    if ($bookingRepo->serviceIsAvaiable($request->sch_service_id, $request->sch_employee_id, $date, $val['start_time'], $val['end_time']) > 0)
                        $avaiableService[$key]['is_avaiable'] = 0;
                }
                return $this->apiResponse(['status' => '1', 'data' => $avaiableService], 200);
            } else {
                return $this->apiResponse(['status' => '2', 'data' => 'Service is not avaiable today'], 400);
            }
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '403', 'data' => $qx], 400);
        }
    }

    public function getPaymentType()
    {
        try {
            $payRp=new PaymentRepository();
            return $this->apiResponse(['status' => '1', 'data' => $payRp->getPaymentMethod()], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '403', 'data' => $qx], 400);
        }
    }

    public function cancelBooking(Request $request)
    {
        return  $this->cancelService($request->serviceBookingId);
    }


    public function cancelService($serviceBookingId)
    {
        try {
            $bookedService = SchServiceBooking::where('id', $serviceBookingId)->first();
            $bookedService->status = ServiceStatus::Cancel;
            $bookedService->update();
            return $this->apiResponse(['status' => '1', 'data' => ""], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '403', 'data' => $qx], 400);
        }
    }


    public function saveBooking(Request $request)
    {
        try {
            $bookingRepo = new BookingRepository();
            $customerId = 0;
            $customer = "";

            //if login by user
            if (auth()->check()) {
                $customer = CmnCustomer::where('user_id', auth()->id())->select('id')->first();
            } else {
                $customer = CmnCustomer::where('phone_no', $request->phone_no)->orWhere('email', $request->email)->select('id')->first();
            }
            if ($customer != null) {
                $customerId = $customer->id;
            } else {
                $saveCustomer = [
                    'full_name' => $request->full_name,
                    'phone_no' => $request->phone_no,
                    'email' => $request->email,
                    'state' => $request->state,
                    'postal_code' => $request->postal_code,
                    'city' => $request->city,
                    'street_address' => $request->street_address
                ];
                $cstRtrn = CmnCustomer::create($saveCustomer);
                $customerId = $cstRtrn->id;
            }

            //customer creation/get failed
            if ($customerId == 0)
                return $this->apiResponse(['status' => '-1', 'data' => "Failed to save or get customer."], 400);

            //get employee wise service charge
            $serviceCharge = SchEmployeeService::where('sch_employee_id', $request->sch_employee_id)
                ->where('sch_service_id', $request->sch_service_id)->select('fees')->first();
            if ($serviceCharge == null)
                return $this->apiResponse(['status' => '-1', 'data' => "This service is not avaiable please try another one."], 400);

            $serviceTime = explode('-', $request->service_time);
            $serviceStartTime = $serviceTime[0];
            $serviceEndTime = $serviceTime[1];

            //check service is booked or not
            if ($bookingRepo->serviceIsAvaiable($request->sch_service_id, $request->sch_employee_id, $request->service_date, $serviceStartTime, $serviceEndTime) > 0)
                return $this->apiResponse(['status' => '-1', 'data' => "The selected service is bocked try another one."], 400);

            //check servicce limitation
            $serviceLimitation = $bookingRepo->IsServiceLimitation($request->service_date, $customerId, $request->sch_service_id, 1, 1);
            if ($serviceLimitation['allow'] < 1)
                return $this->apiResponse(['status' => '-1', 'data' => $serviceLimitation['message']], 400);

            $serviceStatus = ServiceStatus::Pending;
            if ($request->payment_type == PaymentType::LocalPayment) {
                $serviceStatus = ServiceStatus::Processing;
            }
            $data = [
                'cmn_branch_id' => $request->cmn_branch_id,
                'cmn_customer_id' => $customerId,
                'sch_employee_id' => $request->sch_employee_id,
                'date' => $request->service_date,
                'start_time' => $serviceStartTime,
                'end_time' => $serviceEndTime,
                'sch_service_id' => $request->sch_service_id,
                'status' => $serviceStatus,
                'service_amount' => $serviceCharge->fees,
                'paid_amount' => 0,
                'payment_status' => ServicePaymentStatus::Unpaid,
                'cmn_payment_type_id' => $request->payment_type,
                'canceled_paid_amount' => 0,
                'cancel_paid_status' => ServiceCancelPaymentStatus::Unpaid,
                'remarks' => $request->service_remarks,
                'created_by' => $customerId
            ];
            $rtrServiceBooking = SchServiceBooking::create($data);

            //send notification to user
            if (UtilityRepository::isEmailConfigured()) {
                $serviceDate = new Carbon($request->service_date);
                $user = '';
                if (auth()->check()) {
                    $user = auth()->user();
                } else {
                    $user = User::first();
                    $user->email = $request->email;
                    $user->phone_no = $request->phone_no;
                    $user->full_name = $request->full_name;
                }
                $paypalAddtionalMessage = $request->payment_type == PaymentType::Paypal ? "to confirm your booking please pay." : "";
                $serviceMessage = [
                    'user_name' => $user->name,
                    'message_subject' => 'Booking ' . UtilityRepository::serviceStatus($serviceStatus) . ' Notification',
                    'message_body' => 'Your service request is ' . UtilityRepository::serviceStatus($serviceStatus) . ', ' . $paypalAddtionalMessage,
                    'booking_info' => ' Booking No#' .  $rtrServiceBooking->id . ', Service Date# ' . $serviceDate->format('D, M d, Y') . ' at ' . $serviceStartTime . ' to ' .  $serviceEndTime,
                    'message_footer' => 'Thanks you for choosing our service.',
                    'action_url' => url('/client-dashboard')
                ];
                Notification::send($user, new ServiceBookingNotification($serviceMessage));
            }

            if ($request->payment_type == PaymentType::Paypal) {
                //paypal payment
                $paypal = new PaypalController();
                $paypalReturn = $paypal->checkout($serviceCharge->fees, "ServiceCharge", $rtrServiceBooking->id);
                return $this->apiResponse(['status' => 1, 'paymentType' => 'paypal', 'data' => ['serviceBookingId' => $rtrServiceBooking->id, 'returnUrl' => $paypalReturn]], 200);
            } else if ($request->payment_type == PaymentType::Stripe) {
                //stripe payment
                $stripe = new StripeController();
                $stripeRtr = $stripe->checkout($serviceCharge->fees, "ServiceCharge", $rtrServiceBooking->id);
                return $this->apiResponse(['status' => 1, 'paymentType' => 'stripe', 'data' => ['serviceBookingId' => $rtrServiceBooking->id, 'returnUrl' => $stripeRtr]], 200);
            } else {
                //local payment
                return $this->apiResponse(['status' => 1, 'paymentType' => 'localPayment', 'data' => "successfully save"], 200);
            }
        } catch (ErrorException $ex) {
            return $this->apiResponse(['status' => '-501', 'data' => $ex->getMessage()], 400);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '501', 'data' => $qx], 400);
        }
    }

    public function getLoginCustomerInfo()
    {
        try {
            if (auth()->check()) {
                $settingRepo = new SettingsRepository();
                return $this->apiResponse(['status' => '1', 'data' => $settingRepo->getCustomer(auth()->id())], 200);
            }
            return $this->apiResponse(['status' => '0', 'data' => 'no data found'], 200);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '501', 'data' => $qx], 400);
        }
    }

    public function serviceDuePayment(Request $request)
    {
        try {
            $bookingInfo = SchServiceBooking::where('id', $request->bookingId)->select('service_amount', 'paid_amount', 'status')->first();
            if ($bookingInfo != null) {
                $dueAmount = $bookingInfo->service_amount - $bookingInfo->paid_amount;
                if ($bookingInfo->status != ServiceStatus::Cancel && $bookingInfo->status != ServiceStatus::Done && $dueAmount > 0) {
                    if ($request->paymentType == PaymentType::Paypal) {
                        //paypal payment
                        $paypal = new PaypalController();
                        $paypalReturn = $paypal->checkout($dueAmount, "ServiceCharge", $request->bookingId);
                        return $this->apiResponse(['status' => 1, 'paymentType' => 'paypal', 'data' => ['serviceBookingId' => $request->bookingId, 'returnUrl' => $paypalReturn]], 200);
                    } else if ($request->paymentType == PaymentType::Stripe) {
                        //stripe payment
                        $stripe = new StripeController();
                        $stripeRtr = $stripe->checkout($dueAmount, "ServiceCharge", $request->bookingId);
                        return $this->apiResponse(['status' => 1, 'paymentType' => 'stripe', 'data' => ['serviceBookingId' => $request->bookingId, 'returnUrl' => $stripeRtr]], 200);
                    }
                }
                throw new ErrorException("This service is not available to payment.");
            }
            throw new ErrorException("Invalid payment request or changed url.");
        } catch (ErrorException $ex) {
            return $this->apiResponse(['status' => '-501', 'data' => $ex->getMessage()], 400);
        } catch (Exception $qx) {
            return $this->apiResponse(['status' => '501', 'data' => $qx], 400);
        }
    }


    public function sendClientNotification(Request $request)
    {
        try {
            //send notification to user
            if (UtilityRepository::isEmailConfigured()) {
                $apperance = SiteAppearance::select('contact_email', 'app_name', 'contact_phone')->first();

                $user = User::first();
                $user->email = $apperance->contact_email;
                $user->phone_no = $apperance->contact_phone;
                $user->full_name = $apperance->app_name;

                $serviceMessage = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'subject' => $request->subject,
                    'message' => $request->message
                ];
                Notification::send($user, new ClientQueryNotification($serviceMessage));
                return $this->apiResponse(['status' => '1', 'data' => ''], 200);
            }
            return $this->apiResponse(['status' => '-501', 'data' => 'Failed to send email'], 400);
        } catch (Exception $ex) {
            return $this->apiResponse(['status' => '501', 'data' => $ex], 400);
        }
    }

    public function changeLanguage(Request $request)
    {
        try {
            $langRepo = new LanguageRepository();
            $langRepo->setLangaugeSession($request->lang_id);
           
            return redirect()->back();
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
