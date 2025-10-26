<section>
    <header>
        <h2 class="h4 fw-bold">
            {{ __('Excluir Conta') }}
        </h2>

        <p class="text-muted mt-1">
            {{ __('Depois que sua conta for excluída, todos os seus recursos e dados serão permanentemente apagados. Antes de excluir sua conta, por favor, baixe quaisquer dados ou informações que você deseja manter.') }}
        </p>
    </header>

    {{-- Botão que Aciona o Modal --}}
    <button type="button" class="btn btn-danger mt-3" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        {{ __('Excluir Conta') }}
    </button>

    {{-- Modal de Confirmação do Bootstrap --}}
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                
                <form method="post" action="{{ route('profile.destroy') }}" class="p-0">
                    @csrf
                    @method('delete')

                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmUserDeletionModalLabel">
                            {{ __('Tem certeza de que deseja excluir sua conta?') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <p class="text-muted">
                            {{ __('Depois que sua conta for excluída, todos os seus recursos e dados serão permanentemente apagados. Por favor, digite sua senha para confirmar que você deseja excluir permanentemente sua conta.') }}
                        </p>

                        {{-- Confirmação de Senha --}}
                        <div class="mt-3">
                            <label for="password_delete" class="form-label fw-semibold">{{ __('Senha') }}</label>
                            <input id="password_delete" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="{{ __('Senha') }}">
                            
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            {{ __('Cancelar') }}
                        </button>
                        
                        <button type="submit" class="btn btn-danger">
                            {{ __('Excluir Conta') }}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>