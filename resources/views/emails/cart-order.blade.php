<!DOCTYPE html>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Order Confirmation</title>
</head>

<body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#333;">

  @php

  $currency = session('currency', 'GBP');
  $config = config("currency.currencies.$currency");

  $rate = $config['rate'] ?? 1;
  $symbol = $config['symbol'] ?? '£';

  @endphp

  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:30px 0;">
    <tr>
      <td align="center">

        <table width="800" cellpadding="0" cellspacing="0"
          style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 2px 15px rgba(0,0,0,.08);">

          ```
          <!-- HEADER -->
          <tr>
            <td style="background:#111827;padding:30px;text-align:center;color:#fff;">
              <h1 style="margin:0;font-size:28px;">
                🎉 Order Confirmation
              </h1>

              <p style="margin:10px 0 0 0;color:#d1d5db;">
                Thank you for shopping with Slimza
              </p>
            </td>
          </tr>

          <!-- CUSTOMER DETAILS -->
          <tr>
            <td style="padding:30px;">

              <h2 style="margin-top:0;color:#111827;">
                Customer Information
              </h2>

              <table width="100%" cellpadding="10" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:8px;">
                <tr>
                  <td width="180"><strong>👤 Name</strong></td>
                  <td>{{ $customer['name'] ?? '' }}</td>
                </tr>

                @if(!empty($customer['email']))
                <tr>
                  <td><strong>📧 Email</strong></td>
                  <td>{{ $customer['email'] }}</td>
                </tr>
                @endif

                @if(!empty($customer['phone']))
                <tr>
                  <td><strong>📱 Phone</strong></td>
                  <td>{{ $customer['phone'] }}</td>
                </tr>
                @endif

                @if(!empty($customer['address1']))
                <tr>
                  <td><strong>📍 Address</strong></td>
                  <td>{{ $customer['address1'] }}</td>
                </tr>
                @endif

                @if(!empty($customer['city']))
                <tr>
                  <td><strong>🏙️ City</strong></td>
                  <td>{{ $customer['city'] }}</td>
                </tr>
                @endif

                @if(!empty($customer['country']))
                <tr>
                  <td><strong>🌍 Country</strong></td>
                  <td>{{ $customer['country'] }}</td>
                </tr>
                @endif
              </table>

            </td>
          </tr>

          <!-- PRODUCTS -->
          <tr>
            <td style="padding:0 30px 30px 30px;">

              <h2 style="color:#111827;">
                🛒 Order Details
              </h2>

              @foreach($orderedProducts as $item)

              @php

              $product = $item['product'];
              $order = $item['order'];

              $convertedPrice = ($product->price ?? 0) * $rate;
              $convertedSubtotal = ($item['subtotal'] ?? 0) * $rate;

              $options = [];

              if (!empty($order->product_option)) {
              $options = json_decode($order->product_option, true) ?? [];
              }

              $tags = [];

              if (!empty($product->tags)) {
              $tags = json_decode($product->tags, true) ?? [];
              }

              @endphp

              <table width="100%" cellpadding="0" cellspacing="0"
                style="margin-bottom:25px;border:1px solid #e5e7eb;border-radius:10px;overflow:hidden;">

                <tr>
                  <td style="background:#f9fafb;padding:20px;">

                    <h3 style="margin:0 0 15px 0;color:#111827;">
                      {{ $product->name ?? $product->title }}
                    </h3>

                    @if(!empty($product->main_image))
                    <div style="margin-bottom:15px;">
                      <img src="{{ asset($product->main_image) }}" alt="{{ $product->name }}"
                        style="max-width:220px;border-radius:8px;">
                    </div>
                    @endif

                    <table width="100%" cellpadding="8" cellspacing="0" border="1"
                      style="border-collapse:collapse;background:#fff;">

                      <tr>
                        <td width="200"><strong>📦 Quantity</strong></td>
                        <td>{{ $item['quantity'] }}</td>
                      </tr>

                      <tr>
                        <td><strong>💰 Unit Price</strong></td>
                        <td>{{ $symbol }}{{ number_format($convertedPrice, 2) }}</td>
                      </tr>

                      <tr>
                        <td><strong>🧾 Subtotal</strong></td>
                        <td>{{ $symbol }}{{ number_format($convertedSubtotal, 2) }}</td>
                      </tr>

                      @if(!empty($product->sku))
                      <tr>
                        <td><strong>🏷 SKU</strong></td>
                        <td>{{ $product->sku }}</td>
                      </tr>
                      @endif

                      @if(!empty($order->purchase_type))
                      <tr>
                        <td><strong>🛍 Purchase Type</strong></td>
                        <td>{{ ucwords(str_replace('_',' ',$order->purchase_type)) }}</td>
                      </tr>
                      @endif

                    </table>

                    @if(!empty($options))
                    <div style="margin-top:20px;">

                      <h4 style="margin-bottom:10px;">
                        ⚙ Selected Options
                      </h4>

                      <ul style="padding-left:18px;">

                        @foreach($options as $key => $value)

                        @if(!empty($value))

                        @if(filter_var($value, FILTER_VALIDATE_URL))

                        <li>
                          <strong>{{ ucwords(str_replace('_',' ',$key)) }}:</strong>
                          <a href="{{ $value }}" target="_blank">View Image</a>
                        </li>

                        @else

                        <li>
                          <strong>{{ ucwords(str_replace('_',' ',$key)) }}:</strong>
                          {{ $value }}
                        </li>

                        @endif

                        @endif

                        @endforeach

                      </ul>

                    </div>
                    @endif

                    @if(!empty($product->description))
                    <div style="margin-top:20px;">

                      <h4>
                        📖 Product Description
                      </h4>

                      <div style="line-height:1.7;color:#555;">
                        {!! nl2br(e($product->description)) !!}
                      </div>

                    </div>
                    @endif

                    @if(count($tags))
                    <div style="margin-top:20px;">

                      <h4>
                        🔖 Categories
                      </h4>

                      @foreach($tags as $tag)

                      <span style="
                            display:inline-block;
                            background:#eef2ff;
                            color:#3730a3;
                            padding:8px 12px;
                            margin:4px;
                            border-radius:25px;
                            font-size:12px;
                            font-weight:bold;">
                        {{ $tag }}
                      </span>

                      @endforeach

                    </div>
                    @endif

                  </td>
                </tr>

              </table>

              @endforeach

              <!-- TOTAL -->
              <table width="100%" cellpadding="15" cellspacing="0"
                style="background:#111827;color:#fff;border-radius:8px;">
                <tr>
                  <td align="right">
                    <strong style="font-size:20px;">
                      Total: {{ $symbol }}{{ number_format($total * $rate, 2) }}
                    </strong>
                  </td>
                </tr>
              </table>

            </td>
          </tr>

          <!-- RECOMMENDATION -->
          <tr>
            <td style="padding:30px;">

              <h2 style="color:#111827;">
                ✨ Discover More Products You'll Love
              </h2>

              <p style="line-height:1.8;">
                Based on your interests, we invite you to explore more wellness,
                beauty, weight-management, and lifestyle products available
                in our premium Slimza collection.
              </p>

              <div style="
            background:#f9fafb;
            border-left:4px solid #111827;
            padding:15px;
            margin:20px 0;">

                <strong>
                  Looking for similar products?
                </strong>

                <br><br>

                Browse our complete collection and discover products tailored
                to your wellness goals.

                <br><br>

                <a href="https://slimza.com/search-product/Radiance & Beauty" target="_blank" style="
                background:#111827;
                color:#fff;
                text-decoration:none;
                padding:12px 20px;
                border-radius:6px;
                display:inline-block;">
                  🔍 Explore More Products
                </a>

              </div>

            </td>
          </tr>

          <!-- SUPPORT -->
          <tr>
            <td style="padding:30px;background:#f9fafb;">

              <h3 style="margin-top:0;">
                💬 Need Assistance?
              </h3>

              <p style="line-height:1.8;">
                Our customer support team is always happy to help with
                product information, order enquiries, delivery updates,
                or general assistance.
              </p>

              <p>
                📧 Email:
                <a href="mailto:info@slimza.com">
                  info@slimza.com
                </a>
              </p>

              <p style="color:#666;font-size:13px;margin-top:25px;">
                Thank you for choosing Slimza.
                We truly appreciate your trust and look forward to supporting
                your health and wellness journey.
              </p>

            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td style="background:#111827;color:#d1d5db;text-align:center;padding:20px;">
              © {{ date('Y') }} Slimza. All Rights Reserved.
            </td>
          </tr>
          ```

        </table>

      </td>
    </tr>
  </table>

</body>

</html>