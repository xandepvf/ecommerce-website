<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Cart;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.cart');
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $quantity = $request->input('quantity', 1);

        Cart::add(
            $product->id,
            $product->name,
            $quantity,
            $product->price
        );

        return redirect()->route('cart.index')->with('success', 'Produto adicionado ao carrinho!');
    }
}
