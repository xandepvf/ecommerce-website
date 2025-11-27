<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Darryldecode\Cart\Facades\CartFacade as Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $total = Cart::getTotal();
        $amount = (int) ($total * 100); 

        if ($amount <= 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Seu carrinho está vazio.');
        }

       
        if ($amount >= 99999999) { 
            return redirect()->route('cart.index')
                ->with('error', 'Valor muito alto! Esvazie o carrinho e tente novamente.');
        }

        try {
            $intent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'brl',
                'payment_method_types' => ['card'],
            ]);

            return view('checkout.index', [
                'clientSecret' => $intent->client_secret,
                'stripeKey' => config('services.stripe.key'),
            ]);

        } catch (\Exception $e) {
            return redirect()->route('cart.index')
                ->with('error', 'Erro no Stripe: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $cartItems = Cart::getContent();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Carrinho vazio.');
        }

        $order = auth()->user()->orders()->create([
            'total' => Cart::getTotal(),
        ]);

        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        Cart::clear();

        return redirect()->route('orders.index')->with('success', 'Pedido realizado!');
    }
}