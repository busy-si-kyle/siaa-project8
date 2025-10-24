<?php
require_once 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        
        h1 {
            color: #333;
            margin-bottom: 20px;
            font-size: 32px;
        }
        
        .welcome-message {
            color: #555;
            font-size: 18px;
            margin-bottom: 30px;
        }
        
        .logout-link {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.2s ease;
        }
        
        .logout-link:hover {
            transform: translateY(-2px);
        }
        
        .user-info {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .user-info h2 {
            color: #333;
            margin-bottom: 10px;
        }
        
        .user-info p {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard</h1>
        
        <div class="user-info">
            <h2>Welcome back!</h2>
            <p>Hello, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>!</p>
        </div>
        
        <div class="welcome-message">
            You have successfully logged into the secure dashboard.
        </div>
        
        <a href="logout.php" class="logout-link">Logout</a>
    </div>
</body>
</html>
