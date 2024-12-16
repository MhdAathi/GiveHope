<?php
session_start();
include('config/dbcon.php');

// Correct autoload path
require __DIR__ . '/../vendor/autoload.php';

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Campaign Request Accept
if (isset($_POST['accept_btn'])) {
    $campaign_id = intval($_POST['campaign_id']);

    // Update campaign status to accepted
    $query = "UPDATE campaigns SET status = 'Accepted' WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $campaign_id);

    if ($stmt->execute()) {
        // Fetch campaign creator's email and name
        $creator_query = "SELECT organizer_name, email FROM campaigns WHERE id = ?";
        $creator_stmt = $con->prepare($creator_query);
        $creator_stmt->bind_param("i", $campaign_id);
        $creator_stmt->execute();
        $creator_result = $creator_stmt->get_result();

        if ($creator_result->num_rows > 0) {
            $creator = $creator_result->fetch_assoc();
            $organizer_name = $creator['organizer_name'];
            $email = $creator['email'];

            // Send acceptance email
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->SMTPAuth   = true;
                $mail->Host       = 'smtp.gmail.com';
                $mail->Username   = 'aathief01@gmail.com';   // Replace with your email
                $mail->Password   = 'fhkbwdzlzqipbhea';      // Replace with your app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('aathief01@gmail.com', 'Campaign Platform');
                $mail->addAddress($email, $organizer_name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Your Campaign Has Been Approved!';

                $mail->Body = "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Campaign Approved</title>
                </head>
                <body style='font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f9f9f9;'>

                    <table width='100%' cellspacing='0' cellpadding='0' style='background-color: #f9f9f9;'>
                        <tr>
                            <td align='center'>
                                <table width='600px' cellspacing='0' cellpadding='0' style='background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 20px;'>
                                    <!-- Header Section -->
                                    <tr>
                                        <td style='background-color: #1d3557; color: #ffffff; padding: 20px 30px; text-align: center; border-top-left-radius: 8px; border-top-right-radius: 8px;'>
                                            <h2 style='margin: 0; font-size: 24px;'>Campaign Platform</h2>
                                        </td>
                                    </tr>

                                    <!-- Body Section -->
                                    <tr>
                                        <td style='padding: 30px;'>
                                            <h3 style='color: #333333; font-size: 20px; margin-bottom: 15px;'>Dear $organizer_name,</h3>
                                            <p style='color: #555555; font-size: 16px; margin-bottom: 20px;'>
                                                We are excited to inform you that your campaign <strong>has been approved</strong> and is now live on our platform!
                                            </p>
                                            <p style='color: #555555; font-size: 16px; margin-bottom: 20px;'>
                                                You can now start receiving donations and manage your campaign to ensure its success.
                                            </p>

                                            <!-- CTA Button -->
                                            <p style='text-align: center; margin: 30px 0;'>
                                                <a href='https://your-platform-link.com/dashboard' style='background-color: #1d3557; color: #ffffff; padding: 10px 20px; border-radius: 5px; font-size: 16px; text-decoration: none;'>
                                                    Manage Your Campaign
                                                </a>
                                            </p>

                                            <!-- Additional Information -->
                                            <p style='color: #555555; font-size: 14px; margin-bottom: 15px;'>
                                                If you have any questions or need support, feel free to contact our team at
                                                <a href='mailto:support@yourplatform.com' style='color: #1d3557; text-decoration: none;'>support@yourplatform.com</a>.
                                            </p>
                                        </td>
                                    </tr>

                                    <!-- Footer Section -->
                                    <tr>
                                        <td style='background-color: #f1f1f1; color: #777777; text-align: center; padding: 20px 30px; font-size: 12px; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;'>
                                            <p style='margin: 0;'>Thank you for being part of our community!</p>
                                            <p style='margin: 5px 0;'>© 2024 GiveHope Campaign Platform. All rights reserved.</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>

                </body>
                </html>";
                $mail->send();
                $_SESSION['message'] = "Campaign accepted and email sent to the creator.";
            } catch (Exception $e) {
                $_SESSION['message'] = "Campaign accepted, but email failed to send: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['message'] = "Campaign accepted, but creator details could not be retrieved.";
        }
    } else {
        $_SESSION['message'] = "Failed to accept campaign!";
    }

    header("Location: campaigns.php");
    exit();
}

// Campaign Request Reject
if (isset($_POST['reject_btn'])) {
    $campaign_id = intval($_POST['campaign_id']);

    // Update campaign status to rejected
    $query = "UPDATE campaigns SET status = 'Rejected' WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $campaign_id);

    if ($stmt->execute()) {
        // Fetch campaign creator's email and name
        $creator_query = "SELECT organizer_name, email FROM campaigns WHERE id = ?";
        $creator_stmt = $con->prepare($creator_query);
        $creator_stmt->bind_param("i", $campaign_id);
        $creator_stmt->execute();
        $creator_result = $creator_stmt->get_result();

        if ($creator_result->num_rows > 0) {
            $creator = $creator_result->fetch_assoc();
            $organizer_name = $creator['organizer_name'];
            $email = $creator['email'];

            // Send rejection email
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->SMTPAuth   = true;
                $mail->Host       = 'smtp.gmail.com';
                $mail->Username   = 'aathief01@gmail.com';   // Replace with your email
                $mail->Password   = 'fhkbwdzlzqipbhea';      // Replace with your app password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                // Recipients
                $mail->setFrom('aathief01@gmail.com', 'Campaign Platform');
                $mail->addAddress($email, $organizer_name);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Campaign Rejection Notification';

                $mail->Body = "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Campaign Rejection</title>
                </head>
                <body style='font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 0; background-color: #f9f9f9;'>

                    <table width='100%' cellspacing='0' cellpadding='0' style='background-color: #f9f9f9;'>
                        <tr>
                            <td align='center'>
                                <table width='600px' cellspacing='0' cellpadding='0' style='background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); margin: 20px;'>
                                    <!-- Header Section -->
                                    <tr>
                                        <td style='background-color: #b71c1c; color: #ffffff; padding: 20px 30px; text-align: center; border-top-left-radius: 8px; border-top-right-radius: 8px;'>
                                            <h2 style='margin: 0; font-size: 24px;'>Campaign Platform</h2>
                                        </td>
                                    </tr>

                                    <!-- Body Section -->
                                    <tr>
                                        <td style='padding: 30px;'>
                                            <h3 style='color: #333333; font-size: 20px; margin-bottom: 15px;'>Dear $organizer_name,</h3>
                                            <p style='color: #555555; font-size: 16px; margin-bottom: 20px;'>
                                                We regret to inform you that your campaign request has been <strong>rejected</strong>.
                                            </p>
                                            <p style='color: #555555; font-size: 16px; margin-bottom: 20px;'>
                                                Unfortunately, your campaign did not meet the required criteria. Please review your campaign details and try resubmitting with the necessary adjustments.
                                            </p>

                                            <!-- Support Section -->
                                            <p style='color: #555555; font-size: 14px; margin-bottom: 20px;'>
                                                If you have any questions or need clarification, do not hesitate to contact us at
                                                <a href='mailto:support@yourplatform.com' style='color: #b71c1c; text-decoration: none;'>support@yourplatform.com</a>.
                                            </p>

                                            <!-- CTA Button -->
                                            <p style='text-align: center; margin: 30px 0;'>
                                                <a href='https://your-platform-link.com/contact' style='background-color: #b71c1c; color: #ffffff; padding: 10px 20px; border-radius: 5px; font-size: 16px; text-decoration: none;'>
                                                    Contact Support
                                                </a>
                                            </p>
                                        </td>
                                    </tr>

                                    <!-- Footer Section -->
                                    <tr>
                                        <td style='background-color: #f1f1f1; color: #777777; text-align: center; padding: 20px 30px; font-size: 12px; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;'>
                                            <p style='margin: 0;'>We appreciate your understanding and efforts.</p>
                                            <p style='margin: 5px 0;'>© 2024 Campaign Platform. All rights reserved.</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
                </html>";

                $mail->send();
                $_SESSION['message'] = "Campaign rejected and email sent to the creator.";
            } catch (Exception $e) {
                $_SESSION['message'] = "Campaign rejected, but email failed to send: {$mail->ErrorInfo}";
            }
        } else {
            $_SESSION['message'] = "Campaign rejected, but creator details could not be retrieved.";
        }
    } else {
        $_SESSION['message'] = "Failed to reject campaign!";
    }

    header("Location: campaigns.php");
    exit();
}

