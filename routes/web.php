<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
// Importante para a rota de limpeza funcionar
use Darryldecode\Cart\Facades\CartFacade as Cart; 

// Rota da Página Inicial
Route::get('/', function () {
    $featuredProducts = Product::latest()->take(3)->get();
    return view('home', ['products' => $featuredProducts]);
})->name('home');

// Rota Pública de Listagem
Route::get('products', [ProductController::class, 'index'])->name('products.index');

// Grupo de Rotas que Exigem Autenticação (Login)
Route::middleware('auth')->group(function () {
    
    // --- Rotas de Perfil ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- Rotas de Checkout e Pedidos ---
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/meus-pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show'); 
    
    // --- Rotas de Favoritos ---
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // --- Rota de Dashboard ---
    Route::get('/dashboard', function () {
            return view('dashboard');
    })->name('dashboard');

    // ============================================================
    // ÁREA ADMINISTRATIVA (Requer middleware 'admin')
    // A ORDEM AQUI É IMPORTANTE: Rotas específicas (create) devem vir antes das genéricas ({product})
    // ============================================================
    Route::middleware('admin')->group(function () {
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); // <-- ESTA VEM PRIMEIRO
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // --- Rota de Detalhes do Produto (Acessível a qualquer logado) ---
    // Esta rota captura "products/{qualquer_coisa}", por isso deve ficar DEPOIS de "products/create"
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show'); 
});

// Rotas do Carrinho - Acesso Aberto
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Rota de Checkout - Acesso Aberto
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// ============================================================
// ROTA DE EMERGÊNCIA (Limpar Carrinho)
// ============================================================
Route::get('/limpar-tudo', function () {
    Cart::clear();
    return redirect()->route('products.index')->with('success', 'Carrinho limpo com sucesso! Tente comprar novamente.');
});

require __DIR__.'/auth.php';