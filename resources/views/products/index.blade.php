@extends('layouts.app')

@section('content')

{{-- 
  CSS ADICIONADO DIRETAMENTE AQUI 
  para estilizar os cards, como solicitado.
--}}
<style>
    /* 1. Garante que as imagens do card cubram o espaço 
         sem distorcer.
    */
    .card-img-top.fixed-img {
        height: 220px;
        object-fit: cover;
        width: 100%;
    }

    /* 2. Adiciona um efeito suave de "elevação" no card 
         ao passar o mouse.
    */
    .card-hover {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    /* 3. Trunca o texto da descrição em 2 linhas, 
         evitando que cards fiquem com alturas diferentes.
    */
    .text-truncate-lines {
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Número de linhas */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 40px; /* (2 * altura-da-linha) - ajuste conforme sua fonte */
    }

    /* 4. Garante que o link do título não fique sublinhado
         e mantenha a cor padrão.
    */
    .card-title-link {
        text-decoration: none;
        color: inherit;
    }
    .card-title-link:hover {
        color: var(--bs-primary); /* Opcional: muda de cor no hover */
    }
</style>

<div class="container" style="max-width: 1200px;">

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Título + Botão --}}
    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <h1>Catálogo de Produtos</h1>
        {{-- MUDANÇA: Adicionado ícone ao botão --}}
        <a href="{{ route('products.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Novo Produto
        </a>
    </div>

    {{-- Lista de produtos --}}
    <div class="row">
        @forelse($products as $product)
            {{-- MUDANÇA: Colunas mais responsivas (LG 4, MD 6) --}}
            <div class="col-lg-4 col-md-6 mb-4">
                {{-- 
                  MUDANÇA: Card sem borda, com sombra, 
                  efeito hover e posição relativa
                --}}
                <div class="card h-100 border-0 shadow-sm card-hover position-relative">
                    
                    {{-- MUDANÇA: Botão "Like" posicionado no canto da imagem --}}
                    <button class="btn btn-outline-danger btn-sm like-btn position-absolute top-0 end-0 m-2" type="button" style="z-index: 10;">
                        <i class="bi bi-heart"></i>
                    </button>

                    {{-- MUDANÇA: Imagem agora é um link --}}
                    <a href="{{ route('products.show', $product->id) }}">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top fixed-img" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=Sem+Imagem" class="card-img-top fixed-img" alt="Sem imagem">
                        @endif
                    </a>

                    {{-- 
                      MUDANÇA: Corpo do card com d-flex 
                      e padding-bottom 0 
                    --}}
                    <div class="card-body d-flex flex-column pb-0">
                        <h5 class="card-title">
                            {{-- MUDANÇA: Título agora é um link --}}
                            <a href="{{ route('products.show', $product->id) }}" class="card-title-link">
                                {{ $product->name }}
                            </a>
                        </h5>
                        
                        {{-- MUDANÇA: Descrição truncada e com estilo --}}
                        <p class="card-text text-muted small text-truncate-lines">
                            {{ $product->description }}
                        </p>

                        {{-- 
                          MUDANÇA: 'mt-auto' força este bloco 
                          a ficar na base do card-body 
                        --}}
                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                {{-- MUDANÇA: Preço com mais destaque --}}
                                <span class="h5 mb-0 fw-bold text-success">
                                    R$ {{ number_format($product->price, 2, ',', '.') }}
                                </span>
                                <div>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                    <small class="text-muted">(4.5)</small>
                                </div>
                            </div>
                        </div>

                        {{-- MUDANÇA: Botão "Ver Produto" REMOVIDO --}}
                    </div>

                    {{-- 
                      MUDANÇA: Rodapé transparente e sem borda 
                      para as ações de compra 
                    --}}
                    <div class="card-footer d-flex justify-content-between align-items-center bg-transparent border-top-0 pt-0">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            <input type="number" name="quantity" min="1" value="1" class="form-control form-control-sm" style="max-width: 70px;">
                            {{-- MUDANÇA: Botão com ícone e texto responsivo --}}
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="bi bi-cart-plus"></i>
                                <span class="d-none d-lg-inline ms-1">Adicionar</span>
                            </button>
                        </form>
                        {{-- MUDANÇA: Botão "Like" REMOVIDO daqui --}}
                    </div>

                </div>
            </div>
        @empty
            {{-- MUDANÇA: Mensagem de "vazio" mais agradável --}}
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4 class="alert-heading">Ops!</h4>
                    <p>Nenhum produto foi encontrado no catálogo no momento.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- Script para alternar o coração --}}
<script>
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', () => {
            const icon = button.querySelector('i');
            if (icon.classList.contains('bi-heart')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                {{-- MUDANÇA: Atualizado para btn-outline-danger --}}
                button.classList.remove('btn-outline-danger'); 
                button.classList.add('btn-danger');
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                button.classList.remove('btn-danger');
                {{-- MUDANÇA: Atualizado para btn-outline-danger --}}
                button.classList.add('btn-outline-danger');
            }
        });
    });
</script>

@endsection