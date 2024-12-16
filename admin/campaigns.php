<?php
include('authentication.php');
include('middleware\admin_auth.php');
include('includes/header.php');

// Get campaign category filter from GET parameters (optional)
$campaign_category = isset($_GET['campaign_category']) ? $_GET['campaign_category'] : null;
?>

<style>
    #campaignDetailsTable th:nth-child(2),
    /* Target the Description column header */
    #campaignDetailsTable td:nth-child(2) {
        /* Target the Description column data */
        width: 200px;
        /* Set a fixed width */
        max-width: 200px;
        /* Ensure it doesn't exceed this width */
        white-space: normal;
        /* Allow text wrapping */
        word-wrap: break-word;
        /* Break long words to fit within the width */
        overflow: hidden;
        /* Prevent content overflow */
    }

    #campaignDetailsTable th:nth-child(3),
    /* Target the Description column header */
    #campaignDetailsTable td:nth-child(3) {
        /* Target the Description column data */
        width: 200px;
        /* Set a fixed width */
        max-width: 200px;
        /* Ensure it doesn't exceed this width */
        white-space: normal;
        /* Allow text wrapping */
        word-wrap: break-word;
        /* Break long words to fit within the width */
        overflow: hidden;
        /* Prevent content overflow */
    }

    #campaignDetailsTable th:nth-child(4),
    /* Target the Description column header */
    #campaignDetailsTable td:nth-child(4) {
        /* Target the Description column data */
        width: 200px;
        /* Set a fixed width */
        max-width: 200px;
        /* Ensure it doesn't exceed this width */
        white-space: normal;
        /* Allow text wrapping */
        word-wrap: break-word;
        /* Break long words to fit within the width */
        overflow: hidden;
        /* Prevent content overflow */
    }
</style>

<div class="container-fluid px-4">
    <h3 class="mt-4">Campaign Details</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">Campaign Details</li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <!-- Show session messages -->
            <?php include('../message.php'); ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>All Campaigns <?= $campaign_category ? "($campaign_category)" : "" ?></h4>
                    <div class="d-flex">
                        <a href="generate_campaign_report.php" class="btn btn-primary btn-sm me-2">Generate Report</a>
                        <a href="../create_campaign.php" class="btn btn-primary btn-sm">Add Campaign</a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search Filters -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" id="searchCampaignTitle" class="form-control me-2" placeholder="Search by Campaign Title" onkeyup="filterTable()">
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

                    <table class="table table-bordered" id="campaignDetailsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Location</th>
                                <th>Description</th>
                                <th>Goal</th>
                                <th>Category</th>
                                <th>Document</th> <!-- New Document Column -->
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Organizer Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch campaign records from the database
                            $query = $campaign_category ? "SELECT * FROM campaigns WHERE category = '$campaign_category'" : "SELECT * FROM campaigns";
                            $query_run = mysqli_query($con, $query);

                            if ($query_run) {
                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $row) {
                            ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['id']); ?></td>
                                            <td><?= htmlspecialchars($row['title']); ?></td>
                                            <td><?= htmlspecialchars($row['location']); ?></td>
                                            <td><?= htmlspecialchars($row['description']); ?></td>
                                            <td><?= htmlspecialchars($row['goal']); ?></td>
                                            <td><?= htmlspecialchars($row['category']); ?></td>

                                            <!-- New Document Column -->
                                            <td>
                                                <?php if (!empty($row['document'])): ?>
                                                    <a href="<?= htmlspecialchars($row['document']); ?>" target="_blank" title="View Full Image">
                                                        <img src="<?= htmlspecialchars($row['document']); ?>" alt="Document" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No Document</span>
                                                <?php endif; ?>
                                            </td>

                                            <td><?= htmlspecialchars($row['start_date']); ?></td>
                                            <td><?= htmlspecialchars($row['end_date']); ?></td>
                                            <td><?= htmlspecialchars($row['organizer_name']); ?></td>

                                            <!-- Display status (Pending, Accepted, Rejected) -->
                                            <td>
                                                <?php
                                                $status = htmlspecialchars($row['status']);
                                                if ($status == 'Rejected') {
                                                    echo '<span class="badge bg-danger">Rejected</span>';
                                                } elseif ($status == 'Accepted') {
                                                    echo '<span class="badge bg-success">Accepted</span>';
                                                } else {
                                                    echo '<span class="badge bg-warning">Pending</span>';
                                                }
                                                ?>
                                            </td>

                                            <td class="text-center">
                                                <form action="admin_all_code.php" method="POST">
                                                    <input type="hidden" name="campaign_id" value="<?= $row['id']; ?>">
                                                    <?php if ($row['status'] == 'Pending'): ?>
                                                        <button type="submit" name="accept_btn" class="btn btn-success btn-sm" title="Accept">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                        <button type="submit" name="reject_btn" class="btn btn-danger btn-sm" title="Reject">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    <?php elseif ($row['status'] == 'Accepted'): ?>
                                                        <!-- Show Edit and Delete buttons if status is Accepted -->
                                                        <a href="edit_campaign.php?id=<?= htmlspecialchars($row['id']); ?>" class="btn btn-warning btn-sm" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-danger btn-sm" title="Delete" onclick="confirmDelete(<?= $row['id']; ?>)">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                </form>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                } else {
                                    // If no records found
                                    echo '<tr><td colspan="12">No Record Found for ' . ($campaign_category ? $campaign_category : 'all categories') . '!</td></tr>';
                                }
                            } else {
                                // Handle query execution failure
                                echo '<tr><td colspan="12">Error fetching records: ' . htmlspecialchars(mysqli_error($con)) . '</td></tr>';
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
    function confirmDelete(campaignId) {
        const isConfirmed = confirm("Are you sure you want to delete this campaign? This action cannot be undone.");
        if (isConfirmed) {
            // Redirect to the delete handler with campaign ID
            window.location.href = `admin_all_code.php?id=${campaignId}`;
        }
    }


    // JavaScript function for automatic search filter
    function filterTable() {
        const searchCampaignTitle = document.getElementById('searchCampaignTitle').value.toLowerCase();
        const searchCampaignCategory = document.getElementById('searchCampaignCategory').value.toLowerCase();
        const table = document.getElementById('campaignDetailsTable');
        const rows = table.getElementsByTagName('tr');

        // Loop through all table rows (skip the header row)
        for (let i = 1; i < rows.length; i++) {
            let row = rows[i];
            const campaignTitle = row.cells[1].textContent.toLowerCase();
            const campaignCategory = row.cells[5].textContent.toLowerCase();

            // Show the row if it matches the search criteria
            if ((campaignTitle.includes(searchCampaignTitle) || searchCampaignTitle === '') &&
                (campaignCategory.includes(searchCampaignCategory) || searchCampaignCategory === '')) {
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