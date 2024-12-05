<style>
    /* Sidebar Styles */
    .sidenav-hidden {
        display: none;
    }

    #layoutSidenav_nav {
        width: 250px;
        background: #2c3e50;
        transition: transform 0.3s ease-in-out;
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
        display: block;
        text-decoration: none;
        transition: background-color 0.2s;
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

    #layoutSidenav_content {
        margin-left: 250px;
        transition: margin-left 0.3s;
    }

    .sidebar-visible #layoutSidenav_content {
        margin-left: 0;
    }

    .sidebar-hidden #layoutSidenav_content {
        margin-left: 250px;
    }

    .navbar-dark {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    }

    .navbar-brand {
        color: #ecf0f1;
        font-weight: bold;
        transition: color 0.3s;
    }

    .navbar-brand:hover {
        color: #c0392b;
    }

    .nav-link {
        color: #ecf0f1;
        padding: 10px 20px;
        transition: color 0.3s;
    }

    .nav-link:hover {
        color: #e74c3c;
    }

    .btn-link {
        color: #e74c3c;
        transition: color 0.3s;
    }

    .btn-link:hover {
        color: #c0392b;
    }
</style>

<div id="layoutSidenav_nav" class="sidebar-hidden">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <a class="nav-link mt-5" href="index.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tint"></i></div>
                    Dashboard
                </a>
                <div class="sb-sidenav-menu-heading">Admin Management</div>
                <a class="nav-link" href="viewregister.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                    Manage Users
                </a>
                <a class="nav-link" href="driver_details.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-truck"></i></div>
                    Driver Management
                </a>

                <div class="sb-sidenav-menu-heading">Staff Operations</div>
                <a class="nav-link" href="blood_requests.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-heart"></i></div>
                    View Blood Requests
                </a>
                <a class="nav-link" href="donor_history.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-medical"></i></div>
                    Access Donor History
                </a>
                <a class="nav-link" href="blood_inventory.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tint"></i></div>
                    Check Blood Inventory
                </a>

                <div class="sb-sidenav-menu-heading">Generate Reports</div>
                <a class="nav-link" href="blood_donation_report.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                    Blood Receive
                </a>
                <a class="nav-link" href="blood_dispatch_report.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-pie"></i></div>
                    Blood Dispatch
                </a>
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            <!-- <strong><?= $_SESSION['auth_user']['user_name'] ?></strong> -->
        </div>
    </nav>
</div>