<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Video Action Notification</title>
    <style>
        body,
        p,
        h1,
        a {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        body {
            background-color: #f5f7fa;
            padding: 20px 10px;
            color: #444444;
        }

        .email-container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(90deg, #0066cc, #004a99);
            padding: 25px 30px;
            color: #ffffff;
            text-align: center;
            font-size: 26px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .content {
            padding: 30px 35px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
            color: #555555;
        }

        .content p.greeting {
            font-weight: 600;
            color: #333333;
        }

        .button-container {
            text-align: center;
            margin-top: 30px;
        }

        a.button {
            background-color: #0066cc;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            display: inline-block;
            box-shadow: 0 4px 10px rgba(0, 102, 204, 0.4);
            transition: background-color 0.3s ease;
        }

        a.button:hover {
            background-color: #004a99;
        }

        .footer {
            background-color: #f0f2f7;
            text-align: center;
            padding: 20px 30px;
            font-size: 13px;
            color: #888888;
            border-top: 1px solid #e2e4e8;
        }

        @media only screen and (max-width: 620px) {
            .email-container {
                width: 100% !important;
                border-radius: 0;
                box-shadow: none;
            }

            .header {
                font-size: 22px;
                padding: 20px 15px;
            }

            .content {
                padding: 20px 15px;
            }

            .button-container {
                margin-top: 20px;
            }

            a.button {
                padding: 12px 20px;
                font-size: 15px;
            }

            .footer {
                font-size: 12px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <div class="email-container" role="article" aria-roledescription="email" aria-label="Video Action Notification">

        <div class="content">
            <p class="greeting">Hello {{ $data['video_publisher_name'] }},</p>

            <p>{!! $data['actionMessage'] !!}</p>

            <p>If you have any questions, please don’t hesitate to <a href="mailto:support@yourdomain.com">contact our
                    support team</a>. We're here to help!</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Your MYTSV All rights reserved.
        </div>
    </div>
</body>

</html>
