<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Bundle Order Confirmation</title>
</head>

<body style="margin:0;padding:30px;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;">

<div style="max-width:700px;margin:auto;background:#fff;border-radius:10px;overflow:hidden;">

    <div style="background:#000;padding:20px;text-align:center;">
        <h2 style="color:#9eef0b;margin:0;">
            Bundle Order Confirmation
        </h2>
    </div>

    <div style="padding:30px;">

        <h3>Hello {{ $bundleOrder->first_name }} {{ $bundleOrder->last_name }},</h3>

        <p>
            Thank you for your bundle order.
            Your order has been received successfully.
        </p>

        <hr>

        <h3>Order Information</h3>

        <table width="100%" cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse;">

            <tr>
                <td><strong>Order ID</strong></td>
                <td>#{{ $bundleOrder->id }}</td>
            </tr>

            <tr>
                <td><strong>Status</strong></td>
                <td>{{ $bundleOrder->order_status }}</td>
            </tr>

            <tr>
                <td><strong>Payment</strong></td>
                <td>
                    {{ $bundleOrder->payment_status ? 'Paid' : 'Pending' }}
                </td>
            </tr>

            <tr>
                <td><strong>Total Items</strong></td>
                <td>{{ $bundleOrder->item_count }}</td>
            </tr>

            <tr>
                <td><strong>Subtotal</strong></td>
                <td>£{{ number_format($bundleOrder->subtotal,2) }}</td>
            </tr>

            <tr>
                <td><strong>Discount</strong></td>
                <td>{{ $bundleOrder->discount_percentage }}%</td>
            </tr>

            <tr>
                <td><strong>Total</strong></td>
                <td>
                    <strong>
                        £{{ number_format($bundleOrder->total,2) }}
                    </strong>
                </td>
            </tr>

        </table>

        <br>

        <h3>Bundle Products</h3>

        <table width="100%" cellpadding="8" cellspacing="0" border="1" style="border-collapse:collapse;">

            <thead>

            <tr style="background:#efefef;">

                <th align="left">Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>

            </tr>

            </thead>

            <tbody>

            @foreach($bundleOrder->products as $product)

                <tr>

                    <td>{{ $product['name'] }}</td>

                    <td align="center">
                        {{ $product['qty'] }}
                    </td>

                    <td align="center">
                        £{{ number_format($product['price'],2) }}
                    </td>

                    <td align="center">
                        £{{ number_format($product['price'] * $product['qty'],2) }}
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

        <br>

        <h3>Shipping Address</h3>

        <p>
            {{ $bundleOrder->address_1 }}<br>
            {{ $bundleOrder->address_2 }}<br>
            {{ $bundleOrder->city }},
            {{ $bundleOrder->state }}<br>
            {{ $bundleOrder->postcode }}<br>
            {{ $bundleOrder->country }}
        </p>

        <br>

        <p>
            We will notify you once your bundle order has been processed.
        </p>

        <br>

        <p>
            Regards,<br>
            <strong>Slimza Team</strong>
        </p>

    </div>

</div>

</body>
</html>