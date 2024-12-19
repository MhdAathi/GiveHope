<?php
include('authentication.php');
include('includes/header.php');

// Check if the logged-in user is an admin
if ($_SESSION['auth_user']['user_id'] == 1) {
    // Admin: Fetch all accepted campaigns
    $query = "
        SELECT id AS campaign_id, title AS campaign_name, goal, raised, 
               end_date AS deadline, user_id 
        FROM campaigns 
        WHERE status = 'Accepted'";
    $query_run = mysqli_query($con, $query);
} else {
    // Campaign creator: Fetch only their accepted campaigns
    $user_id = $_SESSION['auth_user']['user_id']; // Get the logged-in user's ID
    $query = "
        SELECT id AS campaign_id, title AS campaign_name, goal, raised, 
               end_date AS deadline 
        FROM campaigns 
        WHERE user_id = ? AND status = 'Accepted'";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $query_run = $stmt->get_result();
}
?>

<div class="container-fluid px-4">
    <h3 class="mt-4">Donations Per Campaign</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">Donations Per Campaign</li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <!-- Show session messages -->
            <?php include('../message.php'); ?>

            <div class="card">
                <div class="card-header">
                    <h4>Your Campaigns</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover" id="campaignDetailsTable">
                        <thead>
                            <tr>
                                <th>Campaign ID</th>
                                <th>Campaign Name</th>
                                <th>Goal</th>
                                <th>Raised Amount</th>
                                <th>Deadline</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($query_run && $query_run->num_rows > 0) {
                                foreach ($query_run as $row) {
                                    $status = '';
                                    $current_date = date("Y-m-d");

                                    // Determine status
                                    if ($row['deadline'] < $current_date) {
                                        $status = 'Expired';
                                    } elseif ($row['raised'] >= $row['goal']) {
                                        $status = 'Raised';
                                    } else {
                                        $status = 'Pending';
                                    }
                            ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['campaign_id']); ?></td>
                                        <td><?= htmlspecialchars($row['campaign_name']); ?></td>
                                        <td>LKR <?= number_format($row['goal'], 2); ?></td>
                                        <td>LKR <?= number_format($row['raised'], 2); ?></td>
                                        <td><?= htmlspecialchars($row['deadline']); ?></td>
                                        <td>
                                            <span class="badge 
                                                <?= $status === 'Pending' ? 'bg-warning' : '' ?>
                                                <?= $status === 'Raised' ? 'bg-success' : '' ?>
                                                <?= $status === 'Expired' ? 'bg-danger' : '' ?>">
                                                <?= $status; ?>
                                            </span>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center">No Campaigns Found</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>