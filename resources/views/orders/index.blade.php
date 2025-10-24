@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Meus Pedidos</h1>

    @if ($orders->isEmpty())
        <p>Você não possui pedidos realizados.</p>
    @else
        @foreach ($orders as $order)
            <div class="border p-4 mb-6 rounded shadow">
                <strong>Pedido #{{ $order->id }}</strong><br>
                Total: R$ {{ number_format($order->total, 2, ',', '.') }}<br>
                Data: {{ $order->created_at->format('d/m/Y H:i') }}

                <h4 class="mt-3 font-semibold">Itens:</h4>
                <ul class="list-disc list-inside">
                    @foreach ($order->items as $item)
                        <li>{{ $item->product->name }} — Quantidade: {{ number_format($item->price) }} — Preço: R$ {{ $item->quantity }}</li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif

</div>
@endsection
