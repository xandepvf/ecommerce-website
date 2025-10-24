<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Finalizar Compra</title>
    <style>
        .StripeElement {
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: white;
            margin-bottom: 20px;
        }
        #card-errors {
            color: red;
            margin-bottom: 20px;
        }
        #payment-form {
            max-width: 400px;
            margin: 40px auto;
        }
        button {
            background-color: #6772e5;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Finalizar Pagamento</h2>

    <form id="payment-form">
        <div id="card-element"></div>
        <div id="card-errors" role="alert"></div>
        <button id="submit">Pagar</button>
    </form>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ $stripeKey }}');
        const elements = stripe.elements();

        const card = elements.create('card');
        card.mount('#card-element');

        card.on('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });

        const form = document.getElementById('payment-form');
        const clientSecret = "{{ $clientSecret }}";

        form.addEventListener('submit', function(ev) {
            ev.preventDefault();

            document.getElementById('submit').disabled = true;

            stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: {
                        name: 'Cliente' // você pode pegar o nome do usuário autenticado
                    }
                }
            }).then(function(result) {
                if (result.error) {
                    // Exibe erro no pagamento
                    document.getElementById('card-errors').textContent = result.error.message;
                    document.getElementById('submit').disabled = false;
                } else {
                    if (result.paymentIntent.status === 'succeeded') {
                        // Pagamento ok, chama API para salvar pedido e limpar carrinho
                        fetch('{{ route('checkout.store') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({})
                        }).then(response => {
                            if(response.ok) {
                                alert('Pedido finalizado com sucesso!');
                                window.location.href = '/meus-pedidos'; // sua página de histórico
                            } else {
                                alert('Erro ao salvar pedido. Entre em contato com suporte.');
                                document.getElementById('submit').disabled = false;
                            }
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>
