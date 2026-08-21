<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slimza Special Promotion</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f4f6f8;
    font-family:Arial,Helvetica,sans-serif;
">

<table width="100%" cellpadding="0" cellspacing="0" border="0"
       style="background:#f4f6f8;padding:30px 10px;">

    <tr>
        <td align="center">

            <!-- MAIN CONTAINER -->
            <table width="600" cellpadding="0" cellspacing="0" border="0"
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
                        style="padding:25px 20px;background:#ffffff;">

                        <a href="https://slimza.com"
                           style="text-decoration:none;">

                            <img
                                src="https://slimza.com/images/logo.png"
                                alt="Slimza"
                                width="150"
                                style="
                                    display:block;
                                    width:150px;
                                    max-width:100%;
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
                            padding:42px 30px;
                            background:#18201b;
                        ">

                        <p style="
                            margin:0 0 10px;
                            color:#9acb3c;
                            font-size:12px;
                            font-weight:bold;
                            letter-spacing:2px;
                            text-transform:uppercase;
                        ">
                            Slimza Wellness
                        </p>

                        <h1 style="
                            margin:0 0 15px;
                            color:#ffffff;
                            font-size:30px;
                            line-height:1.3;
                        ">
                            Your Health. Your Journey. 💚
                        </h1>

                        <p style="
                            margin:0;
                            color:#d9dedb;
                            font-size:15px;
                            line-height:1.7;
                        ">
                            Discover simple choices that can help you
                            support a healthier and more active lifestyle.
                        </p>

                    </td>
                </tr>


                <!-- PROMOTION -->
                <tr>
                    <td style="padding:35px 30px 20px;">

                        <h2 style="
                            margin:0 0 15px;
                            color:#222222;
                            font-size:23px;
                        ">
                            Special Promotion 🎉
                        </h2>

                        <div style="
                            color:#555555;
                            font-size:15px;
                            line-height:1.8;
                        ">
                            {!! nl2br(e($promotionText)) !!}
                        </div>

                    </td>
                </tr>


                <!-- WELLNESS MESSAGE -->
                <tr>
                    <td style="padding:10px 30px 30px;">

                        <table width="100%" cellpadding="0" cellspacing="0"
                               style="
                                    background:#f5f9ee;
                                    border-radius:10px;
                                    border-left:4px solid #9acb3c;
                               ">

                            <tr>
                                <td style="padding:20px;">

                                    <h3 style="
                                        margin:0 0 8px;
                                        color:#263238;
                                        font-size:17px;
                                    ">
                                        Make Your Wellbeing a Priority 🌿
                                    </h3>

                                    <p style="
                                        margin:0;
                                        color:#606060;
                                        font-size:13px;
                                        line-height:1.7;
                                    ">
                                        A healthier lifestyle starts with
                                        small, consistent choices. Stay active,
                                        nourish your body and give yourself
                                        the care you deserve.
                                    </p>

                                </td>
                            </tr>

                        </table>

                    </td>
                </tr>


                <!-- PRODUCTS -->
                @if(!empty($products))

                <tr>
                    <td style="padding:5px 25px 30px;">

                        <h2 style="
                            margin:0 0 8px;
                            text-align:center;
                            color:#222222;
                            font-size:22px;
                        ">
                            Recommended For You
                        </h2>

                        <p style="
                            margin:0 0 25px;
                            text-align:center;
                            color:#777777;
                            font-size:13px;
                            line-height:1.6;
                        ">
                            Explore our wellness products and find something
                            that fits your routine.
                        </p>


                        @foreach($products as $product)

                            @php

                                /*
                                |--------------------------------------------------------------------------
                                | Product Name
                                |--------------------------------------------------------------------------
                                */

                                $productName = $product['name']
                                    ?? $product['product_name']
                                    ?? 'Slimza Product';


                                /*
                                |--------------------------------------------------------------------------
                                | Slug
                                |--------------------------------------------------------------------------
                                */

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


                                /*
                                |--------------------------------------------------------------------------
                                | Product URL
                                |--------------------------------------------------------------------------
                                */

                                $productId = $product['id'] ?? '';

                                $productUrl =
                                    'https://slimza.com/product-details/' .
                                    $slug .
                                    '/' .
                                    $productId;


                                /*
                                |--------------------------------------------------------------------------
                                | Product Image
                                |--------------------------------------------------------------------------
                                */

                               $productImage = $product['main_image'] ?? '';


                                /*
                                |--------------------------------------------------------------------------
                                | Product Price
                                |--------------------------------------------------------------------------
                                */

                                $price =
                                    $product['price']
                                    ?? null;


                                /*
                                |--------------------------------------------------------------------------
                                | Old Price
                                |--------------------------------------------------------------------------
                                */

                                $oldPrice =
                                    $product['old_price']
                                    ?? $product['oldPrice']
                                    ?? null;


                                /*
                                |--------------------------------------------------------------------------
                                | Description
                                |--------------------------------------------------------------------------
                                */

                                $description =
                                    $product['description']
                                    ?? '';

                            @endphp


                            <!-- PRODUCT CARD -->

                            <table width="100%"
                                   cellpadding="0"
                                   cellspacing="0"
                                   border="0"
                                   style="
                                        margin-bottom:18px;
                                        border:1px solid #e8e8e8;
                                        border-radius:12px;
                                        overflow:hidden;
                                        background:#ffffff;
                                   ">

                                <tr>

                                    <!-- IMAGE -->

                                    <td width="190"
                                        valign="top"
                                        style="
                                            width:190px;
                                            padding:15px;
                                            background:#fafafa;
                                        ">

                                @if(!empty($productImage))
    <img
        src="{{ $productImage }}"
        alt="{{ $productName }}"
        width="160"
        height="160"
        style="
            display:block;
            width:160px;
            height:160px;
            border:0;
        "
    >
