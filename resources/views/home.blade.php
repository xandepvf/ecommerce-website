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
           
            <img src="https://cdn.jornaldebrasilia.com.br/wp-content/uploads/2024/10/25154253/Snapinsta.app_463767821_2423573118034160_5858705213747078273_n_1080-883x1024.jpg" 
                 class="d-block mx-lg-auto img-fluid rounded shadow-sm" 
                 alt="Imagem de destaque da loja" 
                 width="700" height="500" loading="lazy">
        </div>
        
        {{-- Coluna do Texto e Botão --}}
        <div class="col-lg-6">
            {{-- Nome da loja --}}
            <h1 class="display-4 fw-bold lh-1 mb-4">Bem-vindo</h1>

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