<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="color-scheme" content="light dark">
    <meta name="supported-color-schemes" content="light dark">
    <title>Dayout Account Mail Campaigns</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        @media (prefers-color-scheme: dark) {
            .email-dark-mode {
                background-color: #333333 !important;
                color: #ffffff !important;
            }
        }

        @media screen and (max-width: 600px) {
            .email-container {
                width: 100% !important;
                padding: 40px 24px !important;
            }

            .app-downloads {
                flex-direction: column !important;
            }

            .store-button {
                width: 100% !important;
                margin: 5px 0 !important;
            }
        }

        @media only screen and (min-width: 601px) {
            .email-container {
                padding: 64px 87px !important;
            }
        }

    </style>
    @stack('css')
</head>
<body style="margin: 0; padding: 0; font-family: 'Poppins', Arial, sans-serif; background-color: #f4f4f4; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
    <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%; margin: 0; padding: 0; background-color: #f4f4f4;">
        <tr>
            <td align="center" style="padding: 0;">
                <table role="presentation" cellpadding="0" cellspacing="0" style="max-width: 697px; width: 100%; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-sizing: border-box;" class="email-container">
                    <tr>
                        <td>
                            <table role="presentation" cellpadding="0" cellspacing="0" style="width: 100%;">
                                @include('emails._partials.test.header')

                                @yield('content')

                                @include('emails._partials.test.footer')
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
