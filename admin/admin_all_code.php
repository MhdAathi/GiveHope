<?php
include('config\dbcon.php');

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

if (isset($_POST['update_campaign_btn'])) {
    $campaign_id = $_POST['campaign_id'];
    $title = $_POST['title'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $goal = $_POST['goal'];
    $category = $_POST['category'];

    // Handle image upload
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
        $image_path = "uploads/" . $image;

        // Update with image
        $query = "UPDATE campaigns SET title = ?, location = ?, description = ?, goal = ?, category = ?, image = ? WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('ssssssi', $title, $location, $description, $goal, $category, $image_path, $campaign_id);
    } else {
        // Update without image
        $query = "UPDATE campaigns SET title = ?, location = ?, description = ?, goal = ?, category = ? WHERE id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param('sssssi', $title, $location, $description, $goal, $category, $campaign_id);
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = "Campaign updated successfully.";
    } else {
        $_SESSION['message'] = "Failed to update campaign.";
    }
    header("Location: campaign.php");
    exit();
}
