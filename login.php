<?php
require_once 'auth.php';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Handle login
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            setFlashMessage('Please fill in all fields.', 'error');
        } elseif (loginUser($username, $password)) {
            header('Location: dashboard.php');
            exit();
        } else {
            setFlashMessage('Invalid username or password.', 'error');
        }
    } elseif (isset($_POST['register'])) {
        // Handle registration
        $username = trim($_POST['reg_username'] ?? '');
        $password = $_POST['reg_password'] ?? '';
        
        if (empty($username) || empty($password)) {
            setFlashMessage('Please fill in all fields.', 'error');
        } elseif (strlen($password) < 6) {
            setFlashMessage('Password must be at least 6 characters long.', 'error');
        } elseif (registerUser($username, $password)) {
            setFlashMessage('Registration successful! You can now log in.', 'success');
        } else {
            setFlashMessage('Username already exists or registration failed.', 'error');
        }
    }
}

// Get flash message
$flash = getFlashMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
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
            max-width: 400px;
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-weight: 500;
        }
        
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e1e5e9;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        input[type="text"]:focus, input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
        }
        
        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
        }
        
        button:hover {
            transform: translateY(-2px);
        }
        
        .divider {
            text-align: center;
            margin: 30px 0;
            position: relative;
            color: #999;
        }
        
        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e5e9;
        }
        
        .divider span {
            background: white;
            padding: 0 15px;
        }
        
        .flash-message {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .flash-message.error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        
        .flash-message.success {
            background: #efe;
            color: #363;
            border: 1px solid #cfc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome</h1>
        
        <?php if ($flash): ?>
            <div class="flash-message <?php echo htmlspecialchars($flash['type']); ?>">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
        <?php endif; ?>
        
        <!-- Login Form -->
        <form method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login">Login</button>
        </form>
        
        <div class="divider">
            <span>or</span>
        </div>
        
        <!-- Registration Form -->
        <form method="POST">
            <div class="form-group">
                <label for="reg_username">Username:</label>
                <input type="text" id="reg_username" name="reg_username" required>
            </div>
            <div class="form-group">
                <label for="reg_password">Password:</label>
                <input type="password" id="reg_password" name="reg_password" required minlength="6">
            </div>
            <button type="submit" name="register">Register</button>
        </form>
    </div>
</body>
</html>
