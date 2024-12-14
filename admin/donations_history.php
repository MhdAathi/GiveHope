<?php
include('authentication.php');
include('includes/header.php');

// Initialize query variables
$query = "";
$result = null;

// Check if donor_name is provided in the URL
if (isset($_GET['donor_name']) && !empty($_GET['donor_name'])) {
    $donor_name = $_GET['donor_name'];

    // Fetch donations only for the given donor name
    $query = "SELECT d.id AS donation_id, d.amount, d.donation_date, d.payment_type, c.id AS campaign_id, c.title AS campaign_name 
              FROM donations d 
              JOIN campaigns c ON d.campaign_id = c.id 
              WHERE d.donor_name = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $donor_name);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // Fetch all donations if no donor_name is provided
    $query = "SELECT d.id AS donation_id, d.amount, d.donation_date, d.payment_type, c.id AS campaign_id, c.title AS campaign_name, d.donor_name 
              FROM donations d 
              JOIN campaigns c ON d.campaign_id = c.id";
    $result = mysqli_query($con, $query);
}
?>

<div class="container-fluid px-4">
    <h3 class="mt-4">Donations <?= isset($donor_name) ? "by " . htmlspecialchars($donor_name) : "List" ?></h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">Donation Details</li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <!-- Show session messages -->
            <?php include('../message.php'); ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Donation History</h4>
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
                                        <td><?= isset($row['donor_name']) ? htmlspecialchars($row['donor_name']) : htmlspecialchars($donor_name); ?></td>
                                        <td><?= number_format($row['amount'], 2); ?></td>
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

<?php
include('includes/footer.php');
?>
