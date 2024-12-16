<?php
ob_start();
session_start();
include('admin/config/dbcon.php'); // Ensure this path is correct

// Check if the user is logged in
if (!isset($_SESSION['auth_user'])) {
    $_SESSION['message'] = "You must log in first!";
    $_SESSION['message_type'] = "danger";
    header("Location: login.php");
    exit();
}

// Check if the user is an admin
if ($_SESSION['auth_role'] == 1) { // Role 1 = Admin
    header("Location: admin/index.php");
    exit();
}

// Check if the user has created a campaign
$user_id = $_SESSION['auth_user']['user_id'];
$query = "SELECT COUNT(*) AS campaign_count FROM campaigns WHERE user_id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['campaign_count'] > 0) {
    // User has created at least one campaign
    $_SESSION['message'] = "Welcome back! Accessing your campaign dashboard.";
    header("Location: admin/index.php");
    exit();
} else {
    // User has not created any campaigns
    $_SESSION['message'] = "You need to create a campaign first!";
    $_SESSION['message_type'] = "danger";
    header("Location: index.php");
    exit();
}
