@if($order->status === 'pending')
    @include('emails.order-emails.pending-order')

@elseif($order->status === 'shipped')
    @include('emails.order-emails.shipped-order')

@elseif($order->status === 'delivered')
    @include('emails.order-emails.delivered-order')

@elseif($order->status === 'suspended')
    @include('emails.order-emails.suspended-order')

@else
    @include('emails.order-emails.pending-order')
@endif