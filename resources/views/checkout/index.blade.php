<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pagamento</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .StripeElement {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background: white;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Finalizar Pagamento</h2>

    <form id="payment-form">
        <div id="card-element"></div>
        <div id="card-errors" class="text-danger mb-3"></div>
        <button id="submit" class="btn btn-success w-100">Pagar</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ $stripeKey }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    card.on('change', function(event) {
        document.getElementById('card-errors').textContent = event.error ? event.error.message : '';
    });

    const form = document.getElementById('payment-form');
    const clientSecret = "{{ $clientSecret }}";

    form.addEventListener('submit', function(ev) {
        ev.preventDefault();

        stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: card,
                billing_details: {
                    name: 'Cliente Teste'
                }
            }
        }).then(function(result) {
            if (result.error) {
                document.getElementById('card-errors').textContent = result.error.message;
            } else if (result.paymentIntent.status === 'succeeded') {
                fetch("{{ route('checkout.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({})
                }).then(response => {
                    if (response.ok) {
                        window.location.href = "{{ route('orders.index') }}";
                    } else {
                        alert("Erro ao salvar pedido!");
                    }
                });
            }
        });
    });
</script>
</body>
</html>
