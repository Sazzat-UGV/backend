<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>New Contact Message</title>
</head>

<body style="margin: 0; padding: 20px; background: #f4f6f8; font-family: 'Helvetica Neue', sans-serif;">
    <table cellpadding="0" cellspacing="0"
        style="max-width: 620px; width: 100%; margin: 0 auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 14px rgba(0,0,0,0.07);">
        <!-- Header -->
        <tr>
            <td
                style="background: linear-gradient(135deg, #EF4444, #EF4444); padding: 30px; text-align: center; color: #ffffff;">
                <h2 style="margin: 0; font-size: 24px;">New Contact Message</h2>
                <p style="margin: 5px 0 0; font-size: 15px;">Someone reached out via your website</p>
            </td>
        </tr>

        <!-- Body -->
        <tr>
            <td style="padding: 30px;">
                <p style="font-size: 16px; margin-top: 0;">Hello Admin,</p>
                <p style="font-size: 15px;">You’ve received a new message through the contact form. Details are below:
                </p>

                <table cellpadding="6" cellspacing="0" style="width: 100%; font-size: 15px; color: #333;">
                    <tr>
                        <td width="30%"><strong>Name:</strong></td>
                        <td>{{ $message_data['name'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $message_data['email'] }}</td>
                    </tr>
                    <tr>
                        <td><strong>Subject:</strong></td>
                        <td>{{ $message_data['subject'] }}</td>
                    </tr>
                    <tr>
                        <td valign="top"><strong>Message:</strong></td>
                        <td>
                            <div
                                style="padding: 12px; background-color: #f9fafb; border-left: 4px solid #EF4444; border-radius: 4px; font-style: italic;">
                                {{ $message_data['message'] }}
                            </div>
                        </td>
                    </tr>
                </table>

                <p style="margin-top: 30px;">Thanks,<br><strong>Your Website Team</strong></p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td style="background-color: #f1f1f1; padding: 16px; text-align: center; font-size: 13px; color: #777;">
                &copy; {{ Date('Y') }} YourCompany.com — All rights reserved.
            </td>
        </tr>
    </table>
</body>

</html>
