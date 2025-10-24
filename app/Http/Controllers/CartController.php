<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
// Certifique-se de que está usando a Facade correta para o seu pacote de carrinho.
// Se estiver usando darryldecode/cart, use:
use Darryldecode\Cart\Facades\CartFacade as Cart; 
// Se estiver usando outro pacote, ajuste o 'use' statement.

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mostra os itens no carrinho.
     */
    public function index()
    {
        // Use Cart::getContent() para darryldecode/cart
        $cartItems = Cart::getContent(); 
        // Renomeie a view se necessário (ex: 'cart.index')
        return view('cart.cart', compact('cartItems')); 
    }

    /**
     * Add product to cart.
     * Adiciona um produto ao carrinho.
     */
    public function addToCart(Request $request, $id) // Mudei para pegar $id da rota
    {
        $product = Product::find($id); // Encontra o produto pelo ID

        if (!$product) {
            // Se o produto não for encontrado, redireciona de volta com erro
            return redirect()->back()->with('error', 'Produto não encontrado!'); 
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->input('quantity', 1), // Pega a quantidade do form ou default 1
            'attributes' => [
                'image' => $product->image // Guarda o caminho da imagem
            ]
        ]);

        return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho!');
    }


    /**
     * Update the specified resource in storage.
     * Atualiza a quantidade de um item no carrinho.
     */
    public function update(Request $request, $id) // O $id aqui é o ID do item no carrinho
    {
        $request->validate([
            'quantity' => 'required|integer|min:1' // Valida a quantidade
        ]);

        Cart::update($id, [
            'quantity' => [
                'relative' => false, // Define a quantidade absoluta
                'value' => $request->quantity
            ],
        ]);

        return redirect()->route('cart.index')->with('success', 'Quantidade atualizada no carrinho!');
    }

    /**
     * Remove the specified resource from storage.
     * Remove um item do carrinho.
     */
    public function remove($id) // O $id aqui é o ID do item no carrinho
    {
        // *** ESTA É A LINHA QUE FAZ A REMOÇÃO ***
        Cart::remove($id);

        // Redireciona de volta para a página do carrinho com mensagem de sucesso
        return redirect()->route('cart.index')->with('success', 'Produto removido do carrinho!');
    }
}