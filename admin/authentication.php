<?php
ob_start();
session_start();
include('config/dbcon.php');

// Check if the user is authenticated
if (!isset($_SESSION['auth'])) 
{
    $_SESSION['message'] = "Login to Access Dashboard";
    header("Location: ../login.php");;
    exit(0);
}