// Campaign Delete
if (isset($_GET['id'])) {
    $campaign_id = intval($_GET['id']);

    $query = "DELETE FROM campaigns WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $campaign_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Campaign deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete campaign.";
    }

    header("Location: campaigns.php");
    exit();
} else {
    $_SESSION['message'] = "Invalid campaign ID.";
    header("Location: campaigns.php");
    exit();
}

// Campaign Update
if (isset($_POST['update_campaign_btn'])) {
    // Retrieve form data
    $campaign_id = intval($_POST['campaign_id']);
    $campaign_title = mysqli_real_escape_string($con, $_POST['title']);
    $campaign_location = mysqli_real_escape_string($con, $_POST['location']);
    $campaign_description = mysqli_real_escape_string($con, $_POST['description']);
    $campaign_goal = floatval($_POST['goal']); // Ensure it's a float
    $campaign_category = mysqli_real_escape_string($con, $_POST['category']);

    // Handle image upload
    $campaign_image = $_FILES['image'];
    $target_dir = "uploads/"; // Ensure this directory exists and has proper write permissions
    $image_path = null;

    if (!empty($campaign_image['name'])) {
        $image_name = time() . '_' . basename($campaign_image['name']);
        $target_file = $target_dir . $image_name;

        if (!move_uploaded_file($campaign_image['tmp_name'], $target_file)) {
            $_SESSION['message'] = "Error uploading image.";
            header("Location: edit_campaign.php?id=" . $campaign_id);
            exit();
        }

        $image_path = $target_file; // Save the uploaded image path
    }

    // Prepare SQL statement based on image upload
    if ($image_path) {
        // Update with new image
        $query = "
UPDATE campaigns
SET title = ?, location = ?, description = ?, goal = ?, category = ?, image = ?
WHERE id = ?
";
        $stmt = $con->prepare($query);
        if (!$stmt) {
            $_SESSION['message'] = "Database error: " . $con->error;
            header("Location: edit_campaign.php?id=" . $campaign_id);
            exit();
        }
        $stmt->bind_param("ssssssi", $campaign_title, $campaign_location, $campaign_description, $campaign_goal, $campaign_category, $image_path, $campaign_id);
    } else {
        // Update without new image
        $query = "
UPDATE campaigns
SET title = ?, location = ?, description = ?, goal = ?, category = ?
WHERE id = ?
";
        $stmt = $con->prepare($query);
        if (!$stmt) {
            $_SESSION['message'] = "Database error: " . $con->error;
            header("Location: edit_campaign.php?id=" . $campaign_id);
            exit();
        }
        $stmt->bind_param("sssssi", $campaign_title, $campaign_location, $campaign_description, $campaign_goal, $campaign_category, $campaign_id);
    }

    // Execute the query
    if ($stmt->execute()) {
        $_SESSION['message'] = "Campaign updated successfully!";
    } else {
        $_SESSION['message'] = "Error updating campaign: " . $stmt->error;
    }

    $stmt->close();
    header("Location: campaigns.php");
    exit();
}

// Donor Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if donation_id is provided
    if (isset($_POST['donation_id']) && !empty($_POST['donation_id'])) {
        $donation_id = intval($_POST['donation_id']); // Ensure it's an integer

        // Prepare the delete query
        $query = "DELETE FROM donations WHERE id = ?";
        $stmt = $con->prepare($query);

        if ($stmt) {
            $stmt->bind_param("i", $donation_id); // Bind the ID
            if ($stmt->execute()) {
                $_SESSION['message'] = "Donation ID '$donation_id' deleted successfully.";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Failed to delete donation: " . $stmt->error;
                $_SESSION['message_type'] = "danger";
            }
        } else {
            $_SESSION['message'] = "Failed to prepare the SQL statement.";
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Donation ID not provided.";
        $_SESSION['message_type'] = "warning";
    }

    // Redirect back to donors page
    header("Location: donors.php");
    exit();
}
