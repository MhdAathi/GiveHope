<?php
include('admin/authentication.php');
include('includes/header.php');
include('includes/navbar.php');

// Handle Pagination
$limit = 12; // Campaigns per page
$page = $_GET['page'] ?? 1;
$offset = ($page - 1) * $limit;

// Handle Categories and Search Filters
$search = $_GET['search'] ?? '';
$category = $_GET['category'] ?? '';
$filter = $_GET['filter'] ?? 'latest'; // Default filter

$query_conditions = "WHERE status = 'Accepted'";

// Search filter
if ($search) {
    $query_conditions .= " AND title LIKE '%" . mysqli_real_escape_string($con, $search) . "%'";
}

// Category filter
if ($category) {
    $query_conditions .= " AND category = '" . mysqli_real_escape_string($con, $category) . "'";
}

// Sorting logic based on filter
switch ($filter) {
    case 'ending_soon':
        $query_order = "ORDER BY end_date ASC";
        break;
    case 'top_funded':
        $query_order = "ORDER BY raised DESC";
        break;
    case 'fully_funded':
        $query_conditions .= " AND raised >= goal";
        $query_order = "ORDER BY created_at DESC";
        break;
    default: // Latest campaigns
        $query_order = "ORDER BY created_at DESC";
}

// Fetch total campaigns count
$total_query = "SELECT COUNT(*) as total FROM campaigns $query_conditions";
$total_result = mysqli_query($con, $total_query);
$total_campaigns = mysqli_fetch_assoc($total_result)['total'];
$total_pages = ceil($total_campaigns / $limit);

// Fetch campaigns with pagination
$query = "SELECT * FROM campaigns $query_conditions $query_order LIMIT $limit OFFSET $offset";
$query_run = mysqli_query($con, $query);
?>

