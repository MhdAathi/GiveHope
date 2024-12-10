<?php

if ($_SESSION['auth_role'] != 'Admin')
{
    $_SESSION['message'] = "You are Not Authorized as Admin";
    header("Location: index.php");;
    exit(0);
}