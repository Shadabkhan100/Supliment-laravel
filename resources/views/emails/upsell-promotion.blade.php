<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Your Exclusive Slimza Reward</title>

</head>

<body style="
    margin:0;
    padding:0;
    background:#f4f6f8;
    font-family:Arial,Helvetica,sans-serif;
">

<table width="100%"
       cellpadding="0"
       cellspacing="0"
       border="0"
       style="
            background:#f4f6f8;
            padding:30px 10px;
       ">

<tr>

<td align="center">

<table width="600"
       cellpadding="0"
       cellspacing="0"
       border="0"
       style="
            width:100%;
            max-width:600px;
            background:#ffffff;
            border-radius:14px;
            overflow:hidden;
       ">


<!-- LOGO -->

<tr>

<td align="center"
    style="padding:25px;">

<a href="https://slimza.com">

<img
    src="https://slimza.com/images/logo.png"
    alt="Slimza"
    width="140"
    style="
        display:block;
        width:140px;
        height:auto;
        border:0;
    "
>

</a>

</td>

</tr>


<!-- HERO -->

<tr>

<td align="center"
    style="
        padding:40px 30px;
        background:#18201b;
    ">

<h1 style="
    margin:0 0 12px;
    color:#ffffff;
    font-size:28px;
">

    🎁 You Earned an Exclusive Reward!

</h1>

<p style="
    margin:0;
    color:#d8ddd9;
    font-size:15px;
    line-height:1.7;
">

    Thank you for choosing Slimza.
    As a special thank-you for your recent purchase,
    we've created an exclusive reward just for you.

</p>

</td>

</tr>


<!-- DISCOUNT -->

<tr>

<td align="center"
    style="padding:35px 25px 15px;">

<h2 style="
    margin:0 0 10px;
    color:#222222;
    font-size:24px;
">

    Enjoy {{ $discount }}% OFF

</h2>

<p style="
    margin:0;
    color:#666666;
    font-size:14px;
    line-height:1.7;
">

    You recently spent
    <strong>
        {{ $currency }} {{ number_format((float)$amountPaid, 2) }}
    </strong>

    (approximately
    <strong>
        £{{ number_format((float)$amountInGbp, 2) }}
    </strong>
    ).

</p>

</td>

</tr>


<!-- PROMO CODE -->

<tr>

<td align="center"
    style="padding:15px 25px 30px;">

<table width="100%"
       cellpadding="0"
       cellspacing="0"
       style="
            background:#f4f9ea;
            border:2px dashed #9acb3c;
            border-radius:12px;
       ">

<tr>

<td align="center"
    style="padding:25px;">

<p style="
    margin:0 0 8px;
    color:#666666;
    font-size:12px;
    text-transform:uppercase;
    letter-spacing:1px;
">

    Your Exclusive Promo Code

</p>

<div style="
    color:#263238;
    font-size:26px;
    font-weight:bold;
    letter-spacing:2px;
">

   @if(!empty($promoCode))
    {{ json_decode($promoCode, true)['code'] ?? 'Promo code unavailable' }}
@else
    Promo code is currently unavailable. Please contact support.
@endif

</div>

<p style="
    margin:12px 0 0;
    color:#777777;
    font-size:12px;
">

    {{ $discount }}% discount

</p>

</td>

</tr>

</table>

</td>

</tr>


<!-- EXPIRY -->

<tr>

<td align="center"
    style="padding:0 25px 30px;">

<p style="
    margin:0;
    color:#d9534f;
    font-size:13px;
    font-weight:bold;
">

    ⏰ This offer expires
    {{ \Carbon\Carbon::parse($expiresAt)->format('d M Y, H:i') }}

</p>

</td>

</tr>


<!-- MESSAGE -->

<tr>

<td style="
    padding:30px;
    background:#fafafa;
">

<h2 style="
    margin:0 0 10px;
    color:#222222;
    font-size:20px;
">

    Keep Your Wellness Journey Going 🌿

</h2>

<p style="
    margin:0;
    color:#666666;
    font-size:13px;
    line-height:1.8;
">

    Your journey doesn't stop after one purchase.
    Whether you're looking to support your daily wellness,
    stay active or maintain healthy habits, Slimza has
    products designed to complement your lifestyle.

</p>

</td>