@else
    <p style="color:red;">
        IMAGE URL NOT FOUND
    </p>
@endif

                                    </td>


                                    <!-- DETAILS -->

                                    <td valign="top"
                                        style="padding:18px 15px 18px 5px;">

                                        <h3 style="
                                            margin:0 0 8px;
                                            color:#222222;
                                            font-size:17px;
                                            line-height:1.4;
                                        ">
                                            {{ $productName }}
                                        </h3>


                                        @if($description)

                                            <p style="
                                                margin:0 0 12px;
                                                color:#777777;
                                                font-size:12px;
                                                line-height:1.6;
                                            ">
                                                {{ \Illuminate\Support\Str::limit(
                                                    strip_tags($description),
                                                    105
                                                ) }}
                                            </p>

                                        @endif


                                        <!-- PRICE -->

                                        <div style="margin-bottom:13px;">

                                            @if($oldPrice)

                                                <span style="
                                                    color:#999999;
                                                    font-size:12px;
                                                    text-decoration:line-through;
                                                    margin-right:5px;
                                                ">
                                                    £{{ number_format((float)$oldPrice, 2) }}
                                                </span>

                                            @endif

                                            @if($price !== null)

                                                <span style="
                                                    color:#78a82d;
                                                    font-size:18px;
                                                    font-weight:bold;
                                                ">
                                                    £{{ number_format((float)$price, 2) }}
                                                </span>

                                            @endif

                                        </div>


                                        <!-- BUTTON -->

                                        <a href="{{ $productUrl }}"
                                           style="
                                                display:inline-block;
                                                padding:9px 16px;
                                                background:#8fbd3f;
                                                color:#ffffff;
                                                text-decoration:none;
                                                border-radius:6px;
                                                font-size:12px;
                                                font-weight:bold;
                                           ">
                                            View Details
                                        </a>

                                    </td>

                                </tr>

                            </table>

                        @endforeach

                    </td>
                </tr>

                @endif


                <!-- HEALTH MESSAGE -->

                <tr>
                    <td align="center"
                        style="
                            padding:35px 30px;
                            background:#fafafa;
                        ">

                        <h2 style="
                            margin:0 0 12px;
                            color:#222222;
                            font-size:21px;
                        ">
                            Support Your Wellness Journey 🌱
                        </h2>

                        <p style="
                            margin:0;
                            color:#666666;
                            font-size:13px;
                            line-height:1.8;
                        ">
                            From everyday wellness essentials to products
                            such as Shilajit and tea, Slimza brings together
                            options designed to complement your healthy
                            lifestyle.
                        </p>

                    </td>
                </tr>


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
                            Start Your Wellness Journey Today
                        </h2>

                        <p style="
                            margin:0 0 20px;
                            color:#d5d9d6;
                            font-size:13px;
                            line-height:1.6;
                        ">
                            Explore Slimza and discover products for your
                            health and fitness routine.
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
                            Explore Slimza
                        </a>

                    </td>
                </tr>


                <!-- FOOTER -->

                <tr>
                    <td align="center"
                        style="padding:25px 20px;">

                        <img
                            src="https://slimza.com/images/logo.png"
                            alt="Slimza"
                            width="100"
                            style="
                                width:100px;
                                height:auto;
                                display:block;
                                margin:0 auto 12px;
                            "
                        >

                        <p style="
                            margin:0 0 6px;
                            color:#777777;
                            font-size:11px;
                        ">
                            Thank you for being part of the Slimza community.
                        </p>

                        <p style="
                            margin:0;
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