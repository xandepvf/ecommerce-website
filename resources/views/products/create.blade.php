@extends('layouts.app')

@section('content')
<div class="container mt-5" style="max-width: 700px;">

    {{-- 
      MUDANÇA: Envolvemos tudo em um 'card' 
      com sombra suave (shadow-sm) e sem bordas (border-0)
    --}}
    <div class="card shadow-sm border-0">
        
        {{-- MUDANÇA: Título movido para o cabeçalho do card --}}
        <div class="card-header bg-white py-3">
            <h1 class="h4 mb-0 text-center">Cadastrar Produto</h1>
        </div>

        <div class="card-body p-4 p-md-5">

            {{-- Mensagem de erro (agora dentro do card) --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                @csrf

                {{-- MUDANÇA: Adicionado Input Group com ícone --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nome do Produto</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-box-seam"></i></span>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- MUDANÇA: Adicionado Input Group com ícone --}}
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Descrição</label>
                     <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label fw-semibold">Preço</label>
                    <div class="input-group">
                        {{-- MUDANÇA: Ícone "R$" mantido, é perfeito --}}
                        <span class="input-group-text">R$</span>
                        <input type="number" name="price" id="price" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" required>
                        @error('price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label fw-semibold">Imagem</label>
                    {{-- 
                      NOTA: Inputs de 'file' são mais complexos de estilizar 
                      com 'input-group', então o padrão do Bootstrap é mantido.
                    --}}
                    <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between">
                    {{-- MUDANÇA: Botões com ícones --}}
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg me-1"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-lg me-1"></i>
                        Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- 
  MUDANÇA: Script para ativar a validação do Bootstrap.
  Se você já tem um @push('scripts') no seu layout, 
  é melhor colocar este script lá.
--}}
<script>
    // Exemplo de script de validação do Bootstrap
    (function () {
    'use strict'

    // Pega todos os formulários que queremos aplicar estilos de validação
    var forms = document.querySelectorAll('.needs-validation')

    // Loop neles e previne a submissão
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
            }

            form.classList.add('was-validated')
        }, false)
        })
    })()
</script>
@endsection