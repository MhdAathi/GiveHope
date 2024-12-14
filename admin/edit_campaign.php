<?php
include('authentication.php');
include('includes/header.php');
include('includes/navbar.php');

// Fetch campaign data to populate the form
if (isset($_GET['id'])) {
    $campaign_id = $_GET['id'];
    $query = "SELECT * FROM campaigns WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $campaign_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $campaign = $result->fetch_assoc();

    if (!$campaign) {
        $_SESSION['message'] = "Campaign not found.";
        header("Location: campaigns.php");
        exit();
    }
} else {
    $_SESSION['message'] = "No campaign ID provided.";
    header("Location: campaigns.php");
    exit();
}
?>

<style>
    .form-container {
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 30px;
        max-width: 800px;
        margin: auto;
    }

    .form-container h3 {
        font-size: 1.8rem;
        font-weight: bold;
        color: #343a40;
        margin-bottom: 20px;
        text-align: center;
    }

    .form-group label {
        font-weight: 500;
        color: #495057;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 10px;
        font-size: 1rem;
        transition: all 0.3s ease-in-out;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        font-size: 1rem;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 5px;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .current-image {
        margin-top: 15px;
        border: 1px solid #ced4da;
        border-radius: 5px;
        padding: 10px;
        text-align: center;
        background-color: #f8f9fa;
    }

    .current-image img {
        max-width: 25%;
        height: auto;
        border-radius: 5px;
    }

    .back-btn {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
        margin-bottom: 20px;
        transition: color 0.3s ease-in-out;
    }

    .back-btn i {
        font-size: 1.2rem;
    }

    .back-btn:hover {
        color: #0056b3;
        text-decoration: underline;
    }
</style>

<div class="container mt-5">
    <div class="form-container">
        <!-- Show session messages -->
        <?php include('../message.php'); ?>
        <a href="campaigns.php" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Campaign Details
        </a>
        <h3>Edit Campaign</h3>
        <form action="admin_all_code.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="campaign_id" value="<?= $campaign['id']; ?>">

            <div class="form-group mb-4">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($campaign['title']); ?>" required>
            </div>

            <div class="form-group mb-4">
                <label for="location">Location</label>
                <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($campaign['location']); ?>" required>
            </div>

            <div class="form-group mb-4">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($campaign['description']); ?></textarea>
            </div>

            <div class="form-group mb-4">
                <label for="goal">Goal (in LKR)</label>
                <input type="number" name="goal" class="form-control" value="<?= htmlspecialchars($campaign['goal']); ?>" required>
            </div>

            <div class="form-group mb-4">
                <label for="category">Category</label>
                <select name="category" class="form-control" required>
                    <option value="Education" <?= $campaign['category'] == 'Education' ? 'selected' : ''; ?>>Education</option>
                    <option value="Health" <?= $campaign['category'] == 'Health' ? 'selected' : ''; ?>>Health</option>
                    <option value="Environment" <?= $campaign['category'] == 'Environment' ? 'selected' : ''; ?>>Environment</option>
                    <option value="Charity" <?= $campaign['category'] == 'Charity' ? 'selected' : ''; ?>>Charity</option>
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="image">Upload New Image (Optional)</label>
                <input type="file" name="image" class="form-control">
                <?php if (!empty($campaign['image']) && file_exists($campaign['image'])): ?>
                    <div class="current-image">
                        <p>Current Image:</p>
                        <img src="<?= htmlspecialchars($campaign['image']); ?>" alt="<?= htmlspecialchars($campaign['title']); ?>" class="campaign-image">
                    </div>
                <?php else: ?>
                    <div class="current-image">
                        <p>No image uploaded for this campaign.</p>
                    </div>
                <?php endif; ?>

            </div>

            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" name="update_campaign_btn" class="btn btn-primary">Update Campaign</button>
            </div>
        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>