<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>New Advertisement Added</title>
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
            user-select: none;
        }
        .content {
            padding: 30px;
            color: #333;
            line-height: 1.6;
            font-size: 16px;
        }
        .content p {
            margin-bottom: 20px;
        }
        .content h3 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #0d47a1;
            font-weight: 700;
            font-size: 20px;
        }
        .badge {
            display: inline-block;
            padding: 5px 14px;
            font-size: 14px;
            border-radius: 20px;
            font-weight: 600;
            color: white;
            user-select: none;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }
        .badge-active {
            background-color: #28a745;
        }
        .badge-rejected {
            background-color: #dc3545;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #0d6efd;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 20px;
            user-select: none;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #084cdf;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #999;
            padding: 20px;
            border-top: 1px solid #eee;
            user-select: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Advertisement Posted</h1>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>Your new advertisement has been successfully posted!</p>

            <h3>{{ $ads->title }}</h3>

            <p><strong>Description:</strong></p>
            <p>{{ $ads->description }}</p>

            <p><strong>Price:</strong> ${{ $ads->price }}</p>

            <p><strong>Status:</strong>
                <span class="badge badge-{{ strtolower($ads->status) }}">
                    {{ ucfirst($ads->status) }}
                </span>
            </p>

            <a href="{{ url('/ads/'.$ads->id) }}" class="btn" target="_blank" rel="noopener noreferrer">
                View Advertisement
            </a>
        </div>
        <div class="footer">
            <p>This is an automated email from the Advertisement Management System.</p>
            <p>&copy; {{ now()->year }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
