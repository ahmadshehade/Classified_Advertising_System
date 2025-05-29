<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Advertisement Updated</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .header {
            background-color: #0d6efd;
            color: #fff;
            padding: 20px 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
            color: #333;
        }
        .content p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .details {
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            padding: 10px;
            text-align: left;
        }
        .details th {
            background-color: #f0f0f0;
            width: 30%;
        }
        .badge {
            padding: 5px 12px;
            font-size: 14px;
            border-radius: 20px;
            color: #fff;
            display: inline-block;
        }
        .badge-pending { background-color: #ffc107; color: #000; }
        .badge-active { background-color: #28a745; }
        .badge-rejected { background-color: #dc3545; }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #999;
            padding: 20px;
            border-top: 1px solid #eee;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0d6efd;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Advertisement Updated</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>The following advertisement has been updated. Here are the latest details:</p>

            <div class="details">
                <table>
                    <tr>
                        <th>Title</th>
                        <td>{{ $ads->title }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $ads->description ?? 'No description provided.' }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>${{ $ads->price }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge badge-{{ strtolower($ads->status) }}">
                                {{ ucfirst($ads->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ optional($ads->category)->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>User</th>
                        <td>{{ optional($ads->user)->name ?? 'System' }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $ads->updated_at?->format('Y-m-d H:i') ?? 'Unknown' }}</td>
                    </tr>
                </table>
            </div>

            <a href="{{ url('/ads/' . $ads->id) }}" class="btn" target="_blank">View Advertisement</a>

            <p style="margin-top: 30px;">Thank you for using our system.</p>
        </div>

        <div class="footer">
            &copy; {{ now()->year }} Advertisement Management System. All rights reserved.
        </div>
    </div>
</body>
</html>
