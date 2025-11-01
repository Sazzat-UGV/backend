<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background: #004a99;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .content h2 {
            margin-top: 0;
        }
        .footer {
            background: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #666;
        }
        .footer a {
            color: #004a99;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="content">
            <h2>Hello Admin,</h2>
            <p>You have received a new message from the contact form on the {{ config('app.name') }} website. Here are the details:</p>
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Name</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $fullname }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Email</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $email }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Subject</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $subject }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; background-color: #f9f9f9;"><strong>Message</strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $mail_message }}</td>
                </tr>
            </table>
            <p style="margin-top: 20px;">Please follow up with the sender promptly.</p>
            <p>Best regards,</p>
            <p>The {{ config('app.name') }} Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ Date('Y') }} {{ config('app.name') }}. All rights reserved. | <a href="#">Visit Our Website</a></p>
        </div>
    </div>
</body>
</html>
