<?php
if ($_SESSION['auth_role'] != '1')
{
    $_SESSION['message'] = "You are Not Authorized as Admin";
    header("Location: donations_per_campaign.php");;
    exit(0);
}