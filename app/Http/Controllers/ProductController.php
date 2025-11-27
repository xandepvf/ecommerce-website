<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // <<< Adicionado para lidar com ficheiros

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mostra a lista de produtos.
     */
    public function index()
    {
        // $products = Product::all(); // Pega todos
        $products = Product::latest()->paginate(9); // Pega 9 por página, ordenados pelos mais recentes
        
        
        $userFavorites = [];
        if (auth()->check()) {
            $userFavorites = auth()->user()->favorites()->pluck('product_id')->flip();
        }
        
        return view('products.index', compact('products', 'userFavorites'));
    }

    /**
     * Show the form for creating a new resource.
     * Mostra o formulário para criar um novo produto.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     * Guarda um novo produto no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso!');
    }

   
    public function show($id) 
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
        // Se usar Route Model Binding: return view('products.show', compact('product'));
    }

   
    public function edit(Product $product) // Usando Route Model Binding
    {
       
        return view('products.edit', compact('product')); 
    }

   
    public function update(Request $request, Product $product) 
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            // 2. Guarda a nova imagem
            $validatedData['image'] = $request->file('image')->store('product_images', 'public');
        }
        
        $product->update($validatedData);

        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }

   
    public function destroy(Product $product) // Usando Route Model Binding
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produto removido com sucesso!');
    }
}