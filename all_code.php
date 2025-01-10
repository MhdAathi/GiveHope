<?php
ob_start();
session_start();
include('admin/config/dbcon.php'); // Ensure this path is correct

// Load Composer's autoload file for PHPMailer and Dompdf
require __DIR__ . '\vendor\autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dompdf\Dompdf;
use Dompdf\Options;

// Logout Functionality
if (isset($_POST['logout_btn'])) {
    unset($_SESSION['auth'], $_SESSION['auth_role'], $_SESSION['auth_user'], $_SESSION['user_id']);
    $_SESSION['message'] = "Logged Out Successfully";
    header("Location: login.php");
    exit();
}

// Donation Submission
if (isset($_POST['btn-submit'])) {
    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Sanitize and validate inputs
    $campaign_id = intval($_POST['campaign_id']);
    $donor_name = mysqli_real_escape_string($con, $_POST['name_on_card']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $address = mysqli_real_escape_string($con, $_POST['address_line']);
    $province = mysqli_real_escape_string($con, $_POST['province']);
    $district = mysqli_real_escape_string($con, $_POST['district']);
    $amount = floatval($_POST['amount']);
    $payment_type = mysqli_real_escape_string($con, $_POST['payment_type']);

    if ($payment_type === 'paypal') {
        $donor_name = mysqli_real_escape_string($con, $_POST['name']); // PayPal name field
    }

    // Check if campaign exists
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
        // Insert donation
        $insert_donation_query = "
            INSERT INTO donations 
            (campaign_id, donor_name, email, phone, address, province, district, amount, payment_type, donation_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ";
        $stmt = $con->prepare($insert_donation_query);
        $stmt->bind_param(
            "issssssds",
            $campaign_id,
            $donor_name,
            $email,
            $phone,
            $address,
            $province,
            $district,
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

        mysqli_commit($con);

        // Generate PDF Receipt
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);

        $html = "
        <!DOCTYPE html>
        <html>
        <head>
            <title>Donation Receipt</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f9f9f9;
                }
                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    background: #fff;
                    padding: 30px;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    text-align: left;
                }
                .header {
                    text-align: center;
                    border-bottom: 2px solid #1d3557;
                    padding-bottom: 20px;
                }
                .header h1 {
                    margin: 0;
                    font-size: 22px;
                    color: #1d3557;
                }
                .header p {
                    margin: 0;
                    font-size: 14px;
                    color: #555;
                }
                .details {
                    margin: 20px 0;
                    line-height: 1.6;
                }
                .details p {
                    margin: 5px 0;
                    font-size: 14px;
                    color: #333;
                }
                .details p span {
                    font-weight: bold;
                    color: #1d3557;
                }
                .amount {
                    background-color: #f1f1f1;
                    padding: 15px;
                    border-radius: 8px;
                    text-align: center;
                    font-size: 18px;
                    font-weight: bold;
                    color: #1d3557;
                    margin: 20px 0;
                }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                    font-size: 12px;
                    color: #999;
                }
                .footer a {
                    color: #1d3557;
                    text-decoration: none;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <!-- Header Section -->
                <div class='header'>
                    <h1>Donation Receipt</h1>
                    <p>Thank you for supporting our cause!</p>
                </div>

                <!-- Details Section -->
                <div class='details'>
                    <p><span>Donor Name:</span> $donor_name</p>
                    <p><span>Email:</span> $email</p>
                    <p><span>Phone:</span> $phone</p>
                    <p><span>Address:</span> $address</p>
                    <p><span>Province:</span> $province</p>
                    <p><span>District:</span> $district</p>
                    <p><span>Campaign:</span> $campaign_title</p>
                    <p><span>Date:</span> " . date('Y-m-d H:i:s') . "</p>
                </div>

                <!-- Amount Section -->
                <div class='amount'>
                    Donation Amount: LKR " . number_format($amount, 2) . "
                </div>

                <!-- Footer Section -->
                <div class='footer'>
                    <p>For any queries, contact us at <a href='mailto:support@campaignplatform.com'>support@campaignplatform.com</a></p>
                    <p>© 2025 Campaign Platform. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Save the PDF
        $pdfFilePath = __DIR__ . '/temp_receipt.pdf';
        file_put_contents($pdfFilePath, $dompdf->output());

        // Ensure the PDF exists
        if (!file_exists($pdfFilePath)) {
            throw new Exception("PDF generation failed. File not found.");
        }

        // Send Email with PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'aathief01@gmail.com'; // Replace with your email
            $mail->Password = 'fhkbwdzlzqipbhea'; // Replace with your app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('aathief01@gmail.com', 'Campaign Platform');
            $mail->addAddress($email, $donor_name);

            $mail->isHTML(true);
            $mail->Subject = 'Thank You for Your Donation!';
            $mail->Body = "
            <p>Dear $donor_name,</p>
            <p>Thank you for your generous donation of <strong>LKR " . number_format($amount, 2) . "</strong> to our campaign, <strong>\"$campaign_title\"</strong>.</p>
            <p>Here are the details of your donation:</p>
            <ul>
                <li><strong>Province:</strong> $province</li>
                <li><strong>District:</strong> $district</li>
                <li><strong>Date:</strong> " . date('Y-m-d H:i:s') . "</li>
            </ul>
            <p>Please find your donation receipt attached for your reference.</p>
            <p>With gratitude,<br>The Campaign Team</p>";

            // Attach the PDF
            $mail->addAttachment($pdfFilePath, 'Donation_Receipt.pdf');
            $mail->send();
        } catch (Exception $e) {
            error_log("Mailer Error: " . $mail->ErrorInfo);
            throw new Exception("Email failed to send: " . $e->getMessage());
        }

        // Cleanup PDF
        if (file_exists($pdfFilePath)) {
            unlink($pdfFilePath);
        }

        $_SESSION['message'] = "Thank you for your donation!";
        header("Location: donate.php?id=" . $campaign_id);
        exit();
    } catch (Exception $e) {
        mysqli_rollback($con);
        error_log($e->getMessage());
        if (file_exists($pdfFilePath)) {
            unlink($pdfFilePath);
        }
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
