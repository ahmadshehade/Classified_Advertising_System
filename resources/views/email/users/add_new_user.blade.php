<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New User Registered</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            padding: 30px;
            margin: 0;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            margin: auto;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-top: 5px solid #4CAF50;
        }
        .header {
            font-size: 24px;
            color: #333333;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .content {
            font-size: 16px;
            color: #555555;
            line-height: 1.6;
        }
        .user-info {
            background-color: #f9f9f9;
            border-left: 4px solid #4CAF50;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .user-info p {
            margin: 8px 0;
        }
        .label {
            font-weight: bold;
            color: #333;
        }
        .password-box {
            background-color: #e3f2fd;
            border-left: 4px solid #2196F3;
            padding: 10px 15px;
            border-radius: 5px;
            font-family: monospace;
            color: #0d47a1;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #999999;
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">🎉 New User Successfully Registered!</div>

        <div class="content">
            <p>Hello</p>
            <p>A new user has just been added to the system. Here are the details:</p>

            <div class="user-info">
                <p><span class="label">Name:</span> {{ $user->name }}</p>
                <p><span class="label">Email:</span> {{ $user->email }}</p>
                <p><span class="label">Role:</span> {{ ucfirst($user->role) }}</p>
            </div>

            <p><strong>Temporary Password:</strong></p>
            <div class="password-box">
                {{ $password }}
            </div>

            <p>Please make sure the user changes their password upon first login.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Your Company. All rights reserved.
        </div>
    </div>

</body>
</html>
