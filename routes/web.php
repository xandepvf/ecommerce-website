<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController; // <<< ADICIONE ESTE
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Product; // *** ADICIONADO ***

// Rota da Página Inicial
Route::get('/', function () {
    // *** MUDANÇA: Buscar os 3 produtos mais recentes ***
    $featuredProducts = Product::latest()->take(3)->get();
    
    // *** MUDANÇA: Enviar os produtos para a view ***
    return view('home', ['products' => $featuredProducts]);
})->name('home');


// ===== CORREÇÃO DE SEGURANÇA E ORDEM =====
// A listagem de produtos (index) permanece pública,
// pois o 'Route::resource' abaixo (que está protegido)
// agora exclui o 'index'.
Route::get('products', [ProductController::class, 'index'])->name('products.index');


// Grupo de Rotas que Exigem Autenticação
Route::middleware('auth')->group(function () {
    // Rotas de Perfil (do Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rota para processar o pagamento/finalizar o pedido
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');

    // Rota para o Histórico de pedidos do usuário
    Route::get('/meus-pedidos', [OrderController::class, 'index'])->name('orders.index');

    // *** ROTA ADICIONADA: Mostrar detalhes de um pedido específico ***
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show'); 
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // Rota Dashboard (opcional, se você criou a view e rota)
    Route::get('/dashboard', function () {
            return view('dashboard');
    })->name('dashboard');

    // ===== CORREÇÃO DE ORDEM E SEGURANÇA =====
    // O CRUD de produtos (create, store, edit, update, destroy)
    // foi movido para dentro do grupo 'auth' para proteção.
    // Ele vem ANTES do 'products/{product}' para corrigir o erro 404.
    // O 'index' e 'show' são excluídos porque são tratados separadamente.
    Route::resource('products', ProductController::class)->except(['show', 'index']);

    // Rota para ver detalhes do produto, agora exige login
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
});


// Rotas do Carrinho - Acesso Aberto
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add'); // Mantido seu método addToCart
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update'); // Rota para atualizar quantidade
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove'); // Rota para remover item

// Rota para exibir a página de checkout - Acesso Aberto
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// Inclui as rotas de autenticação (login, register, etc.) do Breeze
require __DIR__.'/auth.php';