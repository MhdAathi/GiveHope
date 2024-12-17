<?php
session_start();
include('admin/config/dbcon.php');

if (isset($_POST['login_btn'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Query to check user credentials
    $login_query = "SELECT * FROM users WHERE email='$email' AND password='$password' LIMIT 1";
    $login_query_run = mysqli_query($con, $login_query);

    if (mysqli_num_rows($login_query_run) > 0) {
        // Fetch user data
        foreach ($login_query_run as $data) {
            $user_id = $data['id'];
            $user_name = $data['username'];
            $user_email = $data['email'];
            $role_as = $data['role_as'];
        }

        // Set session data
        session_regenerate_id(true);
        $_SESSION['auth'] = true;
        $_SESSION['auth_role'] = "$role_as"; // 1 = admin, 0 = user
        $_SESSION['auth_user'] = [
            'user_id' => $user_id,
            'user_name' => $user_name,
            'user_email' => $user_email,
        ];

        // Redirect based on user role
        if ($_SESSION['auth_role'] == 1) { // Admin
            $_SESSION['message'] = "Welcome to the admin dashboard";
            header("Location: admin/index.php");
            exit(0);
        } elseif ($_SESSION['auth_role'] == 0) { // User
            $_SESSION['message'] = "You are logged in as a user";
            header("Location: index.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Invalid role";
            header("Location: login.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Invalid Email or Password";
        header("Location: login.php");
        exit(0);
    }
} else {
    $_SESSION['message'] = "You are not allowed to access this file";
    header("Location: login.php");
    exit(0);
}
