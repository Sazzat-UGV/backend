<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>OTP Verification</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
                color: #333;
            }

            .email-container {
                max-width: 600px;
                margin: 40px auto;
                background: #ffffff;
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            .email-header {
                background-color: #ef4444;
                color: #ffffff;
                text-align: center;
                padding: 20px 10px;
            }

            .email-body {
                padding: 20px 30px;
            }

            .email-body h1 {
                font-size: 24px;
                margin: 0 0 10px;
            }

            .email-body p {
                font-size: 16px;
                margin: 10px 0;
                line-height: 1.6;
            }

            .otp {
                font-size: 24px;
                font-weight: bold;
                background-color: #fee2e2; 
                color: #ef4444;
                padding: 15px 0px;
                border-radius: 10px;
                text-align: center;
                margin: 20px 0;
            }

            .email-footer {
                background-color: #f9f9f9;
                text-align: center;
                padding: 10px 20px;
                font-size: 12px;
                color: #777;
                border-top: 1px solid #eee;
            }
        </style>
    </head>

    <body>
        <div class="email-container">
            <div class="email-header">
                <h2>Verification Code</h2>
            </div>
            <div class="email-body">
                <h1>Hello!</h1>
                <p>
                    We received a request to verify your identity. Use the OTP
                    below to complete your action:
                </p>
                <div class="otp">{{ $otp }}</div>
                <p>
                    If you did not request this, please ignore this email or
                    contact support.
                </p>
                <p>Thank you,</p>
            </div>
            <div class="email-footer">
                <p>
                    &copy; 2024 {{ config('app.name') }}. All rights reserved.
                </p>
            </div>
        </div>
    </body>
</html>
