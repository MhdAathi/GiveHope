<?php
include('authentication.php');
include('middleware\admin_auth.php');
include('includes/header.php');

// Fetch donor details from the donations table
$query = "SELECT 
            d.id, 
            d.donor_name, 
            d.email, 
            d.phone, 
            d.address, 
            d.location
          FROM 
            donations d";
$query_run = mysqli_query($con, $query);
?>

<style>
    .search-bar-container {
        display: flex;
        justify-content: space-between;
        /* Space between the fields */
        margin-bottom: 20px;
        /* Add space below the search bar */
    }

    .search-bar-container input {
        width: 100%;
        /* Make input fields responsive within the column */
        max-width: 400px;
        /* Set a maximum width */
    }
</style>


<div class="container-fluid px-4">
    <h3 class="mt-4">Donor Details</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">Donor Details</li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <!-- Display session messages -->
            <?php include('../message.php'); ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>All Donors</h4>
                </div>
                <div class="card-body">
                    <!-- Search Filters -->
                    <div class="row mb-3 align-items-center"> <!-- Added align-items-center for vertical alignment -->
                        <div class="col-md-4"> <!-- Adjusted column width -->
                            <input type="text" id="searchDonorName" class="form-control" placeholder="Search by Donor Name">
                        </div>
                        <div class="col-md-4"> <!-- Adjusted column width -->
                            <input type="text" id="searchLocation" class="form-control" placeholder="Search by Location">
                        </div>
                    </div>


                    <table class="table table-bordered" id="donorTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Donor Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Address</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($query_run) {
                                if (mysqli_num_rows($query_run) > 0) {
                                    $count = 1;
                                    foreach ($query_run as $row) {
                            ?>
                                        <tr>
                                            <td><?= $count++; ?></td>
                                            <td class="donor-name"><?= htmlspecialchars($row['donor_name']); ?></td>
                                            <td><?= htmlspecialchars($row['email']); ?></td>
                                            <td><?= htmlspecialchars($row['phone']); ?></td>
                                            <td><?= htmlspecialchars($row['address']); ?></td>
                                            <td class="location"><?= htmlspecialchars($row['location']); ?></td>
                                            <td>
                                                <!-- View Donation Button -->
                                                <a href="donations_history.php?donor_name=<?= urlencode($row['donor_name']); ?>" class="btn btn-info btn-sm" title="View Donations">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <!-- Delete Donor Button -->
                                                <form action="admin_all_code.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this donation?');">
                                                    <input type="hidden" name="donation_id" value="<?= $row['id']; ?>"> <!-- Pass the donation ID -->
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Donation">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                } else {
                                    // If no records found
                                    echo '<tr><td colspan="7" class="text-center">No Donor Records Found</td></tr>';
                                }
                            } else {
                                // If query fails
                                echo '<tr><td colspan="7" class="text-center">Error fetching data</td></tr>';
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
include('includes/scripts.php');
?>

<script>
    document.getElementById('searchDonorName').addEventListener('input', function() {
        filterTable('donor-name', this.value.toLowerCase(), 2); // Minimum 2 characters
    });

    document.getElementById('searchLocation').addEventListener('input', function() {
        filterTable('location', this.value.toLowerCase(), 2); // Minimum 2 characters
    });

    function filterTable(className, filterValue, minLength) {
        const rows = document.querySelectorAll('#donorTable tbody tr');
        if (filterValue.length >= minLength) {
            rows.forEach(row => {
                const cell = row.querySelector('.' + className);
                if (cell && cell.textContent.toLowerCase().includes(filterValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        } else {
            // If filter length is less than minimum, reset the table to show all rows
            rows.forEach(row => {
                row.style.display = '';
            });
        }
    }
</script>