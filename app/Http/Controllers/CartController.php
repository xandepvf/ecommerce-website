<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use Darryldecode\Cart\Facades\CartFacade as Cart; 

class CartController extends Controller
{
    
    public function index()
    {
        
        $cartItems = Cart::getContent(); 
        return view('cart.cart', compact('cartItems')); 
    }

   
    public function addToCart(Request $request, $id) 
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->back()->with('error', 'Produto não encontrado!'); 
        }

        Cart::add([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $request->input('quantity', 1), 
            'attributes' => [
                'image' => $product->image 
            ]
        ]);

        return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho!');
    }


    
    public function update(Request $request, $id) 
    {
        $request->validate([
            'quantity' => 'required|integer|min:1' 
        ]);

        Cart::update($id, [
            'quantity' => [
                'relative' => false, 
                'value' => $request->quantity
            ],
        ]);

        return redirect()->route('cart.index')->with('success', 'Quantidade atualizada no carrinho!');
    }

    
    public function remove($id) 
    {
        Cart::remove($id);

        return redirect()->route('cart.index')->with('success', 'Produto removido do carrinho!');
    }
}