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
 <title>Order Suspended</title>
</head>

<body style="margin:0;padding:0;background:#f4f4f4;font-family:Arial,Helvetica,sans-serif;">

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4;padding:30px 0;">
    <tr>
      <td align="center">

        <table width="650" cellpadding="0" cellspacing="0"
          style="background:#ffffff;border-radius:12px;overflow:hidden;">

          <!-- HEADER -->
          <tr>
            <td align="center" style="background:#000;padding:30px;">
              <a href="https://slimza.com/" target="_blank">
                <img src="https://slimza.com/public/images/logo.png" alt="Slimza" style="max-width:220px;">
              </a>
            </td>
          </tr>

          <!-- TITLE -->
          <tr>
            <td style="padding:35px 40px 20px 40px;">
              <h1 style="margin:0;color:#111;font-size:28px;">
                Order Shippment Details
              </h1>

              <p style="color:#666;font-size:15px;line-height:24px;margin-top:15px;">
                Hello <strong>{{ $order->name }}</strong>,
              </p>

       <p style="color:#666;font-size:15px;line-height:24px;">
    We regret to inform you that your order has been temporarily suspended and cannot proceed until the issue is resolved.
</p>

<div style="background:#fff4f4;border-left:4px solid #dc3545;padding:15px;margin-top:20px;border-radius:6px;">
    <strong style="color:#b02a37;">
        Order Status: Suspended
    </strong>
</div>
            </td>
          </tr>

          <!-- PRODUCT -->
          <tr>
            <td style="padding:0 40px 30px 40px;">

              <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #ececec;border-radius:10px;">
                <tr>

                  @if(!empty($product->image))
                  <td width="220" align="center" style="padding:20px;">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" style="max-width:180px;">
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
                    <p style="color:#666;">
                      <strong>Price:</strong>
                      {{ $symbol }} {{ number_format($convertedPrice, 2) }}
                    </p>

                    <p style="color:#666;">
                      <strong>Quantity:</strong>
                      {{ $order->quantity }}
                    </p>

                    <p style="color:#666;">
                      <strong>Status:</strong>
                      Suspended
                    </p>
                  </td>

                </tr>
              </table>

            </td>
          </tr>

          <!-- SHIPPING -->
      
               <tr>
    <td style="padding:0 40px 30px 40px;">

        <h3 style="color:#111;">
            Suspension Reason
        </h3>

        <div style="background:#fff4f4;border:1px solid #f5c2c7;border-radius:10px;padding:20px;">

            @if(!empty($order->{'suspend-reason'}))
                <p style="margin:0;color:#666;line-height:24px;">
                    {{ $order->{'suspend-reason'} }}
                </p>
            @else
                <p style="margin:0;color:#666;line-height:24px;">
    Sorry, the suspension reason was not found. Please contact the
    <a href="mailto:info@slimza.com" style="color:#000;text-decoration:underline;">
        Slimza Support Team
    </a>
    at
    <a href="mailto:info@slimza.com" style="color:#000;text-decoration:underline;">
        info@slimza.com
    </a>
    for further assistance.Kindly mention your order id and above sent details while sending the feedback..
</p>
            @endif

        </div>

    </td>
</tr>


          <!-- SHOP MORE -->
          <tr>
            <td align="center" style="padding:0 40px 40px 40px;">

              <h3 style="color:#111;margin-bottom:10px;">
                Continue Shopping
              </h3>

              <p style="color:#666;line-height:24px;">
                Discover more premium products and exclusive collections from Slimza.
              </p>

              <a href="https://slimza.com/shop/all"
                style="display:inline-block;background:#d4ff00;color:#000;text-decoration:none;padding:14px 28px;border-radius:8px;font-weight:bold;margin-top:10px;">
                Shop Now
              </a>

            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td align="center" style="background:#000;padding:30px;">

              <img src="https://slimza.com/public/images/logo.png" alt="Slimza"
                style="max-width:140px;margin-bottom:15px;">

              <p style="color:#999;font-size:13px;margin:0;">
                Thank you for choosing Slimza.
              </p>

              <p style="color:#999;font-size:13px;margin-top:10px;">
                <a href="https://slimza.com/" style="color:#d4ff00;text-decoration:none;">
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