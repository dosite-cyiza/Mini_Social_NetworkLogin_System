<?php
session_start();
require_once 'config/database.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize input
    $username_email = mysqli_real_escape_string($conn, trim($_POST['username_email']));
    $password = $_POST['password'];
    
    // Check for empty fields
    if(empty($username_email) || empty($password)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: signin.php");
        exit();
    }
    
    // Check if user exists
    $query = "SELECT id, username, email, password FROM users WHERE username = '$username_email' OR email = '$username_email'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password
        if(password_verify($password, $user['password'])) {
            // Update last login
            $user_id = $user['id'];
            $update_query = "UPDATE users SET last_login = NOW() WHERE id = $user_id";
            mysqli_query($conn, $update_query);
            
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            
            // Redirect to dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Wrong password";
            header("Location: signin.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Account not found";
        header("Location: signin.php");
        exit();
    }
}

// Close connection
mysqli_close($conn);
?>