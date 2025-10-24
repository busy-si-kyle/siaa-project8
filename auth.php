<?php
// Core Authentication Library
session_start();

// Database connection
function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO('sqlite:users.db');
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            createUsersTable($pdo);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    return $pdo;
}

// Create users table if it doesn't exist
function createUsersTable($pdo) {
    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL
    )";
    $pdo->exec($sql);
}

// Register a new user
function registerUser($username, $password) {
    try {
        $pdo = getDB();
        
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        // Insert user with prepared statement
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $result = $stmt->execute([$username, $hashedPassword]);
        
        return $result;
    } catch (PDOException $e) {
        // Username already exists or other error
        return false;
    }
}

// Login user
function loginUser($username, $password) {
    try {
        $pdo = getDB();
        
        // Get user by username with prepared statement
        $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            return true;
        }
        
        return false;
    } catch (PDOException $e) {
        return false;
    }
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Require login - redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit();
    }
}

// Flash message functions for styled error/success messages
function setFlashMessage($message, $type = 'error') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

function getFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $message = $_SESSION['flash_message'];
        $type = $_SESSION['flash_type'] ?? 'error';
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}

// Universal Auto-Protection System
// Automatically protects ALL pages by default except explicitly whitelisted public pages
$currentFile = basename($_SERVER['PHP_SELF']);

// Define public pages that don't require authentication (whitelist)
$publicPages = ['login.php', 'logout.php', 'register.php'];

// If current page is NOT in the public list and user is not logged in, redirect to login
if (!in_array($currentFile, $publicPages) && !isLoggedIn()) {
    header('Location: login.php');
    exit();
}
?>
