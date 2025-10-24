<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Cart; // darryldecode cart facade

class CheckoutController extends Controller
{
    public function index()
    {
        // Configura a chave secreta da Stripe
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Pega o total do carrinho (float)
        $amount = (int) (Cart::getTotal() * 100); // em centavos para Stripe

        if ($amount <= 0) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        // Cria o PaymentIntent para a transação
        $intent = PaymentIntent::create([
            'amount' => $amount,
            'currency' => 'brl',
            'payment_method_types' => ['card'],
        ]);

        return view('checkout.index', [
            'clientSecret' => $intent->client_secret,
            'stripeKey' => env('STRIPE_KEY'),
        ]);
    }


    // Método para salvar o pedido após o pagamento ser confirmado no frontend
    public function store(Request $request)
    {
        // Aqui você pode validar os dados, verificar o pagamento etc

        // Pegando itens do carrinho
        $cartItems = Cart::getContent();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Seu carrinho está vazio.');
        }

        $total = Cart::getTotal();

        // Criando o pedido no banco
        $order = auth()->user()->orders()->create([
            'total' => $total,
        ]);

        // Salvar cada item do carrinho como item do pedido
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        // Limpar carrinho após salvar pedido
        Cart::clear();

        return redirect()->route('orders.index')->with('success', 'Pedido realizado com sucesso!');
    }
}
