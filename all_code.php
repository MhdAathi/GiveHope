<?php
session_start();
include('admin\config\dbcon.php'); // Include your database connection file

if (isset($_POST['logout_btn'])) {
    //session_destroy();
    unset($_SESSION['auth']);
    unset($_SESSION['auth_role']);
    unset($_SESSION['auth_user']);

    $_SESSION['message'] = "Logged Out Successfully";
    header("Location: login.php");
    exit(0);
}

if (isset($_POST['create_campaign_btn'])) {
    // Retrieve form data
    $campaign_title = $_POST['campaign_title'];
    $campaign_location = $_POST['campaign_location'];
    $campaign_description = $_POST['campaign_description'];
    $campaign_goal = $_POST['campaign_goal'];
    $campaign_category = $_POST['campaign_category'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $organizer_contact = $_POST['organizer_contact'];
    $organizer_email_address = $_POST['organizer_email_address'];

    // Handle file upload
    $campaign_image = $_FILES['campaign_image'];
    $image_name = time() . '_' . basename($campaign_image['name']);
    $target_dir = "uploads/"; // Ensure this directory exists and is writable
    $target_file = $target_dir . $image_name;

    // Validate and move uploaded file
    if (move_uploaded_file($campaign_image['tmp_name'], $target_file)) {
        // Prepare SQL statement
        $stmt = $con->prepare("INSERT INTO campaigns (title, location, description, goal, category, start_date, end_date, image, organizer_name, contact, email, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $organizer_name = $first_name . ' ' . $last_name;

        // Set default status as 'Pending' until admin approval
        $status = 'Pending';

        // Bind parameters
        $stmt->bind_param("ssssssssssss", $campaign_title, $campaign_location, $campaign_description, $campaign_goal, $campaign_category, $start_date, $end_date, $target_file, $organizer_name, $organizer_contact, $organizer_email_address, $status);

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['message'] = "Campaign created successfully! Waiting for admin approval.";
            header("Location: create_campaign.php"); // Redirect to the campaign creation page
        } else {
            $_SESSION['message'] = "Error creating campaign: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error uploading image.";
    }
}
