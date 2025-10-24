@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Meu Carrinho</h1>

    @if(Cart::getContent()->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach(Cart::getContent() as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ number_format($item->price) }}</td>
                        <td>R$ {{ $item->quantity }}</td>
                        <td>R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-end fw-bold">Total:</td>
                    <td class="fw-bold">R$ {{ number_format(Cart::getTotal(), 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <a href="{{ route('checkout.index') }}" class="btn btn-primary">Finalizar Compra</a>

    @else
        <p>Seu carrinho está vazio.</p>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Voltar para Produtos</a>
    @endif
</div>
@endsection
