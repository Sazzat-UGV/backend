<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List Report</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333;
            text-align: center;
        }

        .container {
            display: inline-block;
            padding: 30px;
            width: 100%;
            max-width: 800px;
            box-sizing: border-box;
            text-align: left;
        }

        .header {
            padding-bottom: 20px;
            border-bottom: 2px solid #444;
            margin-bottom: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #1a1a1a;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }

        table th {
            background-color: #f2f2f2;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            padding-top: 10px;
            border-top: 1px solid #ccc;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <img src="{{ public_path('uploads/settings') }}/{{ $site_logo }}" alt="Company Logo">
            <h1>User List Report</h1>
            <p>Generated on {{ \Carbon\Carbon::now()->format('d M, Y h:i A') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>&copy; {{ \Carbon\Carbon::now()->year }} {{ $site_name }} | All rights reserved.</p>
        </div>
    </div>

</body>

</html>
