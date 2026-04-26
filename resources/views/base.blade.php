<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $subject ?? config('app.name') }}</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f5; font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">

    <!-- Outer wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f4f5;">
        <tr>
            <td align="center" style="padding:40px 16px;">

                <!-- Card -->
                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background-color:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.08);">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#18181b; padding:24px 32px;">
                            <span style="color:#f59e0b; font-size:20px; font-weight:700; letter-spacing:0.5px;">
                                {{ config('app.name') }}
                            </span>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f4f4f5; padding:16px 32px; text-align:center;">
                            <p style="margin:0; font-size:12px; color:#71717a;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br />
                                If you did not request this email, you can safely ignore it.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- /Card -->

            </td>
        </tr>
    </table>
    <!-- /Outer wrapper -->

</body>

</html>
