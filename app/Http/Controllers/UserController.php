<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Exibe a lista de usuários.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Mostra o formulário de edição.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Atualiza os dados do usuário no banco.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'is_admin' => ['required', 'boolean'],
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove o usuário.
     */
    public function destroy(User $user)
    {
        // Proteção: Impede que o admin exclua a si mesmo
        if (Auth::id() === $user->id) {
            return redirect()->route('users.index')->with('error', 'Você não pode excluir sua própria conta por aqui.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuário excluído com sucesso!');
    }
}