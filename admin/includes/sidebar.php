<style>
    /* Sidebar Styles */
    #layoutSidenav_nav {
        width: 300px;
        /* Increased sidebar width */
        background: #2c3e50;
        transition: transform 0.3s ease-in-out;
    }

    #layoutSidenav_content {
        margin-left: 300px;
        /* Adjust content margin to match sidebar width */
        transition: margin-left 0.3s ease-in-out;
    }

    .sb-sidenav {
        height: 100%;
        position: fixed;
        z-index: 1000;
        padding: 0;
    }

    .sb-sidenav .nav {
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .sb-sidenav .nav-link {
        color: #ecf0f1;
        padding: 15px 20px;
        text-decoration: none;
        transition: background-color 0.2s ease;
    }

    .sb-sidenav .nav-link:hover {
        background-color: #34495e;
    }

    .sb-sidenav .sb-nav-link-icon {
        margin-right: 10px;
    }

    .sb-sidenav-menu-heading {
        color: #bdc3c7;
        padding: 10px 20px;
        font-size: 0.875rem;
        text-transform: uppercase;
    }

    .sb-sidenav-footer {
        background: #2c3e50;
        color: #ecf0f1;
        padding: 15px 20px;
        font-size: 0.875rem;
    }
</style>

<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <!-- Dashboard -->
                <div class="sb-sidenav-menu-heading"></div>
                <a class="nav-link mt-4" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>

                <!-- Campaign Management -->
                <div class="sb-sidenav-menu-heading">Campaign Management</div>
                <a class="nav-link" href="donations_per_campaign.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-donate"></i></div>
                    Donations Per Campaign
                </a>
                <a class="nav-link" href="donations_history.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-usd"></i></div>
                    Donation History
                </a>
                
                <!-- Admin Operations -->
                <div class="sb-sidenav-menu-heading">Admin Management</div>
                <a class="nav-link" href="campaigns.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-bullhorn"></i></div>
                    Manage Campaigns
                </a>
                
                <a class="nav-link" href="donors.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Manage Donors
                </a>
                
                <a class="nav-link" href="manage_users.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-user-cog"></i></div>
                    Manage Users
                </a>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <strong><?= htmlspecialchars($_SESSION['auth_user']['user_name']); ?></strong>
        </div>
    </nav>
</div>