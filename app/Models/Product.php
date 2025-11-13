<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- ESTA LINHA FALTAVA
use Illuminate\Database\Eloquent\Relations\HasMany; // <-- ADICIONADO PARA OS ITENS DO PEDIDO

class Product extends Model
{
    // Agora ambas as traits estão importadas e podem ser usadas
    use HasFactory, SoftDeletes; 

    protected $fillable = ['name', 'description', 'price', 'image'];
   
    /**
     * Retorna os usuários que favoritaram este produto.
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user');
    }

    /**
     * *** NOVO: Retorna os itens de pedido associados a este produto. ***
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}