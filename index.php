<?php
//include('admin/authentication.php');
include('includes/header.php');
include('includes/navbar.php');
?>


<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Support the Cause, Make a Difference</h1>
        <p>Join hands with us in supporting global campaigns that create change.</p>
        <a href="#" class="btn btn-light">Create Campaign</a>
        <a href="#" class="btn btn-outline-light">Donate Now</a>
    </div>
</section>

<!-- Campaigns Section -->
<section class="campaigns">
    <div class="container">
        <h2 class="text-center">Our Active Campaigns</h2>
        <div class="campaigns-container">
            <div class="card">
                <img src="pics/2.jpg" class="card-img-top" alt="Campaign Image">
                <div class="card-body">
                    <h5 class="card-title">Campaign 1</h5>
                    <p class="card-text">Help children in need</p>
                    <a href="#" class="btn btn-primary">Donate</a>
                </div>
            </div>
            <div class="card">
                <img src="pics/3.jpg" class="card-img-top" alt="Campaign Image">
                <div class="card-body">
                    <h5 class="card-title">Campaign 2</h5>
                    <p class="card-text">Support for the elderly</p>
                    <a href="#" class="btn btn-primary">Donate</a>
                </div>
            </div>
            <div class="card">
                <img src="pics/4.jpg" class="card-img-top" alt="Campaign Image">
                <div class="card-body">
                    <h5 class="card-title">Campaign 3</h5>
                    <p class="card-text">Clean water for all</p>
                    <a href="#" class="btn btn-primary">Donate</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="how-it-works">
    <div class="container text-center">
        <h2>How it Works</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="icon">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <h4>Create Campaign</h4>
                <p>Create your campaign and tell your story.</p>
            </div>
            <div class="col-md-4">
                <div class="icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <h4>Donate</h4>
                <p>Support the cause by donating money.</p>
            </div>
            <div class="col-md-4">
                <div class="icon">
                    <i class="bi bi-people"></i>
                </div>
                <h4>Make a Difference</h4>
                <p>Your donation helps those in need.</p>
            </div>
        </div>
    </div>
</section>

<?php
include('includes/footer.php');
?>