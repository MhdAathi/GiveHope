<?php
include('authentication.php');
include('includes/header.php');

// Check if donor_name is passed as a query parameter
$donor_name = isset($_GET['donor_name']) && !empty($_GET['donor_name']) ? mysqli_real_escape_string($con, $_GET['donor_name']) : null;

// Admin Access
if ($_SESSION['auth_user']['user_id'] == 1) {
    // Admin: Fetch all donations or filter by donor_name
    $query = "SELECT d.id AS donation_id, d.amount, d.donation_date, d.payment_type, 
                     c.id AS campaign_id, c.title AS campaign_name, d.donor_name, 
                     CONCAT(d.province, ', ', d.district) AS location
              FROM donations d 
              JOIN campaigns c ON d.campaign_id = c.id";
    if ($donor_name) {
        $query .= " WHERE d.donor_name = '$donor_name'";
    }
    $result = mysqli_query($con, $query);
} else {
    // Campaign creator: Fetch only donations for their campaigns
    $user_id = $_SESSION['auth_user']['user_id'];
    $query = "SELECT d.id AS donation_id, d.amount, d.donation_date, d.payment_type, 
                     c.id AS campaign_id, c.title AS campaign_name, d.donor_name, 
                     CONCAT(d.province, ', ', d.district) AS location
              FROM donations d 
              JOIN campaigns c ON d.campaign_id = c.id 
              WHERE c.user_id = ?";
    if ($donor_name) {
        $query .= " AND d.donor_name = ?";
    }
    $stmt = $con->prepare($query);
    if ($donor_name) {
        $stmt->bind_param("is", $user_id, $donor_name);
    } else {
        $stmt->bind_param("i", $user_id);
    }
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<div class="container-fluid px-4">
    <h3 class="mt-4">Donation History</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">Donation History</li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <!-- Show session messages -->
            <?php include('../message.php'); ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Donations</h4>
                    <a href="generate_donations_report.php" class="btn btn-primary btn-sm">Generate Report</a>
                </div>
                <div class="card-body">
                    <!-- Donation History Table -->
                    <table class="table table-bordered" id="donationDetailsTable">
                        <thead>
                            <tr>
                                <th>Campaign ID</th>
                                <th>Campaign Title</th>
                                <th>Donor Name</th>
                                <th>Location</th>
                                <th>Amount (LKR)</th>
                                <th>Payment Method</th>
                                <th>Donation Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['campaign_id']); ?></td>
                                        <td><?= htmlspecialchars($row['campaign_name']); ?></td>
                                        <td><?= htmlspecialchars($row['donor_name']); ?></td>
                                        <td><?= htmlspecialchars($row['location']); ?></td> <!-- Display Location -->
                                        <td>LKR <?= number_format($row['amount'], 2); ?></td>
                                        <td><?= htmlspecialchars($row['payment_type']); ?></td>
                                        <td><?= htmlspecialchars($row['donation_date']); ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="6" class="text-center">No Donations Found</td></tr>';
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