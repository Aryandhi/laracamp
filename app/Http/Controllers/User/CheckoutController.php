<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Camps;
use App\Models\Checkouts;
use Illuminate\Http\Request;

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
    public function create(Camps $camps)
    {
        // return $camps;
        return view('checkout', [
            'camps' => $camps
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Camps $camps)
    {
        // return $camps;
        return $request->all();
    }

    /**
     * Display the specified resource.
     */
    public function show(Checkouts $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checkouts $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checkouts $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkouts $checkout)
    {
        //
    }

    public function success() 
    {
        return view('success_checkout');
    }
}
