<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\Checkout;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\Checkout\Store;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
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

        return redirect(route('checkout.success'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Checkout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checkout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkout $checkout)
    {
        //
    }

    public function success() 
    {
        return view('checkout.success');
    }
}
