<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Exibe a página com os produtos favoritos do usuário.
     */
    public function index()
    {
        // Pega os produtos favoritos do usuário logado
        $products = Auth::user()->favorites()->latest()->paginate(9);

        // Carrega os favoritos do usuário para o estado do botão
        // (Nesta página, todos estarão favoritados)
        $userFavorites = $products->keyBy('id');

        // Retorna a view, passando os produtos
        return view('favorites.index', compact('products', 'userFavorites'));
    }

    /**
     * Adiciona ou remove um produto dos favoritos do usuário.
     */
    public function toggle(Product $product)
    {
        $user = Auth::user();

        // O método toggle faz o trabalho de "attach" (anexar) ou "detach" (desanexar)
        $user->favorites()->toggle($product->id);

        // Redireciona de volta para a página anterior
        return back()->with('success', 'Lista de favoritos atualizada!');
    }
}