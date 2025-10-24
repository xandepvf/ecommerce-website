@extends('layouts.app')

@section('content')
{{-- Adiciona um espaçamento vertical (padding) maior no container --}}
<div class="container py-5">
    {{-- 
      'align-items-center' alinha verticalmente a imagem 
      e a coluna de texto, o que fica ótimo em telas maiores.
    --}}
    <div class="row align-items-center">
        
        {{-- Coluna da Imagem --}}
        <div class="col-md-6">
            @if($product->image)
                {{-- 
                  Adiciona cantos arredondados, uma sombra suave e
                  margem inferior para telas pequenas (mb-4) 
                --}}
                <img src="{{ asset('storage/' . $product->image) }}" 
                     class="img-fluid rounded shadow-sm mb-4 mb-md-0" 
                     alt="{{ $product->name }}">
            @else
                <img src="https://via.placeholder.com/600x400?text=Sem+Imagem" 
                     class="img-fluid rounded shadow-sm mb-4 mb-md-0" 
                     alt="Sem imagem">
            @endif
        </div>

        {{-- Coluna de Detalhes --}}
        <div class="col-md-6">
            {{-- Título com mais destaque (font-weight bold) --}}
            <h1 class="display-5 fw-bold">{{ $product->name }}</h1>
            
            {{-- Descrição com a classe 'lead' para ficar um pouco maior e mais legível --}}
            <p class="lead text-muted mt-3">{{ $product->description }}</p>

            {{-- 
              Preço com bastante destaque. 
              Mudei de h3 para h2 e usei 'display-4' para um tamanho grande.
              'my-4' adiciona margem em cima e embaixo.
            --}}
            <h2 class="display-4 text-success my-4 fw-bold">
                R$ {{ number_format($product->price, 2, ',', '.') }}
            </h2>

            {{-- 
              AÇÃO PRINCIPAL: Formulário para Adicionar ao Carrinho.
              (Assumindo que você tenha uma rota 'cart.add')
            --}}
            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                
                {{-- 
                  Opcional: Campo de Quantidade
                  <div class="mb-3" style="max-width: 150px;">
                    <label for="quantity" class="form-label fw-bold">Quantidade:</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1">
                  </div> 
                --}}

                {{-- Botão de Ação Primária (CTA) --}}
                <button type="submit" class="btn btn-primary btn-lg w-100 mb-3">
                    Adicionar ao Carrinho
                </button>
            </form>

            {{-- Ação Secundária: Voltar (com estilo mais sutil) --}}
            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100">
                Voltar ao Catálogo
            </a>
        </div>
    </div>
</div>
@endsection