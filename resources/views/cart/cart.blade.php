@extends('layouts.app')

@section('content')
{{-- Adiciona um espaçamento vertical (padding) maior no container --}}
<div class="container py-5">

    {{-- Título da Página + Botão "Continuar Comprando" --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0"><i class="bi bi-cart3 me-2"></i>Meu Carrinho</h1>
        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Continuar Comprando
        </a>
    </div>

    @if(Cart::getContent()->count() > 0)

        {{-- MUDANÇA: Envolvemos a tabela em um card para um visual mais limpo --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0"> {{-- p-0 para a tabela preencher --}}

                {{-- MUDANÇA: Adicionado 'table-responsive' --}}
                <div class="table-responsive">
                    {{-- 
                      MUDANÇA: Removido 'table-striped' para um look mais clean.
                      Adicionado 'align-middle' para centralizar verticalmente.
                    --}}
                    <table class="table mb-0 align-middle">
                        
                        {{-- MUDANÇA: Cabeçalho com fundo leve --}}
                        <thead class="table-light">
                            <tr>
                                <th class="py-3 px-4">Produto</th>
                                <th class="py-3 px-4">Quantidade</th>
                                <th class="py-3 px-4">Preço Unitário</th>
                                <th class="py-3 px-4 text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(Cart::getContent() as $item)
                                <tr>
                                    <td class="py-3 px-4">{{ $item->name }}</td>
                                    
                                    {{-- **BUG CORRIGIDO AQUI** --}}
                                    <td class="py-3 px-4">{{ $item->quantity }}</td>
                                    
                                    {{-- **BUG CORRIGIDO AQUI** (e adicionada formatação) --}}
                                    <td class="py-3 px-4">R$ {{ number_format($item->price, 2, ',', '.') }}</td>
                                    
                                    <td class="py-3 px-4 text-end">R$ {{ number_format($item->price * $item->quantity, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- MUDANÇA: Rodapé do card para o Total, dá mais destaque --}}
            <div class="card-footer bg-light p-3">
                <div class="d-flex justify-content-end align-items-center">
                    <span class="h5 me-3 mb-0">Total:</span>
                    <span class="h4 fw-bold text-success mb-0">
                        R$ {{ number_format(Cart::getTotal(), 2, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- MUDANÇA: Botão de finalizar compra maior e alinhado à direita --}}
        <div class="d-flex justify-content-end mt-4">
            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg">
                Finalizar Compra <i class="bi bi-arrow-right-short"></i>
            </a>
        </div>

    @else
        {{-- MUDANÇA: Mensagem de carrinho vazio mais agradável --}}
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
    @endif
</div>
@endsection