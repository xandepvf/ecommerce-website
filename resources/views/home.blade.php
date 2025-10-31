@extends('layouts.app')

@section('content')

{{-- 
  *** ADICIONADO: CSS dos Cards ***
  Copiado de 'products/index.blade.php' para manter o estilo.
--}}
<style>
    .card-img-top.fixed-img {
        height: 220px;
        object-fit: cover;
        width: 100%;
    }
    .card-hover {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    .text-truncate-lines {
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Número de linhas */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        min-height: 40px; 
    }
    .card-title-link {
        text-decoration: none;
        color: inherit;
    }
    .card-title-link:hover {
        color: var(--bs-primary);
    }
</style>

{{-- 
  Seção "Hero" principal (Seu código original)
--}}
<div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        
        {{-- Coluna da Imagem --}}
        <div class="col-10 col-sm-8 col-lg-6">
            <img src="https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=1470&q=80" 
                 class="d-block mx-lg-auto img-fluid rounded-3 shadow-lg" 
                 alt="Rack com roupas estilosas penduradas" 
                 width="700" height="500" loading="lazy">
        </div>
        
        {{-- Coluna do Texto e Botão --}}
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-4">Seu Novo Estilo Começa Aqui</h1>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 me-md-2 fw-bold">
                    Ver Coleção Completa
                </a>
            </div>
        </div>
    </div>
</div>

{{-- 
  *** NOVA SEÇÃO: Produtos em Destaque ***
--}}
<div class="bg-light py-5">
    <div class="container py-4" style="max-width: 1200px;">
        <h2 class="text-center fw-bold mb-4">Nossos Destaques</h2>
        
        {{-- Verifica se a variável $products existe e não está vazia --}}
        @if(isset($products) && $products->count() > 0)
            
            {{-- 
              Usamos 'row-cols-lg-3' para 3 colunas em telas grandes,
              exatamente como em 'products/index.blade.php'
            --}}
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                
                {{-- Loop para cada produto --}}
                @foreach($products as $product)
                    <div class="col">
                        {{-- 
                          Card de produto (HTML simplificado de products/index.blade.php)
                          Removemos os botões "Add" e "Delete" para um visual mais limpo na home.
                        --}}
                        <div class="card h-100 border-0 shadow-sm card-hover">
                            
                            {{-- Link na imagem e no título para a página do produto --}}
                            <a href="{{ route('products.show', $product->id) }}">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top fixed-img" alt="{{ $product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=Sem+Imagem" class="card-img-top fixed-img" alt="Sem imagem">
                                @endif
                            </a>

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <a href="{{ route('products.show', $product->id) }}" class="card-title-link">
                                        {{ $product->name }}
                                    </a>
                                </h5>
                                
                                <p class="card-text text-muted small text-truncate-lines">
                                    {{ $product->description }}
                                </p>

                                {{-- Preço (mt-auto empurra para baixo) --}}
                                <div class="mt-auto">
                                    <span class="h5 mb-0 fw-bold text-success">
                                        R$ {{ number_format($product->price, 2, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Mensagem caso não haja produtos --}}
            <div class="col-12">
                <p class="text-center text-muted">Nenhum produto em destaque no momento.</p>
            </div>
        @endif
    </div>
</div>
@endsection