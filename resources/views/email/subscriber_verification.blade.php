<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-header {
            background-color: #4CAF50;
            color: #ffffff;
            text-align: center;
            padding: 20px;
            font-size: 24px;
        }

        .email-body {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }

        .email-body h1 {
            font-size: 22px;
            color: #4CAF50;
        }

        .cta-container {
            text-align: center;
            margin-top: 20px;
        }

        .cta-button {
            display: inline-block;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
        }

        .cta-button:hover {
            background-color: #45a049;
        }

        .url {
            color: #808080;
            word-wrap: break-word;
            font-size: 14px;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            color: #777777;
            font-size: 12px;
            padding: 10px 20px;
            background-color: #f9f9f9;
            border-top: 1px solid #dddddd;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            Confirm Your Subscription to {{ config('app.name') }}
        </div>
        <div class="email-body">
            <h1>Dear Subscriber,</h1>
            <p>Thank you for subscribing to <strong>{{ config('app.name') }}.</strong> To ensure that you receive
                updates and exclusive content, we need to verify your email address.</p>
            <div class="cta-container">
                <a href="{{ $url }}" class="cta-button" target="_blank">Verify Subscription</a>
            </div>
            <p>If the button above does not work, please copy and paste the following link into your browser:</p>
            <p class="url">{{ $url }}</p>
            <p>We are excited to have you on board and look forward to sharing valuable updates with you.</p>
            <p>Sincerely,<br>The {{ config('app.name') }} Team</p>
        </div>
        <div class="footer">
            This email was sent by {{ config('app.name') }}. If you did not subscribe, please disregard this message.
        </div>
    </div>
</body>

</html>
