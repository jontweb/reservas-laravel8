<?php

namespace App\Http\Controllers\Payment;

use App\Enums\PaymentType;
use App\Enums\ServicePaymentStatus;
use App\Enums\ServiceStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\SiteController;
use App\Http\Repository\UtilityRepository;
use App\Models\Booking\SchServiceBooking;
use Illuminate\Http\Request;
use App\Models\Payment\CmnPaypalApiConfig;
use App\Models\User;
use App\Notifications\ServiceBookingNotification;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalHttp\HttpException;



class PaypalController extends Controller
{
    public function checkout($amount, $paymentType, $refNo)
    {
        try {
            $paypalConfig = CmnPaypalApiConfig::select('client_id', 'client_secret', 'sandbox')->first();
            if ($paypalConfig == null)
                throw new ErrorException(translate('You do not have paypal configure.'));
            $clientId = $paypalConfig->client_id;
            $clientSecret = $paypalConfig->client_secret;
            $environment = new SandboxEnvironment($clientId, $clientSecret);
            if ($paypalConfig->sandbox == 0) {
                $environment = new ProductionEnvironment($clientId, $clientSecret);
            }
            $client = new PayPalHttpClient($environment);


            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = [
                "intent" => "CAPTURE",
                "purchase_units" => [[
                    "reference_id" => $refNo,
                    "amount" => [
                        "value" => $amount,
                        "currency_code" => "USD"
                    ]
                ]],
                "application_context" => [
                    "cancel_url" => url('paypal/payment/cancel'),
                    "return_url" => url('paypal-payment-done')
                ]
            ];


            // Call API with your client and get a response for your call
            $response = $client->execute($request);

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            if ($response->statusCode == 201) {
                Session::put('paypal_order_info', ['paymentType' => $paymentType, 'refNo' => $refNo]);
                return ['status' => 201, 'data' => $response->result];
            } else {
                //cancel order                
                return ['status' => -101, 'message' => "Failed to generate payment"];
            }
        } catch (HttpException $ex) {
            return ['status' => $ex->statusCode, 'message' => $ex->getMessage()];
        }
    }


    public function done(Request $responseData)
    {
        try {
            $paypalConfig = CmnPaypalApiConfig::select('client_id', 'client_secret', 'sandbox')->first();

            $clientId = $paypalConfig->client_id;
            $clientSecret = $paypalConfig->client_secret;
            $environment = new SandboxEnvironment($clientId, $clientSecret);
            if ($paypalConfig->sandbox == 0) {
                $environment = new ProductionEnvironment($clientId, $clientSecret);
            }

            $client = new PayPalHttpClient($environment);
            $request = new OrdersCaptureRequest($responseData->token);
            $request->prefer('return=representation');

            // Call API with your client and get a response for your call
            $response = $client->execute($request);
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            if ($response->statusCode == 201) {
                if (Session::get("paypal_order_info")['paymentType'] == "ServiceCharge") {
                    $this->updateServicePaymentInfo($response->result);
                    Session::forget("paypal_order_info");
                    return redirect()->route('payment.complete');
                } else {
                    return redirect()->route('cancel.paypal.payment');
                }
            }
            return redirect()->route('cancel.paypal.payment');
        } catch (HttpException $ex) {
            return ['status' => $ex->statusCode, 'message' => $ex->getMessage()];
        }
    }

    public function updateServicePaymentInfo($response)
    {
        $serviceBoockedId = $response->purchase_units[0]->reference_id;
        $bookedService = SchServiceBooking::where('id', $serviceBoockedId)->first();
        $bookedService->paid_amount = $response->purchase_units[0]->amount->value;
        $bookedService->payment_status = ServicePaymentStatus::Paid;
        $bookedService->status = ServiceStatus::Approved;
        $bookedService->update();
        $bookedService->payments()->create(
            [
                'payment_type' => PaymentType::Paypal,
                'payment_amount' => $response->purchase_units[0]->amount->value,
                'payment_fee' => $response->purchase_units[0]->payments->captures[0]->seller_receivable_breakdown->paypal_fee->value,
                'currency_code' => $response->purchase_units[0]->amount->currency_code,
                'payee_email_address' => $response->purchase_units[0]->payee->email_address,
                'payee_crd_no' => '',
                'payment_create_time' => $response->create_time,
                'payment_details' => json_encode($response->purchase_units),
                'order_id' => $response->id
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
        if (Session::has("paypal_order_info")) {
            $refNo = Session::get("paypal_order_info")['refNo'];
            $siteCon = new SiteController();
            $siteCon->cancelService($refNo);
            Session::forget("paypal_order_info");
        }
        return redirect()->route('unsuccessful.payment');
    }
}
