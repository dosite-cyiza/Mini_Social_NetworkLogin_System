<?php
session_start();
// If user already logged in, redirect to dashboard
if(isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

$page_title = "Sign In - InstaSocial";
include 'includes/header.php';
?>

<div class="container">
    <div class="auth-box">
        <div class="logo">
            <h1>InstaSocial</h1>
        </div>
        
        <?php
        if(isset($_SESSION['success'])) {
            echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        if(isset($_SESSION['error'])) {
            echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>
        
        <form action="process_signin.php" method="POST" id="signinForm">
            <input type="text" name="username_email" placeholder="Username or Email" required>
            <input type="password" name="password" placeholder="Password" required>
            
            <button type="submit" class="btn-primary">Log In</button>
        </form>
        
        <div class="divider">
            <span>OR</span>
        </div>
        
        <!-- Google Login Button (Mocked) -->
        <button class="google-btn" onclick="googleLogin()">
            <img src="https://img.icons8.com/color/16/000000/google-logo.png" alt="Google">
            Log in with Google
        </button>
        
        <a href="#" class="forgot-password">Forgot password?</a>
    </div>
    
    <div class="auth-box">
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
</div>

<script src="js/validation.js"></script>

<?php include 'includes/footer.php'; ?>
