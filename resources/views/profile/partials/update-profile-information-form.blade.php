<section>
    <header>
        <h2 class="h4 fw-bold">
            {{ __('Informações do Perfil') }}
        </h2>

        <p class="text-muted mt-1">
            {{ __("Atualize as informações de perfil e endereço de e-mail da sua conta.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        {{-- Campo Nome --}}
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">{{ __('Nome') }}</label>
            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Campo Email --}}
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
             @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            {{-- Verificação de Email --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-warning">
                    {{ __('Seu endereço de e-mail não foi verificado.') }}

                    <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-decoration-underline">
                        {{ __('Clique aqui para reenviar o e-mail de verificação.') }}
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <div class="mt-2 text-success">
                        {{ __('Um novo link de verificação foi enviado para o seu endereço de e-mail.') }}
                    </div>
                @endif
            @endif
        </div>

        {{-- Botão Salvar e Mensagem de Status --}}
        <div class="d-flex align-items-center gap-4">
            <button type="submit" class="btn btn-primary">{{ __('Salvar') }}</button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-success small">
                    {{ __('Salvo.') }}
                </div>
            @endif
        </div>
    </form>
</section>