<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <style>
        @media only screen and (max-width: 600px) {
            .inner-body {
                width: 100% !important;
            }

            .footer {
                width: 100% !important;
            }
        }

        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            background-color: #FFFBF5;
            /* Ivory Background */
            color: #374151;
            margin: 0;
            padding: 0;
            width: 100% !important;
            -webkit-text-size-adjust: none;
        }

        .wrapper {
            background-color: #FFFBF5;
            /* Ivory Wrapper */
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .content {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .header {
            padding: 25px 0;
            text-align: center;
        }

        .header a {
            color: #10b981;
            /* Emerald Text */
            font-size: 19px;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }

        .body {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin: 0 auto;
            max-width: 570px;
            width: 100%;
        }

        .inner-body {
            box-sizing: border-box;
            background-color: #ffffff;
            border-radius: 8px;
            margin: 0 auto;
            padding: 32px;
            width: 570px;
        }

        .footer {
            margin: 0 auto;
            padding: 32px;
            text-align: center;
            width: 570px;
        }

        .footer p {
            color: #9ca3af;
            font-size: 12px;
            line-height: 1.5em;
            text-align: center;
        }

        h1 {
            color: #111827;
            font-size: 24px;
            font-weight: bold;
            margin-top: 0;
            text-align: left;
        }

        h2 {
            color: #111827;
            font-size: 18px;
            font-weight: bold;
            margin-top: 24px;
            text-align: left;
        }

        p {
            color: #4b5563;
            font-size: 16px;
            line-height: 1.6em;
            margin-top: 0;
            text-align: left;
        }

        a {
            color: #10b981;
            /* Emerald Link */
        }

        .button {
            -webkit-text-size-adjust: none;
            border-radius: 6px;
            color: #fff;
            display: inline-block;
            overflow: hidden;
            text-decoration: none;
            background-color: #10b981;
            /* Emerald Button */
            border-bottom: 8px solid #10b981;
            border-left: 18px solid #10b981;
            border-right: 18px solid #10b981;
            border-top: 8px solid #10b981;
            font-weight: 600;
        }

        .button-red {
            background-color: #ef4444;
            border-bottom: 8px solid #ef4444;
            border-left: 18px solid #ef4444;
            border-right: 18px solid #ef4444;
            border-top: 8px solid #ef4444;
        }

        .button-green {
            background-color: #10b981;
            border-bottom: 8px solid #10b981;
            border-left: 18px solid #10b981;
            border-right: 18px solid #10b981;
            border-top: 8px solid #10b981;
        }

        .panel {
            border-left: #10b981 solid 4px;
            /* Emerald Border */
            background-color: #FFFBF5;
            /* Ivory Panel Background */
            margin: 24px 0;
            padding: 16px 24px;
        }

        .panel-content p {
            color: #4b5563;
            margin: 0;
        }
    </style>
</head>

<body>
    <table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
                    {{ $header ?? '' }}

                    <!-- Body -->
                    <tr>
                        <td class="body" width="100%" cellpadding="0" cellspacing="0">
                            <table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0"
                                role="presentation">
                                <tr>
                                    <td class="content-cell">
                                        {{ Illuminate\Mail\Markdown::parse($slot) }}

                                        {{ $subcopy ?? '' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{ $footer ?? '' }}
                </table>
            </td>
        </tr>
    </table>
</body>

</html>