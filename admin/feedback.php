<?php
include('authentication.php');
include('middleware\admin_auth.php');
include('includes/header.php');

// Fetch feedback details from the feedback table
$query = "SELECT id, name, email, feedback, created_at FROM feedback";
$query_run = mysqli_query($con, $query);
?>

<style>
    .search-bar-container {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .search-bar-container input {
        width: 100%;
        max-width: 400px;
    }
</style>

<div class="container-fluid px-4">
    <h3 class="mt-4">Manage Feedback</h3>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item active">Feedback</li>
    </ol>

    <div class="row">
        <div class="col-md-12">
            <!-- Display session messages -->
            <?php include('../message.php'); ?>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>All Feedback</h4>
                </div>
                <div class="card-body">
                    <!-- Search Filters -->
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-6">
                            <input type="text" id="searchName" class="form-control" placeholder="Search by Name">
                        </div>
                    </div>

                    <table class="table table-bordered" id="feedbackTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Feedback</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($query_run) {
                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $row) {
                            ?>
                                        <tr>
                                            <td><?= htmlspecialchars($row['id']); ?></td>
                                            <td class="name"><?= htmlspecialchars($row['name']); ?></td>
                                            <td><?= htmlspecialchars($row['email']); ?></td>
                                            <td><?= htmlspecialchars($row['feedback']); ?></td>
                                            <td><?= htmlspecialchars($row['created_at']); ?></td>
                                            <td>
                                                <!-- Delete Feedback Button -->
                                                <form action="admin_feedback_code.php" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this feedback?');">
                                                    <input type="hidden" name="feedback_id" value="<?= $row['id']; ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete Feedback">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                } else {
                                    echo '<tr><td colspan="6" class="text-center">No Feedback Records Found</td></tr>';
                                }
                            } else {
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

<script>
    // JavaScript to filter the feedback table
    document.getElementById('searchName').addEventListener('input', function() {
        filterTable('name', this.value.toLowerCase());
    });

    document.getElementById('searchEmail').addEventListener('input', function() {
        filterTable('email', this.value.toLowerCase());
    });

    function filterTable(className, filterValue) {
        const rows = document.querySelectorAll('#feedbackTable tbody tr');
        rows.forEach(row => {
            const cell = row.querySelector('.' + className);
            if (cell && cell.textContent.toLowerCase().includes(filterValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>