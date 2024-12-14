<?php
ob_start();
session_start();
include('config\dbcon.php');

// Campaign Request Accept
if (isset($_POST['accept_btn'])) {
    $campaign_id = $_POST['campaign_id'];

    // Update campaign status to accepted
    $query = "UPDATE campaigns SET status = 'Accepted' WHERE id = '$campaign_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "Campaign accepted successfully!";
        header("Location: campaigns.php");  // Redirect to the campaigns list page
        exit(0);
    } else {
        $_SESSION['message'] = "Failed to accept campaign!";
        header("Location: campaigns.php");
        exit(0);
    }
}

// Campaign Request Reject
if (isset($_POST['reject_btn'])) {
    $campaign_id = $_POST['campaign_id'];

    // Update campaign status to rejected
    $query = "UPDATE campaigns SET status = 'Rejected' WHERE id = '$campaign_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['message'] = "Campaign rejected successfully!";
        header("Location: campaigns.php");  // Redirect to the campaigns list page
        exit(0);
    } else {
        $_SESSION['message'] = "Failed to reject campaign!";
        header("Location: campaigns.php");
        exit(0);
    }
}

// Campaign Delete
if (isset($_GET['id'])) {
    $campaign_id = $_GET['id'];

    $query = "DELETE FROM campaigns WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $campaign_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Campaign deleted successfully.";
        header("Location: campaigns.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Failed to delete campaign.";
        header("Location: campaigns.php");
        exit(0);
    }
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
