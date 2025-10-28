<form method="POST" action="{{ route('profile.destroy') }}" class="p-0">
    @csrf
    @method('DELETE')

    {{-- Modal: Corpo --}}
    <div class="modal-body">
        <p class="mb-3">
            Tem certeza de que deseja excluir sua conta? Esta ação é irreversível.
        </p>

        {{-- Campo de senha para confirmação --}}
        <div class="mt-3">
            <label for="password_delete" class="form-label fw-semibold">
                {{ __('Senha') }}
            </label>

            <input 
                id="password_delete" 
                name="password" 
                type="password" 
                class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                placeholder="{{ __('Digite sua senha') }}"
            >

            {{-- Mensagem de erro --}}
            @error('password', 'userDeletion')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Modal: Rodapé --}}
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            {{ __('Cancelar') }}
        </button>

        <button type="submit" class="btn btn-danger">
            {{ __('Excluir Conta') }}
        </button>
    </div>
</form>
