<?php

namespace App\Http\Controllers\Payment;

use App\Enums\PaymentType;
use App\Enums\ServicePaymentStatus;
use App\Enums\ServiceStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\SiteController;
use App\Http\Repository\UtilityRepository;
use App\Models\Booking\SchServiceBooking;
use App\Models\Payment\CmnStripeApiConfig;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\ServiceBookingNotification;
use ErrorException;
use Illuminate\Support\Facades\Session;
use PayPalHttp\HttpException;

class StripeController extends Controller
{
    public function checkout($amount, $paymentType, $refNo)
    {
        try {

            $stripeConfig = CmnStripeApiConfig::select('api_key', 'api_secret')->first();
            if ($stripeConfig == null)
                throw new ErrorException(translate('You do not have stripe configure.'));
            $apiKey = $stripeConfig->api_key;
            $apiSecret = $stripeConfig->api_secret;


            \Stripe\Stripe::setApiKey($apiSecret);
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => 'usd',
                            'product_data' => [
                                'name' => "Payment"
                            ],
                            'unit_amount' => ($amount*100),
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => route('stripe.payment.done'),
                'cancel_url' => route('stripe.payment.cancel'),
            ]);
            Session::put('stripe_order_info', [
                'paymentType' => $paymentType,
                'refNo' => $refNo,
                'serviceAmount' =>($amount*100),
                'trnId' => $session->id,
                'currency' => $session->currency,
                'customerEmail' => $session->customer_email
            ]);
            return ['status' => $session->status, 'redirectUrl' => $session->url];
        } catch (HttpException $ex) {
            return ['status' => $ex->statusCode, 'message' => $ex->getMessage()];
        }
    }


    public function done()
    {
        try {
            if (Session::get("stripe_order_info")['paymentType'] == "ServiceCharge") {
                $this->updateServicePaymentInfo();
                Session::forget("stripe_order_info");
                return redirect()->route('payment.complete');
            } else {
                return redirect()->route('cancel.stripe.payment');
            }
        } catch (HttpException $ex) {
            return ['status' => $ex->statusCode, 'message' => $ex->getMessage()];
        }
    }

    public function updateServicePaymentInfo()
    {
        $serviceBoockedId = Session::get("stripe_order_info")['refNo'];
        $bookedService = SchServiceBooking::where('id', $serviceBoockedId)->first();
        $bookedService->paid_amount = Session::get("stripe_order_info")['serviceAmount'];
        $bookedService->payment_status = ServicePaymentStatus::Paid;
        $bookedService->status = ServiceStatus::Approved;
        $bookedService->update();
        $bookedService->payments()->create(
            [
                'payment_type' => PaymentType::Stripe,
                'payment_amount' => Session::get("stripe_order_info")['serviceAmount'],
                'payment_fee' => 0,
                'currency_code' => Session::get("stripe_order_info")['currency'],
                'payee_email_address' => Session::get("stripe_order_info")['customerEmail'],
                'payee_crd_no' => '',
                'payment_create_time' => now(),
                'payment_details' => '',
                'order_id' => Session::get("stripe_order_info")['trnId']
            ]
        );

        //email confirm notification
        if (UtilityRepository::isEmailConfigured()) {
            $serviceDate = new Carbon($bookedService->service_date);
            $user = '';
            if (auth()->check()) {
                $user = auth()->user();
            } else {
                $user = User::first();
                $user->email = $bookedService->email;
                $user->phone_no = $bookedService->phone_no;
                $user->full_name = $bookedService->full_name;
            }
            $serviceMessage = [
                'user_name' => $user->name,
                'message_subject' => 'Booking confirm notification',
                'message_body' => 'Your booking is confirm',
                'booking_info' => ' Booking No#' .  $bookedService->id . ', Service Date# ' . $serviceDate->format('D, M d, Y') . ' at ' . $bookedService->start_time . ' to ' .  $bookedService->end_time,
                'message_footer' => 'Thanks you for choosing our service.',
                'action_url' => url('/client-dashboard')
            ];
            Notification::send($user, new ServiceBookingNotification($serviceMessage));
        }
        return 1;
    }

    public function cancel()
    {
        if (Session::has("stripe_order_info")) {
            $refNo = Session::get("stripe_order_info")['refNo'];
            $siteCon = new SiteController();
            $siteCon->cancelService($refNo);
            Session::forget("paypal_order_info");
        }
        return redirect()->route('unsuccessful.payment');
    }
}
