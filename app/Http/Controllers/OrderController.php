<?php

namespace App\Http\Controllers;

use App\Models\Order; // Importar o Model Order
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Para pegar o usuário logado

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
       
        $orders = Auth::user()->orders()->with('items')->latest()->paginate(10);

        return view('orders.index', compact('orders'));
    }

    
    public function show(Order $order)
    {
       
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.'); 
        }

        
        $order->load('items.product'); 

        // Retorna a view 'orders.show' passando o pedido com seus itens carregados
        return view('orders.show', compact('order'));
    }
}