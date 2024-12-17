<?php
session_start();
if (isset($_SESSION['auth'])) {
    $_SESSION['message']  = 'You are already Logged In';
    header("Location: ../index.php");
    exit(0);
};
include('includes/header.php');
include('includes/navbar.php');
?>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap");

    body {
        background-color: #ecebf3;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: 'Montserrat', sans-serif;
    }

    .login-container {
        position: relative;
    }

    .login-card {
        width: 100%;
        max-width: 600px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        padding: 20px;
        background: #ffffff;
        -webkit-backdrop-filter: blur(15px);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.225);
        -webkit-box-shadow: 0 -1px 12.5px -1.5px #d5bfbf;
        -moz-box-shadow: 0 -1px 12.5px -1.5px #d5bfbf;
        box-shadow: 0 -1px 12.5px -1.5px #d5bfbf;
    }

    .card-header {
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 1px;
        text-align: center;
        margin-top: 20px;
        margin-bottom: 20px;
        color: #ffffff;
    }

    .card-header h4 {
        color: #1d3557;
        margin: 0;
        font-size: 1.6rem;
    }

    .span-color {
        color: #000;
    }

    .card-body {
        padding: 10px;
    }

    .form-group label {
        font-weight: bold;
        font-size: 16px;
        color: #000;
    }

    .form-group input {
        font-size: 16px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-top: 5px;
        width: 100%;
        background-color: #f0f0f0;
        color: #333;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 12px;
        cursor: pointer;
        font-size: 18px;
        color: #333;
    }

    .btn-block {
        display: block;
        margin: 0 auto;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        padding: 10px 16px;
        border-radius: 5px;
        width: 100%;
        cursor: pointer;
    }

    .btn-primary {
        background-color: transparent;
        color: #000;
        margin-bottom: 10px;
        transition: background-color 0.3s ease;
        border-color: #000;
    }

    .btn-primary:hover {
        background-color: #000;
        border-color: #fff;
    }

    .form-group a {
        text-decoration: none;
        font-size: 14px;
        color: #000;
        display: inline-block;
        margin-top: 10px;
    }

    .form-group a:hover {
        color: #921d1d;
    }

    ::placeholder {
        color: #888;
        font-weight: 300;
        letter-spacing: 0.5px;
        font-size: 13px;
    }

    input:focus::placeholder {
        color: #aaa;
        opacity: 0.7;
    }

    @media only screen and (max-width: 767px) {
        .login-card {
            padding: 15px;
        }

        .card-header h4 {
            font-size: 1.25rem;
        }

        .form-group input {
            font-size: 14px;
        }

        .btn-block {
            font-size: 14px;
        }
    }
</style>

<div class="login-container">
    <div class="login-card">
        <div class="card-header text-center">
            <h4>Login to <a class="navbar-brand" href="#"><span class="span-color">Give</span>Hope</a></h4>
        </div>
        <div class="card-body">
            <?php include('message.php'); ?>
            <form action="login_code.php" method="POST">
                <div class="form-group mb-3">
                    <label>Email ID</label>
                    <input type="email" name="email" required placeholder="Enter Email Address" class="form-control">
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" required placeholder="Enter Password" class="form-control">
                        <span id="toggle-password" class="password-toggle">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <small id="passwordHint" style="color: red;"></small>
                </div>

                <div class="form-group mb-3">
                    <a href="#" class="text-right">Forgot Password?</a>
                </div>

                <div class="form-group mb-3">
                    <button type="submit" name="login_btn" onclick="return validatePassword();" class="btn btn-primary btn-block">Login Now</button>
                </div>

                <div class="form-group text-center">
                    <span>Don't have an account? <a href="register.php">Sign up</a></span>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<script>
    // Password Toggle Visibility
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.type === 'password' ? 'text' : 'password';
        passwordInput.type = type;
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });

    // Password Validation Function with Dynamic Hints
    function validatePassword() {
        const password = document.getElementById("password").value;
        const passwordHint = document.getElementById("passwordHint");

        // Password complexity checks
        const minLength = /.{8,}/;
        const uppercase = /[A-Z]/;
        const lowercase = /[a-z]/;
        const number = /[0-9]/;
        const specialChar = /[!@#$%^&*(),.?":{}|<>_\-]/;

        if (!minLength.test(password)) {
            passwordHint.innerText = "Password must be at least 8 characters long.";
            return false;
        }
        if (!uppercase.test(password)) {
            passwordHint.innerText = "Password must contain at least one uppercase letter.";
            return false;
        }
        if (!lowercase.test(password)) {
            passwordHint.innerText = "Password must contain at least one lowercase letter.";
            return false;
        }
        if (!number.test(password)) {
            passwordHint.innerText = "Password must contain at least one number.";
            return false;
        }
        if (!specialChar.test(password)) {
            passwordHint.innerText = "Password must contain at least one special character (!@#$%^&*(),.?\":{}|<>_-).";
            return false;
        }

        // Clear hint if password is valid
        passwordHint.innerText = "";
        return true;
    }
</script>