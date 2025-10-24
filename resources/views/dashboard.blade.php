<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel de Controle') }} {{-- Traduzido --}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Mensagem de Boas-Vindas --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900">
                        Bem-vindo(a) de volta, {{ Auth::user()->name }}! 👋
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Aqui estão alguns atalhos rápidos para gerenciar sua conta e suas compras.
                    </p>
                </div>
            </div>

            {{-- Grade de Atalhos Rápidos --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- Card: Ver Produtos --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            {{-- Ícone --}}
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Ver Produtos</h4>
                                <p class="text-sm text-gray-600">Navegue pelo nosso catálogo.</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('products.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                Ir para o Catálogo &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card: Meu Carrinho --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                         <div class="flex items-center">
                            {{-- Ícone --}}
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                               <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c.51 0 .962-.343 1.087-.835l.383-1.437M7.5 14.25V5.106c0-.621.504-1.125 1.125-1.125h9.75c.621 0 1.125.504 1.125 1.125v9.144M7.5 14.25h11.218c.51 0 .962-.343 1.087-.835l.383-1.437M7.5 14.25H5.625m13.5 0H18m-7.5 0h7.5m-7.5 0l-1.125-1.125" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Meu Carrinho</h4>
                                <p class="text-sm text-gray-600">Veja os itens adicionados.</p>
                            </div>
                        </div>
                        <div class="mt-4">
                             <a href="{{ route('cart.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                Ver Carrinho &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card: Meus Pedidos --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                             {{-- Ícone --}}
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                               <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10.5 21l5.25-11.25M20.25 7.5H3.75m16.5 0l-1.125-1.5H4.875L3.75 7.5m16.5 0v-2.25A2.25 2.25 0 0017.25 3H6.75a2.25 2.25 0 00-2.25 2.25v2.25" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Meus Pedidos</h4>
                                <p class="text-sm text-gray-600">Acompanhe suas compras.</p>
                            </div>
                        </div>
                         <div class="mt-4">
                            <a href="{{ route('orders.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                Ver Histórico &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card: Gerenciar Perfil --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                         <div class="flex items-center">
                            {{-- Ícone --}}
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Gerenciar Perfil</h4>
                                <p class="text-sm text-gray-600">Atualize seus dados.</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('profile.edit') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                Editar Perfil &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Card: Adicionar Produto (Opcional - talvez só para admin?) --}}
                {{-- @if(auth()->user()->isAdmin()) --}} {{-- Você precisaria implementar a lógica de admin --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                         <div class="flex items-center">
                             {{-- Ícone --}}
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                               <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-lg font-semibold text-gray-900">Adicionar Produto</h4>
                                <p class="text-sm text-gray-600">Cadastre um novo item.</p>
                            </div>
                        </div>
                        <div class="mt-4">
                           <a href="{{ route('products.create') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                Novo Produto &rarr;
                            </a>
                        </div>
                    </div>
                </div>
                {{-- @endif --}}

            </div> {{-- Fim da Grade --}}
        </div>
    </div>
</x-app-layout>