<?php
session_start();
include('includes/navbar.php');
include('includes/header.php');
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

    .signup-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        opacity: 0.9;
    }

    .signup-card {
        width: 100%;
        max-width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        padding: 20px;
        background: #ffffff;
        /* Updated form color */
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
        color: #fff;
        /* White text for better contrast */
    }

    .card-header h4 {
        color: #1d3557;
        margin: 0;
        font-size: 1.6rem;
    }

    .span-color {
        color: #000;
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
        margin-top: 10px;
        display: block;
        text-align: center;
    }

    .form-group a:hover {
        color: #921d1d;
    }

    ::placeholder {
        color: #888;
        font-weight: 300;
        font-size: 13px;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        font-size: 18px;
        color: #666;
    }

    .password-toggle:hover {
        color: #000;
    }

    .password-requirements {
        background-color: #f9f9f9;
        border-left: 3px solid #1d3557;
        padding: 10px;
        margin-top: 10px;
        font-size: 13px;
        color: #555;
    }

    .password-requirements ul {
        margin: 0;
        padding-left: 20px;
    }
</style>

<div class="signup-card">
    <div class="card-header">
        <h4>Register to <span style="color: #1d3557;">GiveHope</span></h4>
    </div>
    <div class="card-body">
        <?php include('message.php'); ?>

        <form action="register_code.php" method="POST" onsubmit="return validatePassword()">
            <!-- Username -->
            <div class="form-group mt-3">
                <label>Username</label>
                <input required type="text" name="username" placeholder="Enter your username" class="form-control">
            </div>

            <!-- Email -->
            <div class="form-group mt-3">
                <label>Email Address</label>
                <input required type="email" name="email" placeholder="Enter your email" class="form-control">
            </div>

            <!-- Password -->
            <div class="form-group mt-3">
                <label>Password</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" required placeholder="Enter Password" class="form-control">
                    <span id="toggle-password" class="password-toggle"><i class="fas fa-eye"></i></span>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group mt-3">
                <label>Confirm Password</label>
                <div style="position: relative;">
                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirm Your Password" class="form-control">
                    <span id="toggle-confirm-password" class="password-toggle"><i class="fas fa-eye"></i></span>
                </div>
            </div>

            <!-- Password Requirements -->
            <div class="password-requirements">
                <ul>
                    <li>At least 8 characters</li>
                    <li>At least one uppercase letter</li>
                    <li>At least one number</li>
                    <li>At least one special character (!, @, #, $, etc.)</li>
                </ul>
            </div>

            <!-- Submit Button -->
            <button type="submit" name="register_btn" class="btn btn-primary btn-block mt-3">Register Now</button>
        </form>
    </div>
</div>

<script>
    // Toggle Password Visibility
    document.addEventListener("DOMContentLoaded", function() {
        const togglePassword = document.getElementById("toggle-password");
        const toggleConfirmPassword = document.getElementById("toggle-confirm-password");

        const passwordField = document.getElementById("password");
        const confirmPasswordField = document.getElementById("confirm_password");

        // For Password Field
        togglePassword.addEventListener("click", function() {
            if (passwordField.type === "password") {
                passwordField.type = "text";
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordField.type = "password";
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });

        // For Confirm Password Field
        toggleConfirmPassword.addEventListener("click", function() {
            if (confirmPasswordField.type === "password") {
                confirmPasswordField.type = "text";
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                confirmPasswordField.type = "password";
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    });

    // Password Validation
    function validatePassword() {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm_password").value;
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/;

        console.log("Password:", password);
        console.log("Regex Match:", regex.test(password));

        if (!regex.test(password)) {
            alert("Password must be at least 8 characters long, include one uppercase letter, one number, and one special character (!, @, #, $, etc.).");
            return false;
        }

        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }

        return true;
    }
</script>