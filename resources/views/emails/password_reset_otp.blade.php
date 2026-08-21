<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Slimza Password</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f2f4f3;
    font-family:Arial, Helvetica, sans-serif;
    color:#080b0a;
">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="
    background:#f2f4f3;
    padding:40px 15px;
">
    <tr>
        <td align="center">

            <!-- Main Container -->
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="
                max-width:600px;
                background:#ffffff;
                border-radius:18px;
                overflow:hidden;
            ">

                <!-- Header -->
                <tr>
                    <td align="center" style="
                        background:#080b0a;
                        padding:28px 20px;
                    ">

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

                    </td>
                </tr>


                <!-- Content -->
                <tr>
                    <td style="
                        padding:42px 45px 35px;
                        text-align:center;
                    ">

                        <!-- Lock Icon -->
                        <div style="
                            width:58px;
                            height:58px;
                            line-height:58px;
                            margin:0 auto 22px;
                            background:#f4ffd9;
                            border-radius:50%;
                            font-size:27px;
                        ">
                            🔐
                        </div>


                        <!-- Heading -->
                        <h1 style="
                            margin:0 0 12px;
                            color:#080b0a;
                            font-size:28px;
                            line-height:1.3;
                            font-weight:700;
                        ">
                            Reset Your Password
                        </h1>


                        <!-- Greeting -->
                        <p style="
                            margin:0 0 18px;
                            color:#667085;
                            font-size:15px;
                            line-height:1.7;
                        ">
                            Hello <strong style="color:#080b0a;">
                                {{ $user->name }}
                            </strong>,
                        </p>


                        <p style="
                            margin:0;
                            color:#667085;
                            font-size:15px;
                            line-height:1.7;
                        ">
                            We received a request to reset the password
                            for your Slimza account.
                        </p>


                        <p style="
                            margin:8px 0 0;
                            color:#667085;
                            font-size:15px;
                            line-height:1.7;
                        ">
                            Enter the verification code below to continue.
                        </p>


                        <!-- OTP Card -->
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="
                            margin:30px 0 22px;
                            background:#f4ffd9;
                            border:1px solid #dff49b;
                            border-radius:14px;
                        ">
                            <tr>
                                <td align="center" style="
                                    padding:25px 15px;
                                ">

                                    <div style="
                                        margin-bottom:10px;
                                        color:#667085;
                                        font-size:12px;
                                        font-weight:600;
                                        letter-spacing:1px;
                                        text-transform:uppercase;
                                    ">
                                        Your Verification Code
                                    </div>


                                    <!-- OTP -->
                                    <table cellpadding="0" cellspacing="0" border="0" align="center">
                                        <tr>

                                            <td style="
                                                padding-right:12px;
                                                color:#080b0a;
                                                font-size:36px;
                                                line-height:45px;
                                                font-weight:700;
                                                letter-spacing:8px;
                                            ">
                                                {{ $otp }}
                                            </td>

                                            <!-- Copy Icon -->
                                            <td valign="middle" style="
                                                padding-left:5px;
                                            ">

                                                <div style="
                                                    width:32px;
                                                    height:32px;
                                                    line-height:32px;
                                                    background:#080b0a;
                                                    border-radius:8px;
                                                    color:#a4fd0c;
                                                    font-size:16px;
                                                    text-align:center;
                                                    font-weight:bold;
                                                ">
                                                    ⧉
                                                </div>

                                            </td>

                                        </tr>
                                    </table>


                                    <div style="
                                        margin-top:12px;
                                        color:#667085;
                                        font-size:12px;
                                    ">
                                        Select and copy the code above
                                    </div>

                                </td>
                            </tr>
                        </table>


                        <!-- Expiry -->
                        <p style="
                            margin:0;
                            color:#667085;
                            font-size:14px;
                            line-height:1.6;
                        ">
                            This verification code will expire in
                            <strong style="color:#080b0a;">
                                10 minutes
                            </strong>.
                        </p>


                        <!-- Security Notice -->
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="
                            margin-top:28px;
                            background:#f8faf9;
                            border-radius:10px;
                        ">
                            <tr>
                                <td style="
                                    padding:16px 18px;
                                    text-align:left;
                                    border-left:4px solid #a4fd0c;
                                ">

                                    <p style="
                                        margin:0;
                                        color:#344054;
                                        font-size:13px;
                                        line-height:1.6;
                                    ">
                                        <strong style="color:#080b0a;">
                                            Security notice:
                                        </strong>
                                        Slimza will never ask you to share your
                                        password or verification code with anyone.
                                    </p>

                                </td>
                            </tr>
                        </table>


                        <!-- Didn't Request -->
                        <p style="
                            margin:28px 0 0;
                            color:#98a2b3;
                            font-size:12px;
                            line-height:1.7;
                        ">
                            If you did not request a password reset,
                            no action is required. You can safely ignore
                            this email and your account will remain secure.
                        </p>

                    </td>
                </tr>


                <!-- Footer -->
                <tr>
                    <td style="
                        background:#080b0a;
                        padding:25px 30px;
                        text-align:center;
                    ">

                        <p style="
                            margin:0 0 8px;
                            color:#a4fd0c;
                            font-size:14px;
                            font-weight:700;
                        ">
                            Slimza
                        </p>

                        <p style="
                            margin:0;
                            color:#98a2b3;
                            font-size:12px;
                            line-height:1.6;
                        ">
                            Your account security matters to us.
                        </p>

                        <p style="
                            margin:12px 0 0;
                            color:#667085;
                            font-size:11px;
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