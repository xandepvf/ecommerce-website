@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4"><i class="bi bi-receipt me-2"></i>Meus Pedidos</h1>

    {{-- Verifica se há pedidos --}}
    @if ($orders->isEmpty())
        {{-- MUDANÇA: Mensagem de "Nenhum Pedido" melhorada --}}
        <div class="card border-0 shadow-sm text-center py-5">
            <div class="card-body">
                <i class="bi bi-journal-x" style="font-size: 4rem; color: var(--bs-gray-500);"></i>
                <h3 class="mt-4">Você ainda não fez nenhum pedido.</h3>
                <p class="text-muted">Explore nossos produtos e faça sua primeira compra!</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-shop me-1"></i> Ir para Produtos
                </a>
            </div>
        </div>
    @else
        {{-- MUDANÇA: Envolver a tabela em um card e adicionar 'table-responsive' --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    {{-- MUDANÇA: Adicionadas classes 'table-hover' e 'align-middle' --}}
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                {{-- MUDANÇA: Ajuste de padding --}}
                                <th class="py-3 px-4">ID do Pedido</th>
                                <th class="py-3 px-4">Data</th>
                                <th class="py-3 px-4 text-end">Total</th>
                                <th class="py-3 px-4 text-center">Status</th>
                                {{-- MUDANÇA: Coluna para Ações (ex: Ver Detalhes) --}}
                                <th class="py-3 px-4 text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    {{-- MUDANÇA: Ajuste de padding e ID com # --}}
                                    <td class="py-3 px-4 fw-medium">#{{ $order->id }}</td>
                                    <td class="py-3 px-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-3 px-4 text-end">R$ {{ number_format($order->total, 2, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-center">
                                        {{-- MUDANÇA: Usar Badges para o Status --}}
                                        @php
                                            $statusClass = 'bg-secondary'; // Padrão
                                            if (strtolower($order->status) == 'pago' || strtolower($order->status) == 'concluído' || strtolower($order->status) == 'entregue') {
                                                $statusClass = 'bg-success';
                                            } elseif (strtolower($order->status) == 'pendente' || strtolower($order->status) == 'processando') {
                                                $statusClass = 'bg-warning text-dark';
                                            } elseif (strtolower($order->status) == 'cancelado') {
                                                $statusClass = 'bg-danger';
                                            }
                                        @endphp
                                        <span class="badge rounded-pill {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    {{-- MUDANÇA: Botão (desabilitado) para Ver Detalhes --}}
<td class="py-3 px-4 text-end">
    {{-- *** MUDANÇA AQUI: Corrigir href e remover 'disabled' *** --}}
    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary" title="Ver Detalhes">
        <i class="bi bi-eye-fill"></i> Detalhes
    </a>
</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- MUDANÇA: Adicionar Paginação (se implementada no controller) --}}
        {{-- <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div> --}}
        
    @endif
</div>
@endsection