@php

$currency = session('currency', 'GBP');

$config = config("currency.currencies.$currency");

$rate = $config['rate'] ?? 1;

$symbol = $config['symbol'] ?? '£';

$convertedPrice = ($product->price ?? 0) * $rate;

@endphp
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <title>Order Delivered</title>
</head>

<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:30px 0;">
   <!-- TITLE -->
<tr>
    <td style="padding:35px 40px 20px 40px;">

        @php

            $customerName = $order->name
                ?? trim(
                    ($order->first_name ?? '') .
                    ' ' .
                    ($order->last_name ?? '')
                );

            $customerName = $customerName ?: 'Customer';

        @endphp

        <h1 style="margin:0;color:#111;font-size:28px;">

            Order Shipment Details

        </h1>

        <p
            style="
                color:#666;
                font-size:15px;
                line-height:24px;
                margin-top:15px;
            "
        >
            Hello <strong>{{ $customerName }}</strong>,
        </p>

        <p
            style="
                color:#666;
                font-size:15px;
                line-height:24px;
            "
        >
            Great news! Your Slimza order has been successfully updated.
            Thank you for choosing Slimza. You can track your order
            status at any time from your account dashboard.
        </p>

        <div
            style="
                background:#e8f8ee;
                border-left:4px solid #28a745;
                padding:15px;
                margin-top:20px;
                border-radius:6px;
            "
        >
            <strong style="color:#1e7e34;">

                Order Status:
                {{ $currentStatus ?? 'Pending' }}

            </strong>
        </div>

    </td>
</tr>

          <!-- PRODUCT -->
       <!-- PRODUCT -->
<tr>
    <td style="padding:0 40px 30px 40px;">

        @if(isset($product->name))

            <table
                width="100%"
                cellpadding="0"
                cellspacing="0"
                style="border:1px solid #ececec;border-radius:10px;"
            >
                <tr>

                    @if(!empty($product->image))

                        <td
                            width="220"
                            align="center"
                            style="padding:20px;"
                        >
                            <img
                                src="{{ $product->image }}"
                                alt="{{ $product->name }}"
                                style="max-width:180px;"
                            >
                        </td>

                    @endif

                    <td style="padding:20px;">

                        <h2 style="margin:0;color:#111;">
                            {{ $product->name }}
                        </h2>

                        <p style="margin-top:15px;color:#666;">
                            <strong>Order ID:</strong>
                            #{{ $order->id }}
                        </p>

                        <p style="color:#666;">
                            <strong>Price:</strong>
                            {{ $symbol }}
                            {{ number_format($convertedPrice, 2) }}
                        </p>

                        <p style="color:#666;">
                            <strong>Quantity:</strong>
                            {{ $order->quantity }}
                        </p>

                        <p style="color:#666;">
                            <strong>Status:</strong>
                            {{ $currentStatus }}
                        </p>

                    </td>

                </tr>
            </table>

        @elseif(!empty($product) && is_array($product))

            <h3 style="color:#111;margin-bottom:20px;">
                Bundle Products
            </h3>

            @foreach($product as $item)

                <table
                    width="100%"
                    cellpadding="0"
                    cellspacing="0"
                    style="
                        border:1px solid #ececec;
                        border-radius:10px;
                        margin-bottom:15px;
                    "
                >
                    <tr>

                        @if(!empty($item['main_image']))

                            <td
                                width="180"
                                align="center"
                                style="padding:20px;"
                            >
                                <img
                                    src="{{ $item['main_image'] }}"
                                    alt="{{ $item['name'] ?? 'Product' }}"
                                    style="max-width:140px;"
                                >
                            </td>

                        @endif

                        <td style="padding:20px;">

                            <h2 style="margin:0;color:#111;">
                                {{ $item['name'] ?? 'Product' }}
                            </h2>

                            <p
                                style="
                                    margin-top:15px;
                                    color:#666;
                                "
                            >
                                <strong>Order ID:</strong>
                                #{{ $order->id }}
                            </p>

                            <p style="color:#666;">
                                <strong>Price:</strong>
                                {{ $symbol }}
                                {{ number_format($item['price'] ?? 0, 2) }}
                            </p>

                            <p style="color:#666;">
                                <strong>Quantity:</strong>
                                {{ $item['qty'] ?? 1 }}
                            </p>

                            <p style="color:#666;">
                                <strong>Status:</strong>
                                {{ $currentStatus }}
                            </p>

                        </td>

                    </tr>
                </table>

            @endforeach

            <table
                width="100%"
                cellpadding="10"
                cellspacing="0"
                style="
                    border:1px solid #ececec;
                    margin-top:20px;
                "
            >
                <tr>
                    <td>
                        <strong>Subtotal</strong>
                    </td>
                    <td align="right">
                        {{ $symbol }}
                        {{ number_format($order->subtotal ?? 0, 2) }}
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>Discount</strong>
                    </td>
                    <td align="right">
                        {{ $order->discount_percentage ?? 0 }}%
                    </td>
                </tr>

                <tr>
                    <td>
                        <strong>Total</strong>
                    </td>
                    <td align="right">
                        {{ $symbol }}
                        {{ number_format($order->total ?? 0, 2) }}
                    </td>
                </tr>
            </table>

        @endif

    </td>
