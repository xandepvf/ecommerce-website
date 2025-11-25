@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        {{-- Mensagens de Feedback --}}
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Cabeçalho --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 leading-tight">
                    <i class="bi bi-people-fill text-indigo-600 me-2"></i>Gerenciar Usuários
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Visualizando {{ $users->count() }} de {{ $users->total() }} usuários cadastrados.
                </p>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full text-left text-sm whitespace-nowrap">
                    <thead class="uppercase tracking-wider border-b border-gray-200 bg-gray-50 text-gray-500">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Usuário</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Status / Função</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Data Cadastro</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold shrink-0 border border-indigo-200">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-800 text-base">{{ $user->name }}</span>
                                            <span class="text-gray-500 text-xs">{{ $user->email }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    @if($user->is_admin)
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-purple-100 px-3 py-1 text-xs font-bold text-purple-700 ring-1 ring-inset ring-purple-700/10">
                                            <i class="bi bi-shield-lock-fill"></i> Administrador
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-700/10">
                                            <i class="bi bi-person-check-fill"></i> Cliente
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-gray-600">
                                    <div class="flex flex-col">
                                        <span class="font-medium">{{ $user->created_at->format('d/m/Y') }}</span>
                                        <span class="text-xs text-gray-400">às {{ $user->created_at->format('H:i') }}</span>
                                    </div>
                                </td>

                                {{-- *** AÇÕES FUNCIONAIS *** --}}
                                <td class="px-6 py-4 text-end">
                                    <div class="flex justify-end gap-3 items-center">
                                        {{-- Botão Editar --}}
                                        <a href="{{ route('users.edit', $user->id) }}" class="text-gray-400 hover:text-indigo-600 transition-colors" title="Editar">
                                            <i class="bi bi-pencil-square text-lg"></i>
                                        </a>
                                        
                                        {{-- Botão Excluir (Com proteção para não excluir a si mesmo) --}}
                                        @if(Auth::id() !== $user->id)
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors pt-1" 
                                                        title="Excluir" 
                                                        onclick="return confirm('Tem certeza que deseja excluir o usuário {{ $user->name }}? Esta ação não pode ser desfeita.')">
                                                    <i class="bi bi-trash text-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection