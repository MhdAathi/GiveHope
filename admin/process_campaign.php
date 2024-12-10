<?php
include('authentication.php');
include('includes/header.php');
include('includes/navbar.php');

// Check if campaign ID is passed in the URL
if (isset($_GET['id'])) {
    $campaign_id = $_GET['id'];

    // Fetch campaign details from the database using the ID
    $query = "SELECT * FROM campaigns WHERE id = '$campaign_id'";
    $query_run = mysqli_query($con, $query);

    // If the campaign exists, fetch the details
    if ($query_run && mysqli_num_rows($query_run) > 0) {
        $campaign = mysqli_fetch_assoc($query_run);
    } else {
        $_SESSION['message'] = "Campaign not found!";
        header("Location: campaign_details.php"); // Redirect if campaign not found
        exit();
    }
} else {
    $_SESSION['message'] = "No campaign ID provided!";
    header("Location: campaign_details.php"); // Redirect if no ID is provided
    exit();
}
?>

<style>
    /* Container */
    .container {
        max-width: 600px;
        margin: 50px auto;
        padding: 20px;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        font-family: 'Arial', sans-serif;
    }

    /* Form Title */
    h2 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }

    /* Form Styles */
    .styled-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 10px;
    }

    label {
        font-size: 14px;
        font-weight: bold;
        color: #555;
        margin-bottom: 8px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"],
    select,
    textarea {
        font-size: 14px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        outline: none;
        background-color: #f9f9f9;
        transition: border 0.3s, background-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    input[type="file"]:focus,
    select:focus,
    textarea:focus {
        border: 1px solid #007bff;
        background-color: #ffffff;
    }

    /* Textarea Resizing */
    textarea {
        resize: none;
    }

    /* Button Styles */
    .btn-submit {
        font-size: 16px;
        font-weight: bold;
        color: #ffffff;
        background: linear-gradient(90deg, #007bff, #0056d1);
        padding: 12px;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        transition: background 0.3s, transform 0.3s;
    }

    .btn-submit:hover {
        background: linear-gradient(90deg, #0056d1, #003ba8);
        transform: scale(1.05);
    }

    /* Responsive Styles */
    @media (max-width: 768px) {
        .container {
            padding: 15px;
        }

        h2 {
            font-size: 20px;
        }
    }
</style>

<div class="container-fluid px-4">
    <h3 class="mt-4">Process Campaign</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">Process Campaign</li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <?php include('../message.php'); // Show any session messages ?>
            <div class="card">
                <div class="card-header">
                    <h4>Campaign Details</h4>
                </div>
                <div class="card-body">
                    <!-- Form to display and process the campaign details -->
                    <form action="admin_all_code.php" method="POST" enctype="multipart/form-data">
                        <!-- Hidden field to hold campaign ID -->
                        <input type="hidden" name="campaign_id" value="<?= $campaign['id']; ?>">

                        <div class="form-group">
                            <label for="campaign_title">Campaign Title</label>
                            <input type="text" class="form-control" id="campaign_title" name="campaign_title" value="<?= $campaign['title']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="campaign_location">Location</label>
                            <input type="text" class="form-control" id="campaign_location" name="campaign_location" value="<?= $campaign['location']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="campaign_description">Description</label>
                            <textarea class="form-control" id="campaign_description" name="campaign_description" required><?= $campaign['description']; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="campaign_goal">Goal</label>
                            <input type="number" class="form-control" id="campaign_goal" name="campaign_goal" value="<?= $campaign['goal']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="campaign_category">Category</label>
                            <input class="form-control" id="campaign_category" name="campaign_category" value="<?= $campaign['category']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $campaign['start_date']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $campaign['end_date']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= explode(' ', $campaign['organizer_name'])[0]; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= explode(' ', $campaign['organizer_name'])[1]; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="organizer_contact">Contact</label>
                            <input type="text" class="form-control" id="organizer_contact" name="organizer_contact" value="<?= $campaign['contact']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="organizer_email_address">Email</label>
                            <input type="email" class="form-control" id="organizer_email_address" name="organizer_email_address" value="<?= $campaign['email']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="campaign_image">Campaign Image</label>
                            <?php if (!empty($campaign['image'])): ?>
                                <?php
                                // Print the image path for debugging
                                echo '<p>Image Path: ' . htmlspecialchars($campaign['image']) . '</p>';
                                ?>
                                <!-- Display the current image -->
                                <div>
                                    <img src="/uploads/<?= htmlspecialchars($campaign['image']); ?>" alt="Campaign Image" style="max-width: 100%; max-height: 200px; object-fit: cover;">
                                </div>
                            <?php else: ?>
                                <p>No image available.</p>
                            <?php endif; ?>
                        </div>

                        <button type="submit" name="update_campaign_btn" class="btn btn-primary">Create Campaign</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>