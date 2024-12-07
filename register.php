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
</style>

<div class="signup-container">
    <div class="signup-card">
        <div class="card-header text-center">
            <h4>Register to <a class="navbar-brand" href="#"><span class="span-color">Give</span>Hope</a></h4>
        </div>
        <div class="card-body">
            <?php include('message.php'); ?>

            <form action="register_code.php" method="POST">
                <!-- Username -->
                <div class="form-group mb-3">
                    <label>Username</label>
                    <input required type="text" name="username" placeholder="Enter your username" class="form-control">
                </div>

                <!-- Email -->
                <div class="form-group mb-3">
                    <label>Email Address</label>
                    <input required type="email" name="email" placeholder="Enter your email" class="form-control">
                </div>

                <!-- Password -->
                <div class="form-group mb-3">
                    <label>Password</label>
                    <input required type="password" name="password" placeholder="Enter your password" class="form-control">
                </div>

                <!-- Confirm Password -->
                <div class="form-group mb-3">
                    <label>Confirm Password</label>
                    <input required type="password" name="confirm_password" placeholder="Confirm your password" class="form-control">
                </div>

                <!-- Submit Button -->
                <button type="submit" name="register_btn" class="btn btn-primary btn-block">Register Now</button>
            </form>
        </div>
    </div>
</div>