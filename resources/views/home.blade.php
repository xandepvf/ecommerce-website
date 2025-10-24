@extends('layouts.app')

@section('content')
{{-- 
  Usamos um container otimizado para seções "hero".
  (Baseado nos exemplos oficiais do Bootstrap)
--}}
<div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        
        {{-- Coluna da Imagem --}}
        <div class="col-10 col-sm-8 col-lg-6">
            {{-- 
              Use a função asset() do Laravel para carregar uma imagem da sua pasta 'public'.
              Estou usando um placeholder (imagem de exemplo) por enquanto.
              Troque 'https://via.placeholder.com/700x500' pela sua imagem.
              Ex: {{ asset('images/minha-imagem-hero.jpg') }}
            --}}
            <img src="https://media.licdn.com/dms/image/v2/C5603AQFUCKotLLsm-g/profile-displayphoto-shrink_100_100/profile-displayphoto-shrink_100_100/0/1623959370859?e=2147483647&v=beta&t=1ofkSnyJR5h7cArO_hKQAPo-z7qKAPtnMSZncJz-lfg" 
                 class="d-block mx-lg-auto img-fluid rounded shadow-sm" 
                 alt="Imagem de destaque da loja" 
                 width="700" height="500" loading="lazy">
        </div>
        
        {{-- Coluna do Texto e Botão --}}
        <div class="col-lg-6">
            {{-- Nome da loja --}}
            <h1 class="display-4 fw-bold lh-1 mb-4">Bem-vindo à Minha Loja</h1>

            {{-- Chamada principal --}}
            <p class="lead mb-4">
                
            </p>

            {{-- Botões --}}
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 me-md-2">
                    Ver Produtos
                </a>
                {{-- Botão secundário opcional --}}
               
            </div>
        </div>
    </div>
</div>
@endsection