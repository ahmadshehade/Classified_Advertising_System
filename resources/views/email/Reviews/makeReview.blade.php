<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Review Added</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 30px;
            color: #2d3748;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }
        .header {
            background-color: #0d6efd;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 25px 30px;
        }
        .content h3 {
            margin-top: 0;
            font-size: 18px;
            color: #1a202c;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
        }
        .details-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .details-table th, .details-table td {
            padding: 10px;
            text-align: left;
        }
        .details-table th {
            width: 30%;
            background-color: #f1f5f9;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            font-size: 13px;
            color: #999;
            padding: 20px;
            border-top: 1px solid #e2e8f0;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #10b981;
            color: #fff;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
        }
        .btn:hover {
            background-color: #0e9e6e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            A New Review Has Been Added
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>A new review was submitted for the advertisement titled:</p>

            <h3>{{ $review->ad->title }}</h3>

            <table class="details-table">
                <tr>
                    <th>Reviewer</th>
                    <td>{{ optional($review->user)->name ?? 'Guest' }}</td>
                </tr>
                <tr>
                    <th>Rating</th>
                    <td>{{ $review->rating }}/5</td>
                </tr>
                <tr>
                    <th>Comment</th>
                    <td>{{ $review->comment ?? 'No comment provided.' }}</td>
                </tr>
                <tr>
                    <th>Reviewed At</th>
                    <td>{{ $review->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            </table>


            <p style="margin-top: 30px;">Thank you for being part of our community.</p>
        </div>
        <div class="footer">
            &copy; {{ now()->year }} Advertisement System. All rights reserved.
        </div>
    </div>
</body>
</html>
