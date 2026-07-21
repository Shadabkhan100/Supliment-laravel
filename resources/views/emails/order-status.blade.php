@if($currentStatus === 'Pending')
    @include('emails.order-emails.pending-order')

@elseif($currentStatus === 'Shipped')
    @include('emails.order-emails.shipped-order')

@elseif($currentStatus === 'Delivered')
    @include('emails.order-emails.delivered-order')

@elseif($currentStatus === 'Suspended')
    @include('emails.order-emails.suspended-order')

@else
    @include('emails.order-emails.pending-order')
@endif