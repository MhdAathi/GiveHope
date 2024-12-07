<?php
//include('admin/authentication.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<style>
    /* Hero Section */
    .hero {
        background: linear-gradient(to right, #1d3557, #457b9d);
        /* Gradient from dark to light blue */
        color: white;
        text-align: center;
        padding: 120px 0;
        /* Adjusted padding for balanced spacing */
        animation: fadeIn 1.5s ease-in-out;
    }

    .hero h1 {
        font-size: 4.5rem;
        /* Slightly larger font size for the heading */
        font-weight: 700;
        /* Bold text for emphasis */
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        /* Subtle shadow effect for text */
    }

    .hero p {
        font-size: 1.4rem;
        margin-top: 20px;
        font-weight: 300;
        /* Light weight for better readability */
        text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.2);
    }

    .hero a {
        font-size: 1.2rem;
        padding: 15px 40px;
        border-radius: 25px;
        margin: 10px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .hero a:hover {
        transform: scale(1.1);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
    }

    /* Campaign Section */
    .campaigns {
        background-color: #e9ecef;
        padding: 50px 0;
        animation: fadeInUp 1.5s ease-out;
    }

    .campaigns-container {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .card {
        width: 18rem;
        margin-bottom: 1rem;
        border: none;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .card-text {
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }

    /* How it Works Section */
    .how-it-works {
        background-color: #f1f1f1;
        padding: 60px 0;
        animation: fadeInUp 1.5s ease-out;
    }

    .icon {
        font-size: 3rem;
        color: #1d3557;
        margin-bottom: 15px;
        transition: transform 0.3s ease-in-out;
    }

    .icon:hover {
        transform: rotate(360deg);
    }

    /* Animations */
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }

        100% {
            opacity: 1;
        }
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInFromLeft {
        0% {
            transform: translateX(-50px);
            opacity: 0;
        }

        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes fadeInFromRight {
        0% {
            transform: translateX(50px);
            opacity: 0;
        }

        100% {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Responsive design tweaks */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 3rem;
        }

        .hero p {
            font-size: 1.2rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .campaigns-container {
            display: block;
        }
    }

    /* Scrollbar Styles */
    .campaigns-container::-webkit-scrollbar {
        height: 10px;
    }

    .campaigns-container::-webkit-scrollbar-thumb {
        background-color: #1d3557;
        border-radius: 10px;
    }

    .campaigns-container::-webkit-scrollbar-track {
        background-color: #e9ecef;
    }

    /* Video section */
    .video iframe {
        width: 100%;
        height: 500px;
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Support the Cause, Make a Difference</h1>
        <p>Join hands with us in supporting global campaigns that create change.</p>
        <a href="create_campaign.php" class="btn btn-light">Create Campaign</a>
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