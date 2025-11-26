// Mock Google Login
function googleLogin() {
    // Show alert that it's a simulation
    alert('Google Login Simulation - You will be logged in automatically!');
    
    // Redirect to Google login processing page
    window.location.href = 'process_google_login.php';
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const signupForm = document.getElementById('signupForm');
    
    if(signupForm) {
        signupForm.addEventListener('submit', function(e) {
            const email = document.querySelector('input[name="email"]').value;
            const username = document.querySelector('input[name="username"]').value;
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            
            // Check if fields are empty
            if(!email || !username || !password || !confirmPassword) {
                e.preventDefault();
                alert('All fields are required');
                return false;
            }
            
            // Check email format
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(!emailPattern.test(email)) {
                e.preventDefault();
                alert('Please enter a valid email address');
                return false;
            }
            
            // Check username length
            if(username.length < 3) {
                e.preventDefault();
                alert('Username must be at least 3 characters long');
                return false;
            }
            
            // Check password length
            if(password.length < 6) {
                e.preventDefault();
                alert('Password must be at least 6 characters long');
                return false;
            }
            
            // Check if passwords match
            if(password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match');
                return false;
            }
        });
    }
    
    // Sign in form validation
    const signinForm = document.getElementById('signinForm');
    
    if(signinForm) {
        signinForm.addEventListener('submit', function(e) {
            const usernameEmail = document.querySelector('input[name="username_email"]').value;
            const password = document.querySelector('input[name="password"]').value;
            
            if(!usernameEmail || !password) {
                e.preventDefault();
                alert('All fields are required');
                return false;
            }
        });
    }
});