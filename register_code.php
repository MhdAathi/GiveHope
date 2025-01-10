<?php
session_start();
include('admin/config/dbcon.php');

// Check if the register button is clicked
if (isset($_POST['register_btn'])) {
    // Securely fetch input values to prevent SQL injection
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    // Check if the password matches the confirmation password
    if ($password == $confirm_password) {
        // Check if the email already exists in the database
        $checkemail = "SELECT email FROM users WHERE email='$email' ";
        $checkemail_run = mysqli_query($con, $checkemail);

        if (mysqli_num_rows($checkemail_run) > 0) {
            // Set session message if the email already exists
            $_SESSION['message'] = "Already Email Exists";
            header("Location: register.php");
            exit(0);
        } else {
            // Insert the new user data into the database
            $user_query = "INSERT INTO users (username,email,password) VALUES 
            ('$username' , '$email' , '$password')";
            $user_query_run = mysqli_query($con, $user_query);

            if ($user_query_run) {
                // Redirect to login with success message after registration
                $_SESSION['message'] = "Registered Successfully";
                header("Location: login.php");
                exit(0);
            } else {
                // Set session message if insertion fails
                $_SESSION['message'] = "Something Went Wrong";
                header("Location: register.php");
                exit(0);
            }
        }
    } else {
        // Set session message if passwords do not match
        $_SESSION['message'] = "Password and Confirm Password do not Match";
        header("Location: register.php");
        exit(0);
    }
} else {
    // Redirect to register page if accessed without form submission
    header("Location: register.php");
    exit(0);
}
?>
