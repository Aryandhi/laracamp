<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\Checkout\Store;
use App\Mail\Checkout\AfterCheckout;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Midtrans;
use Exception;
class CheckoutController extends Controller
{

    public function __construct() {
        Midtrans\Config::$serverKey = env('MIDTRANS_SERVERKEY');
        Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
        Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS');
    }

    public function index()
    {
        //
    }

    public function create(Camp $camps, Request $request)
    {
        if ($camps->isRegistered) {
            $request->session()->put('error', "You already registered {$camps->title}");
            return redirect(route('user.dashboard'));
        }
        return view('checkout.create', [
            'camps' => $camps,
        ]);
    }

    public function store(Store $request, Camp $camps)
    {
        // return $camps;
        // return $request->all();
        // mapping request data
        //get user_id login and camp_id selected
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $data['camp_id'] = $camps->id;

        // update user table when checkout
        // $user = Auth::user();
        $user = User::find(Auth::id());
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->occupation = $data['occupation'];
        $user->save();

        //create table checkouts
        $checkout = Checkout::create($data);
        $this->getSnapRedirect($checkout);

        //sending email
        Mail::to(Auth::user()->email)->send(new AfterCheckout($checkout));

        return redirect(route('checkout.success'));

    }

    public function show(Checkout $checkout)
    {
        //
    }

    public function edit(Checkout $checkout)
    {
        //
    }

    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    public function destroy(Checkout $checkout)
    {
        //
    }

    public function success() 
    {
        return view('checkout.success');
    }

    function getSnapRedirect(Checkout $checkout) {
        $orderId = $checkout->id.'-'.Str::random(5);
        $price = $checkout->Camp->price * 1000;

        $checkout->midtrans_booking_code = $orderId;

        $transaction_details = [
            'order_id' => $orderId,
            'gross_amount' => $price,
        ];

        $item_details[] = [
            'id' => $orderId,
            'price' => $price,
            'quantitiy' => 1,
            'name' => "Payment for {$checkout->Camp->title} Camp"
        ];

        $userData = [
            'first_name' => $checkout->user->name,
            'last_name' => "",
            'address' => $checkout->user->address,
            'city' => "",
            'postal_code' => "",
            'phone' => $checkout->user->phone,
            'country_code' => "IDN",
        ];

        $customer_details = [
            'first_name' => $checkout->user->name,
            'last_name' => "",
            'email' => $checkout->user->email,
            'phone' => $checkout->user->phone,
            'billing_address' => $userData,
            'shipping_address' => $userData,
        ];

        // from array to object
        $midtrans_param = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        ];

        // for hit midtrans
        try {
            // get snap payment page url
            $paymentUrl = \Midtrans\Snap::createTransaction($params)->redirect_url;
            $checkout->midtrans_url = $paymentUrl;
            $checkout->save();

            return $paymentUrl;
        } catch (Exception $e) {
            return false;
        }
    }

    public function midtransCallback(Request $request) 
    {
        $notif = new Midtrans\Notification();

        $transaction_status = $notif->transaction_status;
        $fraud = $notif->fraud_status;

        $checkout_id =explode('-', $notif->order_id[0]);
        $checkout = Checkout::find($checkout_id);

        if ($transaction_status == 'capture') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'challenge'
                $checkout->payment_status = 'pending';
            }
            else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'success'
                $checkout->payment_status = 'paid';
            }
        }
        else if ($transaction_status == 'cancel') {
            if ($fraud == 'challenge') {
                // TODO Set payment status in merchant's database to 'failure'
                $checkout->payment_status = 'failed';
            }
            else if ($fraud == 'accept') {
                // TODO Set payment status in merchant's database to 'failure'
                $checkout->payment_status= 'failed';
            }
        }
        else if ($transaction_status == 'deny') {
            // TODO Set payment status in merchant's database to 'failure'
            $checkout->payment_status='failed';
        }
        else if ($transaction_status == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            $checkout->payment_status='paid';
        }
        else if ($transaction_status == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            $checkout->payment_status='pending';
        }
        else if ($transaction_status == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            $checkout->payment_status='failed';
        }

        $checkout->save();
        return view('checkout/success');
    }

}