<style>
    /* General Styles */
    .navbar {
        width: 100%;
        box-sizing: border-box;
        position: relative;
        z-index: 1000;
    }

    /* Campaign Grid Layout */
    .campaign-container {
        background-color: #ffffff;
        padding: 20px;
        animation: fadeInUp 1.5s ease-out;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    /* Campaign Grid Layout */
    .campaign-wrapper-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
    }

    .campaign-card-container {
        width: 100%;
        max-width: 350px;
        flex: 1 1 25%;
        /* 4 cards per row */
        display: flex;
        justify-content: center;
    }

    /* Campaign Card */
    .campaign-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        width: 100%;
        max-width: 350px;
        /* Keep a consistent width */
        height: 480px;
        /* Set a fixed height for all cards */
        background: #f8f9fa;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin: auto;
    }

    .campaign-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    /* Campaign Header */
    .campaign-header {
        position: relative;
    }

    .campaign-header .campaign-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .campaign-header .verified-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        background: green;
        color: white;
        font-size: 10px;
        font-weight: bold;
        padding: 3px 8px;
        border-radius: 5px;
        z-index: 2;
    }

    /* Campaign Body */
    .campaign-body {
        padding: 15px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .campaign-title {
        font-size: 15px;
        font-weight: bold;
        color: #333;
        margin-bottom: 8px;
    }

    .campaign-meta {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #777;
        margin-bottom: 10px;
    }

    .campaign-description {
        font-size: 14px;
        color: #555;
        line-height: 1.5;
        margin-bottom: 15px;
        height: 60px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Progress Bar */
    .campaign-progress {
        position: relative;
        background: #f0f0f0;
        border-radius: 5px;
        overflow: hidden;
        height: 8px;
        margin-bottom: 15px;
    }

    .campaign-progress {
        margin-top: auto;
        /* Push progress bar to the bottom of the card */
    }

    .campaign-progress .progress-bar {
        height: 100%;
        background: #28a745;
        width: 0;
        transition: width 0.5s ease;
    }

    .campaign-stats p {
        margin: 0;
        line-height: 1.2;
        font-size: 12px;
        margin-bottom: 10px;
    }

    .campaign-actions {
        display: flex;
        gap: 10px;
    }

    .see-more {
        display: inline-block;
        font-size: 14px;
        color: #1d3557;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    /* Make buttons consistent in size */
    .btn-donate {
        padding: 10px 15px;
        font-size: 14px;
        font-weight: 400%;
        border-radius: 25px;
        text-align: center;
        flex: 1;
        text-decoration: none;
    }

    .btn-donate {
        background: #1d3557;
        color: white;
    }

    .btn-see-more {
        padding: 15px 20px;
        font-size: 14px;
        font-weight: 400%;
        border-radius: 25px;
        text-align: center;
        flex: 1;
        text-decoration: none;
    }

    .btn-see-more {
        background: #1d3557;
        color: white;
    }

    .btn-see-more:hover {
        opacity: 0.9;
        transform: scale(1.1);
    }

    .btn-view {
        background: #1d3557;
        color: white;
    }

    .btn-donate:hover,
    .btn-view:hover {
        opacity: 0.9;
    }

    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a {
        padding: 8px 15px;
        margin: 0 5px;
        background: #1d3557;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
    }

    .pagination a:hover,
    .pagination a.active {
        background: #457b9d;
    }

    /* Filters */
    #searchInput,
    #categoryFilter {
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    #searchInput:focus,
    #categoryFilter:focus {
        outline: none;
        border-color: #1d3557;
        box-shadow: 0 0 5px rgba(29, 53, 87, 0.5);
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .campaign-card-container {
            flex: 1 1 50%;
            /* 2 cards per row for medium screens */
        }
    }

    @media (max-width: 768px) {
        .campaign-card-container {
            flex: 1 1 100%;
            /* 1 card per row for small screens */
        }
    }

    @media (max-width: 576px) {
        .campaign-title {
            font-size: 1rem;
        }
    }

    .filter-section input,
    .filter-section select {
        padding: 10px;
        margin-bottom: 10px;
    }
</style>

<div class="container mt-5">
    <!-- Filter and Search -->
    <div class="row mb-4 filter-section">
        <div class="col-md-4">
            <input type="text" id="searchInput" placeholder="Search campaigns..." class="form-control"
                value="<?= htmlspecialchars($search) ?>" onchange="updateFilters()">
        </div>
        <div class="col-md-4">
            <select id="categoryFilter" class="form-control" onchange="updateFilters()">
                <option value="">All Categories</option>
                <option value="Education" <?= $category == 'Education' ? 'selected' : '' ?>>Education</option>
                <option value="Environment" <?= $category == 'Environment' ? 'selected' : '' ?>>Environment</option>
                <option value="Health" <?= $category == 'Health' ? 'selected' : '' ?>>Health</option>
            </select>
        </div>
        <div class="col-md-4">
            <select id="filter" class="form-control" onchange="updateFilters()">
                <option value="latest" <?= $filter == 'latest' ? 'selected' : '' ?>>Latest Campaigns</option>
                <option value="ending_soon" <?= $filter == 'ending_soon' ? 'selected' : '' ?>>Ending Soon</option>
                <option value="top_funded" <?= $filter == 'top_funded' ? 'selected' : '' ?>>Top Funded</option>
                <option value="fully_funded" <?= $filter == 'fully_funded' ? 'selected' : '' ?>>Fully Funded</option>
            </select>
        </div>
    </div>

    <!-- Campaign Grid -->
    <div class="row" id="campaign-container">
        <div class="campaign-wrapper-container">
            <?php
            if ($query_run && mysqli_num_rows($query_run) > 0) {
                foreach ($query_run as $campaign) {
                    $progress = ($campaign['raised'] / $campaign['goal']) * 100;
            ?>
                    <!-- Each Campaign Card - 4 cards per row -->
                    <div class="col-md-3 mb-4 campaign-card-container"
                        data-title="<?= htmlspecialchars($campaign['title']); ?>"
                        data-category="<?= htmlspecialchars($campaign['category']); ?>">
                        <div class="campaign-card">
                            <div class="campaign-header">
                                <div class="verified-badge">
                                    <span>✔ Verified</span>
                                </div>
                                <img src="<?= htmlspecialchars($campaign['image']); ?>" alt="<?= htmlspecialchars($campaign['title']); ?>" class="campaign-image">
                            </div>
                            <div class="campaign-body">
                                <h3 class="campaign-title"><?= htmlspecialchars(substr($campaign['title'], 0, 30)); ?></h3>
                                <div class="campaign-meta">
                                    <span class="campaign-location"><i class="fas fa-map-marker-alt"></i> <?= htmlspecialchars($campaign['location']); ?></span>
                                    <span class="campaign-category"><?= htmlspecialchars($campaign['category']); ?></span>
                                </div>
                                <p class="campaign-description">
                                    <?= htmlspecialchars(substr($campaign['description'], 0, 50)) . '...'; ?>
                                    <a href="donate.php?id=<?= $campaign['id']; ?>" class="see-more">See More</a>
                                </p>
                                <div class="campaign-progress">
                                    <div class="progress-bar" style="width: <?= round($progress, 2); ?>%;"></div>
                                </div>
                                <div class="campaign-stats">
                                    <p><strong>Raised:</strong> LKR <?= number_format($campaign['raised'], 2); ?></p>
                                    <p><strong>Goal:</strong> LKR <?= number_format($campaign['goal'], 2); ?></p>
                                </div>
                                <div class="campaign-actions">
                                    <a href="donate.php?id=<?= $campaign['id']; ?>" class="btn-donate">Donate Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p class='text-center'>No campaigns available at the moment.</p>";
            }
            ?>
        </div>

        <!-- Pagination -->
        <div class="pagination mt-3 mb-3">
            <?php if ($page > 1) : ?>
                <a href="?page=<?= $page - 1; ?>&search=<?= urlencode($search); ?>&category=<?= urlencode($category); ?>&filter=<?= urlencode($filter); ?>">Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                <a href="?page=<?= $i; ?>&search=<?= urlencode($search); ?>&category=<?= urlencode($category); ?>&filter=<?= urlencode($filter); ?>" class="<?= $i == $page ? 'active' : ''; ?>"><?= $i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $total_pages) : ?>
                <a href="?page=<?= $page + 1; ?>&search=<?= urlencode($search); ?>&category=<?= urlencode($category); ?>&filter=<?= urlencode($filter); ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    // Update filters dynamically
    function updateFilters() {
        const search = document.getElementById('searchInput').value;
        const category = document.getElementById('categoryFilter').value;
        const filter = document.getElementById('filter').value;
        window.location.href = `?search=${encodeURIComponent(search)}&category=${encodeURIComponent(category)}&filter=${encodeURIComponent(filter)}`;
    }
</script>

<?php include('includes/footer.php'); ?>