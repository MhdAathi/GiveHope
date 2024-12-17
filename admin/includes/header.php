<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="GiveHope - A platform to manage Campaign Donation System." />
    <meta name="author" content="GiveHope Team" />

    <title>GiveHope - Campaign Donation System</title>

    <!-- CSS Links -->
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/custom.css" rel="stylesheet" />
    <link href="css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!-- Font Awesome for Icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Bootstrap 5 JS & Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>


    <!-- Summernote CSS - CDN Link -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <!-- //Summernote CSS - CDN Link -->

    <!-- Additional CSS for DataTables -->
    <link href="css/jquery.dataTables.min.css" rel="stylesheet" />

    <style>
        /* Full-page Loader Styles */
        .full-page-loader {
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            visibility: hidden;
            opacity: 100%;
            transition: visibility 0s linear 0.3s, opacity 0.3s ease-in-out;
        }

        .full-page-loader.active {
            visibility: visible;
            opacity: 1;
            transition-delay: 0s;
        }

        /* Flipping Loader Animation */
        .flipping {
            height: 22.4px;
            display: grid;
            grid-template-columns: repeat(5, 22.4px);
            grid-gap: 5.6px;
        }

        .flipping div {
            animation: flipping-owie1ymd 0.75s calc(var(--delay) * 0.6s) infinite ease;
            background-color: #c20114;
        }

        .flipping div:nth-of-type(1) {
            --delay: 0.15;
        }

        .flipping div:nth-of-type(2) {
            --delay: 0.3;
        }

        .flipping div:nth-of-type(3) {
            --delay: 0.45;
        }

        .flipping div:nth-of-type(4) {
            --delay: 0.6;
        }

        .flipping div:nth-of-type(5) {
            --delay: 0.75;
        }

        @keyframes flipping-owie1ymd {
            0% {
                transform: perspective(44.8px) rotateY(-180deg);
            }

            50% {
                transform: perspective(44.8px) rotateY(0deg);
            }
        }
    </style>

</head>

<body class="sb-nav-fixed">

    <!-- Full-page loader
    <div class="full-page-loader" id="fullPageLoader">
        <div class="flipping">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div> -->

    <!-- Include Navbar and Sidebar -->
    <?php include('includes/navbar-top.php'); ?>
    <div id="layoutSidenav">
        <?php include('includes/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>