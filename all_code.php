<?php
ob_start();
session_start();
include('admin/config/dbcon.php'); // Ensure this path is correct

// Load Composer's autoload file for PHPMailer
require __DIR__ . '\vendor\autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Logout Functionality
if (isset($_POST['logout_btn'])) {
    // Clear session data
    unset($_SESSION['auth'], $_SESSION['auth_role'], $_SESSION['auth_user'], $_SESSION['user_id']);

    $_SESSION['message'] = "Logged Out Successfully";
    header("Location: login.php");
    exit();
}

// Donation Submission
if (isset($_POST['btn-submit'])) {
    // Ensure database connection
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Sanitize and validate inputs
    $campaign_id = intval($_POST['campaign_id']);
    $donor_name = mysqli_real_escape_string($con, $_POST['name_on_card']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address_line']);
    $amount = floatval($_POST['amount']);
    $payment_type = mysqli_real_escape_string($con, $_POST['payment_type']);

    // Determine donor_name based on payment type
    if ($payment_type === 'paypal') {
        $donor_name = mysqli_real_escape_string($con, $_POST['name']); // PayPal name field
    } else {
        $donor_name = mysqli_real_escape_string($con, $_POST['name_on_card']); // Credit Card name field
    }

    // Check if campaign exists and is active
    $stmt = $con->prepare("SELECT id, title FROM campaigns WHERE id = ? AND status = 'Accepted'");
    $stmt->bind_param("i", $campaign_id);
    $stmt->execute();
    $campaign_result = $stmt->get_result();
    $stmt->close();

    if ($campaign_result->num_rows === 0) {
        $_SESSION['message'] = "Campaign not found or unavailable!";
        header("Location: donate.php?id=" . $campaign_id);
        exit();
    }
    $campaign = $campaign_result->fetch_assoc();
    $campaign_title = $campaign['title'];

    // Start database transaction
    mysqli_begin_transaction($con);

    try {
        // Insert donation into 'donations' table
        $insert_donation_query = "
            INSERT INTO donations 
            (campaign_id, donor_name, email, phone, address, amount, payment_type, donation_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ";
        $stmt = $con->prepare($insert_donation_query);
        $stmt->bind_param(
            "issssds",
            $campaign_id,
            $donor_name,
            $email,
            $phone,
            $address,
            $amount,
            $payment_type
        );

        if (!$stmt->execute()) {
            throw new Exception("Error inserting donation: " . $stmt->error);
        }
        $stmt->close();

        // Update campaign 'raised' amount
        $update_campaign_query = "UPDATE campaigns SET raised = raised + ? WHERE id = ?";
        $stmt = $con->prepare($update_campaign_query);
        $stmt->bind_param("di", $amount, $campaign_id);

        if (!$stmt->execute()) {
            throw new Exception("Error updating campaign raised amount: " . $stmt->error);
        }
        $stmt->close();

        // Commit the transaction
        mysqli_commit($con);

        // Send email to donor
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->SMTPAuth   = true;
            $mail->Host       = 'smtp.gmail.com';
            $mail->Username   = 'aathief01@gmail.com'; // Replace with your email
            $mail->Password   = 'fhkbwdzlzqipbhea'; // Replace with your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('aathief01@gmail.com', 'Campaign Platform');
            $mail->addAddress($email, $donor_name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Thank You for Your Donation!';
            $mail->Body    = "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Donation Confirmation</title>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f4f4f4; }
                    .email-container { max-width: 600px; margin: 20px auto; background: #ffffff; border-radius: 8px; overflow: hidden; }
                    .header { background-color: #1d3557; color: #ffffff; text-align: center; padding: 20px; }
                    .content { padding: 20px; color: #333333; }
                    .footer { background-color: #f1f1f1; text-align: center; padding: 10px; color: #777777; font-size: 12px; }
                    .button { display: inline-block; background-color: #1d3557; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <!-- Header -->
                    <div class='header'>
                        <h2>Thank You, $donor_name!</h2>
                    </div>

                    <!-- Content -->
                    <div class='content'>
                        <p>We sincerely appreciate your generous donation to the campaign:</p>
                        <h3 style='color: #1d3557;'>\"$campaign_title\"</h3>
                        <p><strong>Donation Amount:</strong> LKR " . number_format($amount, 2) . "</p>
                        <p>Your support plays a vital role in helping us achieve our goals and create a positive impact.</p>
                        <p>Thank you for making a difference!</p>
                        <p style='text-align: center; margin-top: 30px;'>
                            <a href='https://your-platform-link.com/campaigns' class='button'>View More Campaigns</a>
                        </p>
                    </div>

                    <!-- Footer -->
                    <div class='footer'>
                        <p>© 2024 Campaign Platform. All rights reserved.</p>
                        <p>Contact us: support@campaignplatform.com</p>
                    </div>
                </div>
            </body>
            </html>
            ";

            $mail->send();
        } catch (Exception $e) {
            $_SESSION['message'] .= " Email failed to send: {$mail->ErrorInfo}";
        }

        // Success message
        $_SESSION['message'] = "Thank you for your donation!";
        header("Location: donate.php?id=" . $campaign_id);
        exit();
    } catch (Exception $e) {
        // Rollback on error
        mysqli_rollback($con);
        error_log($e->getMessage());

        // Show error to the user
        $_SESSION['message'] = "Something went wrong: " . $e->getMessage();
        header("Location: donate.php?id=" . $campaign_id);
        exit();
    }
}

// Campaign Creation
if (isset($_POST['create_campaign_btn'])) {
    // Retrieve logged-in user's ID
    $user_id = $_SESSION['auth_user']['user_id'];

    // Retrieve and sanitize form data
    $campaign_title = mysqli_real_escape_string($con, $_POST['campaign_title']);
    $campaign_location = mysqli_real_escape_string($con, $_POST['campaign_location']);
    $campaign_description = mysqli_real_escape_string($con, $_POST['campaign_description']);
    $campaign_goal = floatval($_POST['campaign_goal']);
    $campaign_category = mysqli_real_escape_string($con, $_POST['campaign_category']);
    $start_date = mysqli_real_escape_string($con, $_POST['start_date']);
    $end_date = mysqli_real_escape_string($con, $_POST['end_date']);
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $organizer_contact = mysqli_real_escape_string($con, $_POST['organizer_contact']);
    $organizer_email_address = mysqli_real_escape_string($con, $_POST['organizer_email_address']);

    // Validate required fields
    if (
        empty($campaign_title) || empty($campaign_location) || empty($campaign_description) ||
        empty($campaign_goal) || empty($campaign_category) || empty($start_date) || empty($end_date)
    ) {
        $_SESSION['message'] = "All fields are required!";
        header("Location: create_campaign.php");
        exit();
    }

    // File upload directory
    $target_dir = __DIR__ . '../uploads/'; // Save files outside admin folder
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // Create directory if it doesn't exist
    }

    // Allowed file types
    $allowed_image_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $allowed_document_types = array_merge($allowed_image_types, ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document']);
    $max_file_size = 10 * 1024 * 1024; // 10 MB

    // Handle campaign image upload
    $campaign_image = $_FILES['campaign_image'];
    $image_name = time() . '_' . preg_replace("/[^a-zA-Z0-9.]/", "", basename($campaign_image['name']));
    $target_file = $target_dir . $image_name;
    $image_path = '../uploads/' . $image_name; // Relative path for display

    if (!in_array($campaign_image['type'], $allowed_image_types) || $campaign_image['size'] > $max_file_size) {
        $_SESSION['message'] = "Invalid image type or size. Only JPG, PNG under 10MB allowed.";
        header("Location: create_campaign.php");
        exit();
    }
    if (!move_uploaded_file($campaign_image['tmp_name'], $target_file)) {
        $_SESSION['message'] = "Error uploading campaign image.";
        header("Location: create_campaign.php");
        exit();
    }

    // Handle campaign document upload
    $campaign_document = $_FILES['campaign_document'];
    $document_name = time() . '_doc_' . preg_replace("/[^a-zA-Z0-9.]/", "", basename($campaign_document['name']));
    $document_target_file = $target_dir . $document_name;
    $document_path = '../uploads/' . $document_name; // Relative path for display

    if (!in_array($campaign_document['type'], $allowed_document_types) || $campaign_document['size'] > $max_file_size) {
        $_SESSION['message'] = "Invalid document type or size. Only JPG, PNG, PDF, DOC, DOCX under 10MB allowed.";
        header("Location: create_campaign.php");
        exit();
    }
    if (!move_uploaded_file($campaign_document['tmp_name'], $document_target_file)) {
        $_SESSION['message'] = "Error uploading campaign document.";
        header("Location: create_campaign.php");
        exit();
    }

    // Save to database
    $stmt = $con->prepare("
    INSERT INTO campaigns 
    (user_id, title, location, description, goal, category, start_date, end_date, image, document, organizer_name, contact, email, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");

    $status = 'Pending';
    $organizer_name = $first_name . ' ' . $last_name;

    $stmt->bind_param(
        "isssssssssssss",
        $user_id,
        $campaign_title,
        $campaign_location,
        $campaign_description,
        $campaign_goal,
        $campaign_category,
        $start_date,
        $end_date,
        $image_path,      // Relative path
        $document_path,   // Relative path
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

if (isset($_POST['btn-feedback'])) {
    // Sanitize and retrieve the inputs
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $feedback = mysqli_real_escape_string($con, $_POST['feedback']);

    // Insert feedback into the database
    $query = "INSERT INTO feedback (name, email, feedback) VALUES ('$name', '$email', '$feedback')";
    $query_run = mysqli_query($con, $query);

    // Check if the query executed successfully
    if ($query_run) {
        // Success message
        $_SESSION['message'] = "Thank you for your feedback!";
        header("Location: index.php"); // Redirect to homepage or feedback page
        exit(0);
    } else {
        // Error message
        $_SESSION['message'] = "There was an error submitting your feedback. Please try again.";
        header("Location: index.php"); // Redirect to homepage or feedback page
        exit(0);
    }
}
