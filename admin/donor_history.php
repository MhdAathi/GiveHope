<?php
include('authentication.php');
include('includes/header.php');

// Get campaign category filter from GET parameters (optional)
$campaign_category = isset($_GET['campaign_category']) ? $_GET['campaign_category'] : null;
?>

<style>
    /* Custom table styles */
    #donationDetailsTable th:nth-child(5),
    #donationDetailsTable td:nth-child(5) {
        max-width: 200px;
        white-space: normal;
        word-wrap: break-word;
        overflow: hidden;
    }
</style>

<div class="container-fluid px-4">
    <h3 class="mt-4">Donation Details</h3>
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
                    <h4>All Donations <?= $campaign_category ? "($campaign_category)" : "" ?></h4>
                    <div class="d-flex">
                        <a href="generate_donations_report.php" class="btn btn-primary btn-sm me-2">Generate Report</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" id="searchDonorName" class="form-control me-2" placeholder="Search by Donor Name" onkeyup="filterTable()">
                        </div>
                        <div class="col-md-2">
                            <select id="searchCampaignCategory" class="form-control" onchange="filterTable()">
                                <option value="">Select Category</option>
                                <option value="Education">Education</option>
                                <option value="Health">Health</option>
                                <option value="Environment">Environment</option>
                                <option value="Charity">Charity</option>
                                <!-- Add more categories as needed -->
                            </select>
                        </div>
                    </div>

                    <!-- Donation History Table -->
                    <table class="table table-bordered table-striped" id="donationDetailsTable">
                        <thead>
                            <tr>
                                <th>Campaign ID</th>
                                <th>Campaign Title</th>
                                <th>Donor Name</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch donation records along with campaign details from the database
                            $query = $campaign_category ? 
                                "SELECT d.*, c.id AS campaign_id, c.title AS campaign_name FROM donations d JOIN campaigns c ON d.campaign_id = c.id WHERE c.category = '$campaign_category'" : 
                                "SELECT d.*, c.id AS campaign_id, c.title AS campaign_name FROM donations d JOIN campaigns c ON d.campaign_id = c.id";
                            $query_run = mysqli_query($con, $query);

                            if ($query_run) {
                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $row) {
                            ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['campaign_id']); ?></td>
                                            <td><?= htmlspecialchars($row['campaign_name']); ?></td>
                                            <td><?= htmlspecialchars($row['donor_name']); ?></td>
                                            <td>LKR <?= number_format($row['amount'], 2); ?></td>
                                            <td><?= htmlspecialchars($row['payment_type']); ?></td>
                                            <td><?= htmlspecialchars($row['donation_date']); ?></td>
                                        </tr>
                            <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="6">No donations found for ' . ($campaign_category ? $campaign_category : 'all categories') . '!</td></tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">Error fetching donation records: ' . htmlspecialchars(mysqli_error($con)) . '</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(donationId) {
        const confirmed = confirm("Are you sure you want to delete this donation? This action cannot be undone.");
        if (confirmed) {
            window.location.href = `delete_donation.php?id=${donationId}`;
        }
    }

    // JavaScript function for automatic search filter
    function filterTable() {
        const searchDonorName = document.getElementById('searchDonorName').value.toLowerCase();
        const searchCampaignCategory = document.getElementById('searchCampaignCategory').value.toLowerCase();
        const table = document.getElementById('donationDetailsTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            let row = rows[i];
            const donorName = row.cells[2].textContent.toLowerCase();
            const campaignName = row.cells[1].textContent.toLowerCase();

            if ((donorName.includes(searchDonorName) || searchDonorName === '') &&
                (campaignName.includes(searchCampaignCategory) || searchCampaignCategory === '')) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    }
</script>

<?php
include('includes/footer.php');
?>
