<?php
session_start();
require_once 'config/database.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    // get and sanitixer input data

    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = $_POST['password'];
    $confirm_password  = $_POST['confirm_password'];

    $errors = array();

    // Validation

    if(empty($email) || empty($usenrame)|| empty($password) || empty($confirm_password)){
        $errors[] = "All fields are required";
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors[] ='Invalid email format';
    }

    if(strlen($password) < 6){
        $errors[] ="Password must be atleast 6 characters";
    }
    if($password != $confirm_password){
        $errors[] = "Password do not match";
    }

    // Check if username and email already exist.

if(empty($errors)){
    $check_query ="SELECT id FROM users WHERE username='$username' OR email ='$email'";
    $result = mysqli_query($conn,$check_query);

    if(mysqli_num_rows($result)>0){
        $errors[]="Username or email already exists ";
    }
}
// Insert user if no errors
    if(empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert query
        $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
        
        if(mysqli_query($conn, $insert_query)) {
            $_SESSION['success'] = "Account created successfully! Please log in.";
            header("Location: signin.php");
            exit();
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
            header("Location: signup.php");
            exit();
        }
    } else {
        // Store errors in session
        $_SESSION['error'] = implode("<br>", $errors);
        header("Location: signup.php");
        exit();
    }
}
// Close connection
mysqli_close($conn);
?>