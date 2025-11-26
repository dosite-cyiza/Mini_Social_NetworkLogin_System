<?php
session_start();
require_once 'config/database.php';

// Simulate Google login - create or use mock user
$mock_username = "GoogleUser" . rand(1000, 9999);
$mock_email = "google_user_" . uniqid() . "@gmail.com";
$mock_password = password_hash("google_mock_password", PASSWORD_DEFAULT);

// Check if a Google mock user already exists
$check_query = "SELECT id, username, email FROM users WHERE username LIKE 'GoogleUser%' LIMIT 1";
$result = mysqli_query($conn, $check_query);

if(mysqli_num_rows($result) > 0) {
    // Use existing mock user
    $user = mysqli_fetch_assoc($result);
} else {
    // Create new mock Google user
    $insert_query = "INSERT INTO users (username, email, password) VALUES ('$mock_username', '$mock_email', '$mock_password')";
    
    if(mysqli_query($conn, $insert_query)) {
        $user_id = mysqli_insert_id($conn);
        
        // Fetch the created user
        $fetch_query = "SELECT id, username, email FROM users WHERE id = $user_id";
        $fetch_result = mysqli_query($conn, $fetch_query);
        $user = mysqli_fetch_assoc($fetch_result);
    } else {
        $_SESSION['error'] = "Google login failed. Please try again.";
        header("Location: signin.php");
        exit();
    }
}

// Set session variables
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['email'] = $user['email'];
$_SESSION['success'] = "Successfully logged in with Google!";

// Close connection
mysqli_close($conn);

// Redirect to dashboard
header("Location: dashboard.php");
exit();
?>