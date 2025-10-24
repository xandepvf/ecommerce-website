@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Your Shopping Cart</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach(Cart::content() as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>${{ $item->price }}</td>
                        <td>${{ $item->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Adicionar ao Carrinho</button>
        </form>

    </div>
@endsection