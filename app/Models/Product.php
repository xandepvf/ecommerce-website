<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany; // <<< ADICIONE ESTE

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'image'];
    // *** ADICIONE ESTA FUNÇÃO ***
    /**
     * Retorna os usuários que favoritaram este produto.
     */
    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_user');
    }
}
