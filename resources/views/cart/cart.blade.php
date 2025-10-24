@extends('layouts.app')

@section('content')
<div class="container py-5">
    {{-- Título e botão Continuar Comprando --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="bi bi-cart3 me-2"></i>Meu Carrinho</h1>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Continuar Comprando
        </a>
    </div>

    {{-- Mensagens de sucesso --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(Cart::getContent()->count() > 0)
        <div class="row">
            {{-- Coluna da Lista de Itens --}}
            <div class="col-lg-8">
                @foreach(Cart::getContent() as $item)
                <div class="card mb-3 shadow-sm border-0">
                    <div class="row g-0">

                        {{-- *** AQUI É EXIBIDA A IMAGEM *** --}}
                        <div class="col-md-2 d-flex align-items-center justify-content-center p-2">
                            @php
                                // Verifica se o atributo 'image' existe e não está vazio
                                $imageUrl = isset($item->attributes['image']) && $item->attributes['image']
                                            ? asset('storage/' . $item->attributes['image']) // Gera a URL a partir do storage/app/public
                                            : 'https://via.placeholder.com/100?text=Sem+Img'; // Imagem padrão
                            @endphp
                            <img src="{{ $imageUrl }}"
                                 class="img-fluid rounded"
                                 alt="{{ $item->name }}"
                                 style="max-height: 100px; max-width: 100px; object-fit: contain;">
                        </div>
                        {{-- *** FIM DA EXIBIÇÃO DA IMAGEM *** --}}


                        {{-- Coluna dos Detalhes (Nome, Preço, Ações) --}}
                        <div class="col-md-10">
                            <div class="card-body">
                                {{-- Nome e Subtotal --}}
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">{{ $item->name }}</h5>
                                    <span class="h5 fw-bold text-success">
                                        R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}
                                    </span>
                                </div>
                                {{-- Preço Unitário --}}
                                <p class="card-text text-muted mb-2">
                                    Preço Unitário: R$ {{ number_format($item->price, 2, ',', '.') }}
                                </p>
                                {{-- Ações (Atualizar/Remover) --}}
                                <div class="d-flex justify-content-between align-items-center">
                                    {{-- Formulário Atualizar --}}
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control form-control-sm" style="width: 70px;">
                                        <button type="submit" class="btn btn-outline-primary btn-sm ms-2" title="Atualizar Quantidade"><i class="bi bi-arrow-repeat"></i></button>
                                    </form>
                                    {{-- Formulário Remover --}}
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Remover Item"><i class="bi bi-trash-fill"></i> Remover</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Coluna do Resumo do Pedido --}}
            <div class="col-lg-4">
                {{-- Conteúdo do resumo aqui --}}
                <div class="card shadow-sm border-0 sticky-top" style="top: 2rem;">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Resumo do Pedido</h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Subtotal ({{ Cart::getTotalQuantity() }} itens)</span>
                                <span>R$ {{ number_format(Cart::getSubTotal(), 2, ',', '.') }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span>Frete</span>
                                <span class="text-success">Grátis</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 fw-bold h5">
                                <span>Total</span>
                                <span>R$ {{ number_format(Cart::getTotal(), 2, ',', '.') }}</span>
                            </li>
                        </ul>
                        <div class="d-grid gap-2 mt-4">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg">
                                Finalizar Compra <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        {{-- Mensagem de Carrinho Vazio --}}
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm text-center py-5">
                    <div class="card-body">
                         <i class="bi bi-cart-x" style="font-size: 4rem; color: var(--bs-gray-500);"></i>
                        <h3 class="mt-4">Seu carrinho está vazio.</h3>
                        <p class="text-muted">Parece que você ainda não adicionou nenhum produto.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                            <i class="bi bi-shop me-1"></i> Ir para Produtos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection