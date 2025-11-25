<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Exibe a lista de usuários (Apenas para Admin).
     */
    public function index()
    {
        // Busca todos os usuários, 10 por página
        $users = User::paginate(10);
        
        return view('users.index', compact('users'));
    }
}