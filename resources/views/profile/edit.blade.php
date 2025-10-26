@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 800px;"> {{-- Container centralizado --}}

    {{-- Título da Página --}}
    <h1 class="h3 mb-4 fw-bold">Editar Perfil</h1>

    {{-- Card 1: Informações do Perfil --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4 p-md-5">
            {{-- Inclui o formulário de informações do perfil --}}
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Card 2: Atualizar Senha --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4 p-md-5">
            {{-- Inclui o formulário de atualização de senha --}}
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Card 3: Excluir Conta (Zona de Perigo) --}}
    <div class="card shadow-sm border-0 border-danger border-3"> {{-- Destaque de perigo --}}
        <div class="card-body p-4 p-md-5">
            {{-- Inclui o formulário de exclusão de conta --}}
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection