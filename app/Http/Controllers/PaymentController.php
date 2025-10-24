<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function checkout()
    {
        return view('checkout.index');
    }

    public function processPayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));    $charge = Charge::create([
            'amount' => Cart::total() * 100,
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Order Payment',
        ]);    Cart::destroy();
        return redirect()->route('confirmation');
    }
}
