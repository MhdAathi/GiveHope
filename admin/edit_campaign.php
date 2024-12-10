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
        header("Location: campaign_details.php");
        exit();
    }
} else {
    $_SESSION['message'] = "No campaign ID provided.";
    header("Location: campaign_details.php");
    exit();
}
?>

<div class="container">
    <h3 class="mt-4">Edit Campaign</h3>
    <form action="admin_all_code.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="campaign_id" value="<?= $campaign['id']; ?>">

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($campaign['title']); ?>" required>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($campaign['location']); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($campaign['description']); ?></textarea>
        </div>

        <div class="form-group">
            <label for="goal">Goal</label>
            <input type="number" name="goal" class="form-control" value="<?= htmlspecialchars($campaign['goal']); ?>" required>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <select name="category" class="form-control" required>
                <option value="Education" <?= $campaign['category'] == 'Education' ? 'selected' : ''; ?>>Education</option>
                <option value="Health" <?= $campaign['category'] == 'Health' ? 'selected' : ''; ?>>Health</option>
                <option value="Environment" <?= $campaign['category'] == 'Environment' ? 'selected' : ''; ?>>Environment</option>
                <option value="Charity" <?= $campaign['category'] == 'Charity' ? 'selected' : ''; ?>>Charity</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
            <?php if (!empty($campaign['image'])): ?>
                <p>Current Image:</p>
                <img src="<?= htmlspecialchars($campaign['image']); ?>" alt="Campaign Image" style="max-width: 100%; height: auto;">
            <?php endif; ?>
        </div>

        <button type="submit" name="update_campaign_btn" class="btn btn-primary">Update Campaign</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
