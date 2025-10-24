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
        // Pega os pedidos do usuário logado, ordenados do mais recente para o mais antigo
        // Carrega a relação 'items' para evitar N+1 queries na view (se precisar mostrar contagem ou algo assim)
        $orders = Auth::user()->orders()->with('items')->latest()->paginate(10); // Adicionado paginate(10)

        return view('orders.index', compact('orders'));
    }

    /**
     * *** NOVO MÉTODO: Display the specified order. ***
     */
    public function show(Order $order)
    {
        // Verificar se o pedido pertence ao usuário logado (Política de Acesso)
        // Isso impede que um usuário veja pedidos de outro apenas adivinhando o ID na URL
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado.'); // Ou redirecionar com erro
        }

        // Carregar os itens do pedido e os produtos relacionados a cada item
        // Isso permite mostrar o nome e imagem do produto na view de detalhes
        $order->load('items.product'); 

        // Retorna a view 'orders.show' passando o pedido com seus itens carregados
        return view('orders.show', compact('order'));
    }
}