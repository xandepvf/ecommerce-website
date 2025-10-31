@extends('layouts.app')

@section('content')

{{-- CSS dos cards (copiado de products.index) --}}
<style>
    .card-img-top.fixed-img { height: 220px; object-fit: cover; width: 100%; }
    .card-hover { transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out; }
    .card-hover:hover { transform: translateY(-5px); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important; }
    .text-truncate-lines { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; min-height: 40px; }
    .card-title-link { text-decoration: none; color: inherit; }
    .card-title-link:hover { color: var(--bs-primary); }
</style>

<div class="container py-4" style="max-width: 1200px;">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4 mt-3">
        <h1>Meus Favoritos</h1>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @forelse($products as $product)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm card-hover position-relative">

                    {{-- Botão de Favorito (agora é um formulário) --}}
                    {{-- Todos aqui estarão favoritados, então mostramos o botão preenchido --}}
                    <form action="{{ route('favorites.toggle', $product->id) }}" method="POST" class="position-absolute top-0 end-0 m-2" style="z-index: 10;">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm like-btn"> 
                            <i class="bi bi-heart-fill"></i>
                        </button>
                    </form>

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
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-center bg-transparent border-top-0 pt-0">
                        {{-- Link para ver o produto --}}
                         <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm">
                            Ver Detalhes
                         </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <h4 class="alert-heading">Sua lista de favoritos está vazia.</h4>
                    <p>Clique no coração <i class="bi bi-heart"></i> nos produtos para adicioná-los aqui.</p>
                    <hr>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Ver todos os produtos</a>
                </div>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>

</div>
@endsection