<?php
ob_start();
session_start();
include('admin/config/dbcon.php'); // Ensure this path is correct

// Logout Functionality
if (isset($_POST['logout_btn'])) {
    // Clear session data
    unset($_SESSION['auth'], $_SESSION['auth_role'], $_SESSION['auth_user']);

    $_SESSION['message'] = "Logged Out Successfully";
    header("Location: login.php");
    exit();
}

// Campaign Creation
if (isset($_POST['create_campaign_btn'])) {
    // Retrieve form data
    $campaign_title = mysqli_real_escape_string($con, $_POST['campaign_title']);
    $campaign_location = mysqli_real_escape_string($con, $_POST['campaign_location']);
    $campaign_description = mysqli_real_escape_string($con, $_POST['campaign_description']);
    $campaign_goal = floatval($_POST['campaign_goal']); // Ensure it's a float
    $campaign_category = mysqli_real_escape_string($con, $_POST['campaign_category']);
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($con, $_POST['end_date']);
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $organizer_contact = mysqli_real_escape_string($con, $_POST['organizer_contact']);
    $organizer_email_address = mysqli_real_escape_string($con, $_POST['organizer_email_address']);

    // Handle image upload
    $campaign_image = $_FILES['campaign_image'];
    $image_name = time() . '_' . basename($campaign_image['name']);
    $target_dir = "uploads/"; // Ensure this directory exists and has proper write permissions
    $target_file = $target_dir . $image_name;

    if (!move_uploaded_file($campaign_image['tmp_name'], $target_file)) {
        $_SESSION['message'] = "Error uploading image.";
        header("Location: create_campaign.php");
        exit();
    }

    // Handle supporting document upload
    $campaign_document = $_FILES['campaign_document'];
    $document_name = time() . '_doc_' . basename($campaign_document['name']);
    $document_target_file = $target_dir . $document_name;

    if (!move_uploaded_file($campaign_document['tmp_name'], $document_target_file)) {
        $_SESSION['message'] = "Error uploading supporting document.";
        header("Location: create_campaign.php");
        exit();
    }

    // Prepare SQL statement
    $organizer_name = $first_name . ' ' . $last_name;
    $status = 'Pending'; // Default status
    $stmt = $con->prepare("
        INSERT INTO campaigns 
        (title, location, description, goal, category, start_date, end_date, image, document, organizer_name, contact, email, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    if (!$stmt) {
        $_SESSION['message'] = "Database error: " . $con->error;
        header("Location: create_campaign.php");
        exit();
    }

    // Bind and execute
    $stmt->bind_param(
        "sssssssssssss",
        $campaign_title,
        $campaign_location,
        $campaign_description,
        $campaign_goal,
        $campaign_category,
        $start_date,
        $end_date,
        $target_file,
        $document_target_file,
        $organizer_name,
        $organizer_contact,
        $organizer_email_address,
        $status
    );

    if ($stmt->execute()) {
        $_SESSION['message'] = "Campaign created successfully! Waiting for admin approval.";
    } else {
        $_SESSION['message'] = "Error creating campaign: " . $stmt->error;
    }

    $stmt->close();
    header("Location: create_campaign.php");
    exit();
}

// Donation Submission
if (isset($_POST['btn-submit'])) {
    $campaign_id = intval($_POST['campaign_id']); // Ensure it's treated as an integer
    $donor_name = mysqli_real_escape_string($con, $_POST['name_on_card']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address_line']);
    $amount = floatval($_POST['amount']); // Convert to a float for safety
    $payment_type = mysqli_real_escape_string($con, $_POST['payment_type']);

    // Additional fields for credit card payment
    $card_number = $payment_type === 'credit_card' ? mysqli_real_escape_string($con, $_POST['card_number']) : null;
    $card_security_code = $payment_type === 'credit_card' ? mysqli_real_escape_string($con, $_POST['security_code']) : null;
    $card_expiration_month = $payment_type === 'credit_card' ? mysqli_real_escape_string($con, $_POST['expiration_month']) : null;
    $card_expiration_year = $payment_type === 'credit_card' ? mysqli_real_escape_string($con, $_POST['expiration_year']) : null;

    // Additional field for PayPal payment
    $paypal_email = $payment_type === 'paypal' ? mysqli_real_escape_string($con, $_POST['paypal_email']) : null;

    // Verify campaign existence
    $campaign_check_query = "SELECT id FROM campaigns WHERE id = ? LIMIT 1";
    $stmt = $con->prepare($campaign_check_query);
    $stmt->bind_param("i", $campaign_id);
    $stmt->execute();
    $campaign_result = $stmt->get_result();
    $stmt->close();

    if ($campaign_result->num_rows == 0) {
        $_SESSION['message'] = "Campaign not found!";
        header("Location: donate.php");
        exit();
    }

    // Start a transaction
    mysqli_begin_transaction($con);

    try {
        // Insert donation
        $insert_donation_query = "
            INSERT INTO donations 
            (campaign_id, donor_name, email, phone, address, amount, payment_type, card_number, card_security_code, card_expiration_month, card_expiration_year, paypal_email, donation_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ";
        $stmt = $con->prepare($insert_donation_query);
        $stmt->bind_param(
            "issssdssssss",
            $campaign_id,
            $donor_name,
            $email,
            $phone,
            $address,
            $amount,
            $payment_type,
            $card_number,
            $card_security_code,
            $card_expiration_month,
            $card_expiration_year,
            $paypal_email
        );
        if (!$stmt->execute()) {
            throw new Exception("Failed to insert donation: " . $stmt->error);
        }
        $stmt->close();

        // Update campaign raised amount
        $update_campaign_query = "UPDATE campaigns SET raised = raised + ? WHERE id = ?";
        $stmt = $con->prepare($update_campaign_query);
        $stmt->bind_param("di", $amount, $campaign_id);
        if (!$stmt->execute()) {
            throw new Exception("Failed to update campaign raised amount: " . $stmt->error);
        }
        $stmt->close();

        // Commit the transaction
        mysqli_commit($con);
        $_SESSION['message'] = "Thank you for your donation!";
    } catch (Exception $e) {
        mysqli_rollback($con);
        $_SESSION['message'] = "Error: " . $e->getMessage();
    }

    header("Location: donate.php");
    exit(0);
}
