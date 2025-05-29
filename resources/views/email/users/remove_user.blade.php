<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User Removed</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 30px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-top: 5px solid #e53935;
        }
        .header {
            font-size: 22px;
            color: #d32f2f;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .content {
            font-size: 16px;
            color: #444;
            line-height: 1.6;
        }
        .user-info {
            background-color: #fff3f3;
            border-left: 4px solid #d32f2f;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .user-info p {
            margin: 8px 0;
        }
        .label {
            font-weight: bold;
            color: #c62828;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #999;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">User Removed from the System</div>

        <div class="content">
            <p>Hello,</p>
            <p>This is to inform you that the following user has been removed from the system:</p>

            <div class="user-info">
                <p><span class="label">Name:</span> {{ $user->name }}</p>
                <p><span class="label">Email:</span> {{ $user->email }}</p>
                <p><span class="label">Role:</span> {{ ucfirst($user->role) }}</p>
            </div>

            <p>If this action was not intended or you believe it was an error, please contact the system administrator immediately.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </div>
    </div>

</body>
</html>
