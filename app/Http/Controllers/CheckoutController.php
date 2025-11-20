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
        // 1. Configura a chave (Certifique-se que está no .env)
        Stripe::setApiKey(config('services.stripe.secret'));

        // 2. Pega o total e converte para centavos
        $total = Cart::getTotal();
        $amount = (int) ($total * 100); 

        // 3. Proteção: Se o carrinho estiver vazio
        if ($amount <= 0) {
            return redirect()->route('cart.index')
                ->with('error', 'Seu carrinho está vazio.');
        }

        // 4. Proteção: Se o valor for absurdo (maior que o limite do Stripe)
        // Isso evita a tela de erro que você mandou no print
        if ($amount >= 99999999) { 
            return redirect()->route('cart.index')
                ->with('error', 'Valor muito alto! Esvazie o carrinho e tente novamente.');
        }

        // 5. Tenta criar o pagamento com segurança
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
            // Se der erro, volta para o carrinho avisando o motivo
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