</tr>


<!-- PRODUCTS -->

@if(!empty($products))

<tr>

<td style="padding:30px 20px;">

<h2 style="
    margin:0 0 8px;
    text-align:center;
    color:#222222;
    font-size:21px;
">

    Continue Your Wellness Journey

</h2>

<p style="
    margin:0 0 25px;
    text-align:center;
    color:#777777;
    font-size:13px;
">

    Use your exclusive {{ $discount }}% discount
    on your next Slimza purchase.

</p>


@foreach($products as $product)

@php

    $productName = $product['name'] ?? 'Slimza Product';

    $productImage = $product['main_image'] ?? '';

    $productId = $product['id'] ?? '';

    $price = $product['price'] ?? null;

    $oldPrice = $product['old_price'] ?? null;

    $slug = strtolower($productName);

    $slug = preg_replace(
        '/[^a-z0-9\s-]/',
        '',
        $slug
    );

    $slug = preg_replace(
        '/\s+/',
        '-',
        $slug
    );

    $slug = preg_replace(
        '/-+/',
        '-',
        $slug
    );

    $slug = trim($slug, '-');

    $productUrl =
        'https://slimza.com/product_details' .
        $slug .
        '/' .
        $productId;

@endphp


<table width="100%"
       cellpadding="0"
       cellspacing="0"
       style="
            margin-bottom:15px;
            border:1px solid #e8e8e8;
            border-radius:10px;
       ">

<tr>

<td width="150"
    style="
        width:150px;
        padding:15px;
        background:#fafafa;
    ">

@if(!empty($productImage))

<a href="{{ $productUrl }}">

<img
    src="{{ $productImage }}"
    alt="{{ $productName }}"
    width="130"
    style="
        display:block;
        width:130px;
        height:auto;
        border:0;
    "
>

</a>

@endif

</td>


<td valign="top"
    style="padding:15px 10px 15px 5px;">

<h3 style="
    margin:0 0 8px;
    color:#222222;
    font-size:15px;
    line-height:1.4;
">

    {{ $productName }}

</h3>


@if($oldPrice)

<span style="
    color:#999999;
    font-size:11px;
    text-decoration:line-through;
">

    £{{ number_format((float)$oldPrice, 2) }}

</span>

@endif


@if($price !== null)

<span style="
    color:#78a82d;
    font-size:17px;
    font-weight:bold;
    margin-left:5px;
">

    £{{ number_format((float)$price, 2) }}

</span>

@endif


<br><br>


<a href="{{ $productUrl }}"
   style="
        display:inline-block;
        padding:9px 14px;
        background:#8fbd3f;
        color:#ffffff;
        text-decoration:none;
        border-radius:6px;
        font-size:11px;
        font-weight:bold;
   ">

    View Product

</a>

</td>

</tr>

</table>

@endforeach

</td>

</tr>

@endif


<!-- CTA -->

<tr>

<td align="center"
    style="
        padding:35px 25px;
        background:#18201b;
    ">

<h2 style="
    margin:0 0 10px;
    color:#ffffff;
    font-size:21px;
">

    Ready for Your Next Step?

</h2>

<p style="
    margin:0 0 20px;
    color:#d5d9d6;
    font-size:13px;
    line-height:1.6;
">

    Use your exclusive code before it expires.

</p>

<a href="https://slimza.com"
   style="
        display:inline-block;
        padding:12px 28px;
        background:#9acb3c;
        color:#ffffff;
        text-decoration:none;
        border-radius:7px;
        font-size:13px;
        font-weight:bold;
   ">

    Shop Slimza

</a>

</td>

</tr>


<!-- FOOTER -->

<tr>

<td align="center"
    style="padding:25px;">

<img
    src="https://slimza.com/images/logo.png"
    alt="Slimza"
    width="90"
    style="
        display:block;
        width:90px;
        height:auto;
        margin:0 auto 10px;
    "
>

<p style="
    margin:0;
    color:#888888;
    font-size:11px;
">

    Thank you for being part of Slimza.

</p>

<p style="
    margin:8px 0 0;
    color:#aaaaaa;
    font-size:10px;
">

    © {{ date('Y') }} Slimza. All rights reserved.

</p>

</td>

</tr>


</table>

</td>

</tr>

</table>

</body>
</html>