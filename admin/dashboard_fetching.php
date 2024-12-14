<?php
// Fetch total campaigns
$query_campaigns = "SELECT COUNT(*) AS total FROM campaigns";
$result_campaigns = mysqli_query($con, $query_campaigns);
$total_campaigns = mysqli_fetch_assoc($result_campaigns)['total'];

// Fetch total donors
$query_donors = "SELECT COUNT(DISTINCT donor_name) AS total FROM donations";
$result_donors = mysqli_query($con, $query_donors);
$total_donors = mysqli_fetch_assoc($result_donors)['total'];

// Fetch total donations
$query_donations = "SELECT COUNT(*) AS total FROM donations";
$result_donations = mysqli_query($con, $query_donations);
$total_donations = mysqli_fetch_assoc($result_donations)['total'];

// Fetch total raised money
$query_raised = "SELECT SUM(raised) AS total FROM campaigns";
$result_raised = mysqli_query($con, $query_raised);
$total_raised = mysqli_fetch_assoc($result_raised)['total'];

// Fetch total users
$query_users = "SELECT COUNT(*) AS total FROM users";
$result_users = mysqli_query($con, $query_users);
$total_users = mysqli_fetch_assoc($result_users)['total'];
