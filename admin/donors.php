<?php
include('authentication.php');
include('includes/header.php');

// Fetch donor details from the donations table
$query = "SELECT id, donor_name, email, phone, address FROM donations";
$query_run = mysqli_query($con, $query);
?>

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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Donor Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Address</th>
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
                                            <td><?= htmlspecialchars($row['donor_name']); ?></td>
                                            <td><?= htmlspecialchars($row['email']); ?></td>
                                            <td><?= htmlspecialchars($row['phone']); ?></td>
                                            <td><?= htmlspecialchars($row['address']); ?></td>
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
                                    echo '<tr><td colspan="6" class="text-center">No Donor Records Found</td></tr>';
                                }
                            } else {
                                // If query fails
                                echo '<tr><td colspan="6" class="text-center">Error fetching data</td></tr>';
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