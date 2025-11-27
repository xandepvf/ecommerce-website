<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
   
    public function index()
    {
        $products = Auth::user()->favorites()->latest()->paginate(9);

       
        $userFavorites = $products->keyBy('id');

        return view('favorites.index', compact('products', 'userFavorites'));
    }

  
    public function toggle(Product $product)
    {
        $user = Auth::user();

        $user->favorites()->toggle($product->id);

        return back()->with('success', 'Lista de favoritos atualizada!');
    }
}