<?php
include('authentication.php');
include('includes/header.php');
//include('dashboard_fetching.php');
?>

<style>
    * {
        text-transform: capitalize;
    }

    /* Global Styles */
    .container-fluid {
        padding: 0 20px;
    }

    .mt-4 {
        margin-top: 1.5rem;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    /* Card Styles */
    .card {
        border: none;
        border-radius: 10px;
        background: linear-gradient(to bottom, #780606, #b92b27);
        color: #fff;
        transition: transform 0.5s ease, box-shadow 0.5s ease;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .card-total {
        border: none;
        border-radius: 10px;
        border: 1px solid #ccc;
        background: linear-gradient(to bottom, #b92b27, #780606);
        color: #fff;
        transition: transform 0.5s ease, box-shadow 0.5s ease;
    }

    .card-total:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }


    .card-body {
        padding: 0.5rem;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
        text-align: center;
        margin-bottom: 1.0rem;
    }

    .progress {
        height: 20px;
        margin-bottom: 1rem;
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        background-color: #e38e00;
        height: 100%;
        border-radius: 10px;
    }

    .card-footer {
        background-color: #b92b27;
        padding: 0.5rem 1.5rem;
        border-top: none;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .small {
        font-size: 0.8rem;
    }

    .stretched-link {
        color: #fff;
        text-decoration: none;
    }

    .stretched-link:hover {
        color: #fff;
        text-decoration: none;
    }

    /* Icon Styles */
    .card i {
        font-size: 1.5rem;
        margin-right: 0.5rem;
    }

    .card i:hover {
        transform: rotate(360deg);
        transition: transform 0.5s ease-in-out;
    }

    /* Link Styles */
    a {
        text-decoration: none;
        color: #fff;
    }

    a:hover {
        color: #fff;
        text-decoration: none;
</style>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">BloodHub Stock Levels</li>
    </ol>

    <?php include('../message.php'); ?>
</div>


<?php
include('includes/footer.php');
include('includes/scripts.php');
?>