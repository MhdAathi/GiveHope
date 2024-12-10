<style>
    /* Navbar */
    .sb-topnav {
        background: linear-gradient(135deg, #dc3545, #c82333);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        padding: 0.5rem 1rem;
        transition: background-color 0.3s ease;
    }

    .sb-topnav:hover {
        background: linear-gradient(135deg, #c82333, #dc3545);
    }

    /* Navbar Brand */
    .sb-topnav .navbar-brand {
        color: #ffffff;
        font-size: 24px;
        font-weight: bold;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: color 0.3s ease;
    }

    .sb-topnav .navbar-brand span {
        color: #000;
        font-weight: bold;
    }

    .sb-topnav .navbar-brand:hover {
        color: #ffcc00;
    }

    .sb-topnav .navbar-brand span:hover {
        color: #ffffff;
    }

    /* Sidebar Toggle Button */
    #sidebarToggle {
        color: #ffffff;
        font-size: 18px;
        margin-right: 10px;
        transition: color 0.3s ease;
    }

    #sidebarToggle:hover {
        color: #ffcc00;
    }

    /* Navbar Links */
    .sb-topnav .nav-link {
        color: #ffffff;
        font-size: 16px;
        font-weight: 500;
        margin-left: 15px;
        text-transform: capitalize;
        transition: color 0.3s ease, background-color 0.3s ease;
        position: relative;
    }

    .sb-topnav .nav-link:hover {
        color: #ffcc00;
    }

    .sb-topnav .nav-link:after {
        content: '';
        display: block;
        width: 0;
        height: 2px;
        background: #ffcc00;
        transition: width 0.3s;
        position: absolute;
        bottom: -5px;
        left: 0;
    }

    .sb-topnav .nav-link:hover:after {
        width: 100%;
    }

    /* Dropdown Menu */
    .sb-topnav .dropdown-menu {
        background-color: #dc3545;
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    .sb-topnav .dropdown-item {
        color: #ffffff;
        font-size: 14px;
        padding: 10px 20px;
        transition: background-color 0.3s ease;
    }

    .sb-topnav .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffcc00;
    }

    /* Search Form */
    .sb-topnav .form-inline .form-control {
        border-radius: 20px;
        border: 1px solid #ffffff;
        padding: 0.5rem 1rem;
    }

    .sb-topnav .form-inline .form-control:focus {
        box-shadow: none;
        border-color: #ffcc00;
    }

    .sb-topnav .form-inline .btn {
        background-color: #ffcc00;
        color: #dc3545;
        border: none;
        border-radius: 20px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .sb-topnav .form-inline .btn:hover {
        background-color: #e6b800;
        color: #ffffff;
    }
</style>

<nav class="sb-topnav navbar navbar-expand navbar-dark">
    <!-- Navbar Brand -->
    <a class="navbar-brand ps-3" href="../index.php">
        <span>BLOOD</span>HUB
    </a>
    <!-- Sidebar Toggle -->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
        <i class="fas fa-bars"></i>
    </button>
    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." />
            <button class="btn btn-primary" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>
    <!-- Navbar -->
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown">
                <?= $_SESSION['auth_user']['user_name'] ?> <i class="fas fa-user fa-fw"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a href="../index.php" class="dropdown-item">Home</a>
                </li>
                <li>
                    <form action="../all_code.php" method="POST">
                        <button type="submit" name="logout_btn" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>