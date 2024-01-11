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
class CheckoutController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Camp $camps, Request $request)
    {
        if ($camps->isRegistered) {
            $request->session()->put('error', "You already registered {$camps->title}");
            return redirect(route('dashboard'));
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

}
