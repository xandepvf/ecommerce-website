@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold">Editar Usuário</h2>
                    <a href="{{ route('users.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                        &larr; Voltar
                    </a>
                </div>

                <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nome --}}
                    <div>
                        <x-input-label for="name" :value="__('Nome')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    {{-- Email --}}
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    {{-- Permissão (Admin/Cliente) --}}
                    <div>
                        <x-input-label for="is_admin" :value="__('Nível de Acesso')" />
                        <select id="is_admin" name="is_admin" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="0" {{ $user->is_admin == 0 ? 'selected' : '' }}>Cliente</option>
                            <option value="1" {{ $user->is_admin == 1 ? 'selected' : '' }}>Administrador</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Cuidado ao dar permissão de administrador.</p>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            Cancelar
                        </a>
                        <x-primary-button>
                            {{ __('Salvar Alterações') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection