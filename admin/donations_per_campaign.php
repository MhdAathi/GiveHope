<?php
include('authentication.php');
include('includes/header.php');

// Fetch campaign data along with raised amount
$query = "
    SELECT 
        id AS campaign_id,
        title AS campaign_name,
        goal,
        raised,
        end_date AS deadline,
        status
    FROM campaigns";
$query_run = mysqli_query($con, $query);
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
                    <h4>Donations Per Campaign</h4>
                </div>
                <div class="card-body">
                    <!-- Search Filters -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" id="searchCampaignName" class="form-control" placeholder="Search by Campaign Name" onkeyup="filterTable()">
                        </div>
                        <div class="col-md-3">
                            <select id="searchStatus" class="form-control" onchange="filterTable()">
                                <option value="">Select Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Raised">Raised</option>
                                <option value="Expired">Expired</option>
                            </select>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover" id="campaignDetailsTable">
                        <thead>
                            <tr>
                                <th>Campaign ID</th>
                                <th>Campaign Name</th>
                                <th>Goal</th>
                                <th>Raised Amount</th>
                                <th>Deadline</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($query_run && mysqli_num_rows($query_run) > 0) {
                                foreach ($query_run as $row) {
                                    $status = '';
                                    $current_date = date("Y-m-d");

                                    // Determine status based on conditions
                                    if ($row['deadline'] < $current_date) {
                                        $status = 'Expired'; // Deadline has passed
                                    } elseif ($row['raised'] >= $row['goal']) {
                                        $status = 'Raised'; // Goal has been reached
                                    } else {
                                        $status = 'Pending'; // Not yet fully funded
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
                                        <td>
                                            <a href="update_campaign.php?id=<?= $row['campaign_id']; ?>" class="btn btn-primary btn-sm" title="Update">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">No Records Found</td></tr>';
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
    function filterTable() {
        const searchCampaignName = document.getElementById('searchCampaignName').value.toLowerCase();
        const searchStatus = document.getElementById('searchStatus').value.toLowerCase();
        const table = document.getElementById('campaignDetailsTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const campaignName = row.cells[1].textContent.toLowerCase();
            const status = row.cells[5].textContent.toLowerCase();

            // Filter rows based on input values
            const matchesCampaignName = campaignName.includes(searchCampaignName) || !searchCampaignName;
            const matchesStatus = status.includes(searchStatus) || !searchStatus;

            row.style.display = matchesCampaignName && matchesStatus ? '' : 'none';
        }
    }
</script>

<?php include('includes/footer.php'); ?>