<?php
session_start();
if(isset($_SESSION['user_id'])){
    header("location:dashboard.php");
    exit;
}

$page_title = "Signup - IstaSocial";
include "includes/header.php";

?>
<div class="container">
    <div class="auth-box">
        <div class="logo">
            <h1>InstaSocial</h1>
        </div>
        
        <h2>Sign up to see photos and videos from your friends.</h2>
        
        <!-- Google Login Button (Mocked) -->
        <button class="google-btn" onclick="googleLogin()">
            <img src="https://img.icons8.com/color/16/000000/google-logo.png" alt="Google">
            Log in with Google
        </button>
        
        <div class="divider">
            <span>OR</span>
        </div>
        
        <?php
        if(isset($_SESSION['error'])) {
            echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>
        
        <form action="process_signup.php" method="POST" id="signupForm">
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            
            <button type="submit" class="btn-primary">Sign Up</button>
        </form>
        
        <p class="terms">
            By signing up, you agree to our Terms, Data Policy and Cookies Policy.
        </p>
    </div>
    
    <div class="auth-box">
        <p>Have an account? <a href="signin.php">Log in</a></p>
    </div>
</div>

<script src="js/validation.js"></script>

<?php include 'includes/footer.php'; ?>