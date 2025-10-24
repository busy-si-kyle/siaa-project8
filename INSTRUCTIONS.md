# PHP SQLite Authentication System

## Install & Run

**Install PHP:**
- Windows: Download from [php.net](https://windows.php.net/download/)
- Linux: `sudo apt install php php-sqlite3` (Ubuntu/Debian) or `sudo yum install php php-pdo php-sqlite3` (CentOS/RHEL)
- macOS: `brew install php`

**Start server:**
```bash
php -S localhost:8000
```

**Open browser:**
```
http://localhost:8000/login.php
```

## Usage

1. **Register**: Fill bottom form → click Register
2. **Login**: Fill top form → click Login  
3. **Dashboard**: Automatically protected, shows "Hello, [Username]!"
4. **Logout**: Click logout button

## Create New Protected Pages

Just add this to any PHP file:
```php
<?php
require_once 'auth.php';
?>
<!-- Your page content -->
<h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
```

**That's it!** Page is automatically protected.

## Files

- `auth.php` - Core authentication (auto-protects all pages)
- `login.php` - Login/register forms
- `logout.php` - Logout handler
- `dashboard.php` - Example protected page
- `users.db` - Database (auto-created)

## Troubleshooting

- **"Database connection failed"**: Check `php -m | grep sqlite`
- **"Permission denied"**: Run `chmod 755 .`
- **Page redirects to login**: Make sure you're logged in first
