<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Checkout finalização
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');

    // Histórico de pedidos
    Route::get('/meus-pedidos', [OrderController::class, 'index'])->name('orders.index');
});

// Produtos (acesso aberto)
Route::resource('products', ProductController::class);

// Carrinho (acesso aberto)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');

// Tela de checkout (pode deixar sem login ou adicionar middleware se quiser)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

require __DIR__.'/auth.php';
