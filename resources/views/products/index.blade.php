@extends('layouts.app')

@section('content')

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
        -webkit-line-clamp: 2;
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

<div class="container py-4" style="max-width: 1200px;">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <h1>Catálogo de Produtos</h1>
        
        {{-- *** SÓ MOSTRA O BOTÃO SE FOR ADMIN *** --}}
        @if(Auth::check() && Auth::user()->is_admin)
            <a href="{{ route('products.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> Novo Produto
            </a>
        @endif
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($products as $product)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm card-hover position-relative">
                    
                    @auth
                        @php
                            $isFavorited = isset($userFavorites[$product->id]);
                        @endphp
                        <form action="{{ route('favorites.toggle', $product->id) }}" method="POST" class="position-absolute top-0 end-0 m-2" style="z-index: 10;">
                            @csrf
                            <button type="submit" class="btn {{ $isFavorited ? 'btn-danger' : 'btn-outline-danger' }} btn-sm like-btn"> 
                                <i class="bi {{ $isFavorited ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                            </button>
                        </form>
                    @endauth

                    <a href="{{ route('products.show', $product->id) }}">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top fixed-img" alt="{{ $product->name }}">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=Sem+Imagem" class="card-img-top fixed-img" alt="Sem imagem">
                        @endif
                    </a>

                    <div class="card-body d-flex flex-column pb-0">
                        <h5 class="card-title">
                            <a href="{{ route('products.show', $product->id) }}" class="card-title-link">
                                {{ $product->name }}
                            </a>
                        </h5>
                        
                        <p class="card-text text-muted small text-truncate-lines">
                            {{ $product->description }}
                        </p>

                        <div class="mt-auto">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="h5 mb-0 fw-bold text-success">
                                    R$ {{ number_format($product->price, 2, ',', '.') }}
                                </span>
                                <div>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-fill text-warning"></i>
                                    <i class="bi bi-star-half text-warning"></i>
                                    <small class="text-muted">(4.5)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between align-items-center bg-transparent border-top-0 pt-0">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-flex align-items-center gap-2">
                            @csrf
                            <input type="number" name="quantity" min="1" value="1" class="form-control form-control-sm" style="max-width: 70px;">
                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="bi bi-cart-plus"></i>
                                <span class="d-none d-lg-inline ms-1">Adicionar</span>
                            </button>
                        </form>

                        {{-- *** SÓ MOSTRA BOTÃO EXCLUIR SE FOR ADMIN *** --}}
                        @if(Auth::check() && Auth::user()->is_admin)
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="ms-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Tem certeza que deseja excluir este produto?')"> 
                                    <i class="bi bi-trash-fill"></i> 
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4 class="alert-heading">Ops!</h4>
                    <p>Nenhum produto foi encontrado no catálogo no momento.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>

</div>

<script>
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', () => {
            const icon = button.querySelector('i');
            if (icon.classList.contains('bi-heart')) {
                icon.classList.remove('bi-heart');
                icon.classList.add('bi-heart-fill');
                button.classList.remove('btn-outline-danger'); 
                button.classList.add('btn-danger');
            } else {
                icon.classList.remove('bi-heart-fill');
                icon.classList.add('bi-heart');
                button.classList.remove('btn-danger');
                button.classList.add('btn-outline-danger');
            }
        });
    });
</script>

@endsection