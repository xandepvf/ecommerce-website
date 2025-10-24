@extends('layouts.app')

@section('content')
<div class="container py-5">
    
    {{-- Cabeçalho com ID do Pedido e Data --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Detalhes do Pedido #{{ $order->id }}</h1>
        <span class="text-muted">Feito em: {{ $order->created_at->format('d/m/Y H:i') }}</span>
    </div>

    {{-- Card Principal --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <span>Status: 
                 @php
                    $statusClass = 'bg-secondary'; // Padrão
                    if (strtolower($order->status) == 'pago' || strtolower($order->status) == 'concluído' || strtolower($order->status) == 'entregue') {
                        $statusClass = 'bg-success';
                    } elseif (strtolower($order->status) == 'pendente' || strtolower($order->status) == 'processando') {
                        $statusClass = 'bg-warning text-dark';
                    } elseif (strtolower($order->status) == 'cancelado') {
                        $statusClass = 'bg-danger';
                    }
                @endphp
                <span class="badge rounded-pill {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
            </span>
            <span class="fw-bold">Total: R$ {{ number_format($order->total, 2, ',', '.') }}</span>
        </div>
        
        <div class="card-body">
            <h5 class="card-title mb-3">Itens Comprados</h5>

            {{-- Lista de Itens --}}
            <ul class="list-group list-group-flush">
                @foreach ($order->items as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <div class="d-flex align-items-center">
                             {{-- Imagem do Produto --}}
                             @php
                                $imageUrl = $item->product && $item->product->image 
                                            ? asset('storage/' . $item->product->image) 
                                            : 'https://via.placeholder.com/50?text=Img';
                            @endphp
                             <img src="{{ $imageUrl }}" alt="{{ $item->product->name ?? 'Produto' }}" class="img-thumbnail me-3" style="width: 50px; height: 50px; object-fit: contain;">
                            
                            {{-- Nome e Quantidade --}}
                            <div>
                                <span class="fw-medium">{{ $item->product->name ?? 'Produto Indisponível' }}</span> <br>
                                <small class="text-muted">Quantidade: {{ $item->quantity }}</small>
                            </div>
                        </div>
                        {{-- Preço Total do Item --}}
                        <span class="text-end">
                            R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }} <br>
                             <small class="text-muted">(R$ {{ number_format($item->price, 2, ',', '.') }} cada)</small>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="card-footer bg-white text-end">
             {{-- Botão para voltar para a lista de pedidos --}}
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar para Meus Pedidos
            </a>
        </div>
    </div>

</div>
@endsection