</tr>

         <!-- SHIPPING INFORMATION -->
<tr>
    <td style="padding:0 40px 30px 40px;">

        <h3 style="color:#111;">
            Shipping Information
        </h3>

        <div
            style="
                background:#fafafa;
                border:1px solid #ececec;
                border-radius:10px;
                padding:20px;
            "
        >

            <p style="margin:0;color:#666;">

                {{
                    $order->address1
                    ?? $order->address_1
                    ?? 'Address not available'
                }}

            </p>

            @if(!empty($order->address2) || !empty($order->address_2))

                <p style="margin:8px 0 0;color:#666;">

                    {{ $order->address2 ?? $order->address_2 }}

                </p>

            @endif

            <p style="margin:8px 0 0;color:#666;">

                {{ $order->city ?? '-' }}

            </p>

            <p style="margin:8px 0 0;color:#666;">

                {{ $order->state ?? '-' }}

            </p>

            <p style="margin:8px 0 0;color:#666;">

                {{ $order->postcode ?? '-' }}

            </p>

            <p style="margin:8px 0 0;color:#666;">

                {{ $order->country ?? '-' }}

            </p>

        </div>

    </td>
</tr>

<!-- TRACK ORDER -->
<tr>

    <td align="center" style="padding:10px 40px 40px 40px;">

        @php

            $profileLink = empty($order->user_id)
                ? 'https://slimza.com/profile/guest-profile'
                : 'https://slimza.com/profile';

        @endphp

        <a
            href="{{ $profileLink }}"
            style="
                display:inline-block;
                background:#000;
                color:#fff;
                text-decoration:none;
                padding:14px 28px;
                border-radius:8px;
                font-weight:bold;
            "
        >
            Track Your Order
        </a>

    </td>

</tr>
          
{{-- ================= COURIER INFORMATION ================= --}}

@if(
    !empty($order->{'courier-service'}) ||
    !empty($order->courier_service)
)

<tr>

    <td style="padding:0 40px 30px 40px;">

        <h3 style="color:#111;">
            Courier Information
        </h3>

        @php

            $courier = $order->{'courier-service'}
                ?? $order->courier_service
                ?? null;

        @endphp

        <div
            style="
                background:#fafafa;
                border:1px solid #ececec;
                border-radius:10px;
                padding:20px;
            "
        >

            @if(!empty($courier->phone_number))

                <p style="margin:0;color:#666;">
                    <strong>Courier Contact Number:</strong>
                </p>

                <p
                    style="
                        margin:8px 0 0;
                        color:#111;
                        font-size:16px;
                        font-weight:bold;
                    "
                >
                    {{ $courier->phone_number }}
                </p>

                <p
                    style="
                        margin:15px 0 0;
                        color:#666;
                        line-height:22px;
                    "
                >
                    If you have any delivery-related questions,
                    please contact the courier using the number above.
                </p>

            @else

                <p style="margin:0;color:#666;">
                    Courier information has not been updated yet.
                </p>

            @endif

        </div>

    </td>

</tr>

@endif


{{-- ================= SHOP MORE ================= --}}

<tr>

    <td align="center" style="padding:0 40px 40px 40px;">

        <h3 style="color:#111;margin-bottom:10px;">
            Continue Shopping
        </h3>

        <p style="color:#666;line-height:24px;">

            Discover more premium products and exclusive
            collections from Slimza.

        </p>

        <a
            href="https://slimza.com/shop/all"
            style="
                display:inline-block;
                background:#d4ff00;
                color:#000;
                text-decoration:none;
                padding:14px 28px;
                border-radius:8px;
                font-weight:bold;
                margin-top:10px;
            "
        >
            Shop Now
        </a>

    </td>

</tr>


{{-- ================= FOOTER ================= --}}

<tr>

    <td
        align="center"
        style="background:#000;padding:30px;"
    >

        <img
            src="https://slimza.com/public/images/logo.png"
            alt="Slimza"
            style="
                max-width:140px;
                margin-bottom:15px;
            "
        >

        <p
            style="
                color:#999;
                font-size:13px;
                margin:0;
            "
        >
            Thank you for choosing Slimza.
        </p>

        <p
            style="
                color:#999;
                font-size:13px;
                margin-top:10px;
            "
        >
            <a
                href="https://slimza.com/"
                style="
                    color:#d4ff00;
                    text-decoration:none;
                "
            >
                www.slimza.com
            </a>
        </p>

    </td>

</tr>

</table>

</td>

</tr>
  </table>





</body>

</html>