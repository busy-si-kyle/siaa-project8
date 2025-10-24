<?php
require_once 'auth.php';

// Destroy the session completely
session_destroy();

// Redirect to login page
header('Location: login.php');
exit();
?>
