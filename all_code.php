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

if (isset($_POST['btn-submit'])) {
    // Retrieve and sanitize campaign_id
    $campaign_id = isset($_POST['campaign_id']) ? $_POST['campaign_id'] : null;  // Get campaign ID from POST request
    $campaign_id = intval(mysqli_real_escape_string($con, $campaign_id));  // Sanitize and ensure it's treated as an integer

    // Sanitize other form inputs
    $donor_name = mysqli_real_escape_string($con, $_POST['name_on_card']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address_line']);
    $amount = mysqli_real_escape_string($con, $_POST['amount']);
    $payment_type = mysqli_real_escape_string($con, $_POST['payment_type']);

    // Additional fields for credit card payment
    $card_number = $payment_type === 'credit_card' ? mysqli_real_escape_string($con, $_POST['card_number']) : null;
    $card_security_code = $payment_type === 'credit_card' ? mysqli_real_escape_string($con, $_POST['security_code']) : null;
    $card_expiration_month = $payment_type === 'credit_card' ? mysqli_real_escape_string($con, $_POST['expiration_month']) : null;
    $card_expiration_year = $payment_type === 'credit_card' ? mysqli_real_escape_string($con, $_POST['expiration_year']) : null;

    // Additional field for PayPal payment
    $paypal_email = $payment_type === 'paypal' ? mysqli_real_escape_string($con, $_POST['paypal_email']) : null;

    // Check if the campaign_id exists in the campaigns table
    $campaign_check_query = "SELECT id FROM campaigns WHERE id = $campaign_id LIMIT 1"; // No quotes around integer
    $campaign_result = mysqli_query($con, $campaign_check_query);

    if (mysqli_num_rows($campaign_result) == 0) {
        $_SESSION['message'] = "Campaign not found!";
        header('Location: donate.php');
        exit(0);
    }

    // Insert donation data into the database
    $query = "
        INSERT INTO donations (
            campaign_id, donor_name, email, phone, address, amount, payment_type, 
            card_number, card_security_code, card_expiration_month, card_expiration_year, 
            paypal_email, donation_date
        ) VALUES (
            '$campaign_id', '$donor_name', '$email', '$phone', '$address', '$amount', '$payment_type', 
            '$card_number', '$card_security_code', '$card_expiration_month', '$card_expiration_year', 
            '$paypal_email', NOW()
        )
    ";

    if (mysqli_query($con, $query)) {
        // Success message
        $_SESSION['message'] = "Thank you for your donation!";
        header('Location: donate.php'); // Redirect to donation page
        exit(0);
    } else {
        // Error message
        $_SESSION['message'] = "Failed to process donation: " . mysqli_error($con);
        header('Location: donate.php'); // Redirect to donation page
        exit(0);
    }
} else {
    // Invalid access
    $_SESSION['message'] = "Invalid request!";
    header('Location: donate.php');
    exit(0);
}
