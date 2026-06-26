<form action="{{ route('stripe.checkout') }}" method="POST">
    @csrf

    <input type="hidden" name="order_id" value="{{ $order->id }}">

    <button type="submit" class="btn btn-primary w-100">
        Pay with Stripe
    </button>
</form>