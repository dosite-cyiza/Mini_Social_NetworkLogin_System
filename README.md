# Mini_Social_NetworkLogin_System
### Mini Social Network - InstaSocial

## Platform
Instagram-inspired login system with post management (CRUD)

## Features Implemented
User Registration with full validation
User Login with username/email
Mock Google Login (simulated)
Post CRUD (Create, Read, Update, Delete)
Session management
Instagram-style responsive design
Error and success messages
Password hashing for security
SQL injection prevention

## Technologies Used
- PHP
- MySQL Database
- HTML5/CSS3
- JavaScript (Vanilla)
- Bootstrap Icons (optional)

## Project Structure
mini-social-network/
│
├── config/
│   └── database.php           (Database connection)
│
├── includes/
│   ├── header.php             (HTML header)
│   └── footer.php             (HTML footer)
│
├── css/
│   └── style.css              (All styles)
│
├── js/
│   └── validation.js          (Form validation)
│
├── images/                    (images folder)
│
├── signup.php                 (Registration page)
├── signin.php                 (Login page)
├── dashboard.php              (CRUD page)
├── logout.php                 (Logout)
├── process_signup.php         (Sign up processing)
├── process_signin.php         (Signin processing)