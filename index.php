<?php
include('admin/authentication.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<style>
    /* Enable smooth scrolling across the page */
    html {
        scroll-behavior: smooth;
    }

    /* Hero Section */
    .hero {
        background: linear-gradient(to right, #1d3557, #457b9d);
        color: white;
        text-align: center;
        padding: 100px 0;
        animation: fadeIn 1.5s ease-in-out;
    }

    .hero h1 {
        font-size: 3.5rem;
        font-weight: 700;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    }

    .hero p {
        font-size: 1.4rem;
        margin-top: 15px;
        font-weight: 300;
        text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.3);
    }

    .hero a {
        font-size: 1.1rem;
        padding: 12px 28px;
        border-radius: 25px;
        margin: 10px;
        transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        text-decoration: none;
    }

    .hero a.btn-light {
        background-color: #ffffff;
        color: #1d3557;
    }

    .hero a.btn-outline-light {
        border: 2px solid #ffffff;
        color: #ffffff;
    }

    .hero a:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        color: #1d3557;
    }

    /* Campaign Section */
    .campaigns {
        background-color: #ffffff;
        padding: 20px;
        animation: fadeInUp 1.5s ease-out;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .campaign-wrapper-container {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        max-width: 1200px;
    }

    .campaign-wrapper {
        display: flex;
        overflow: hidden;
        gap: 20px;
        width: 100%;
        max-width: 1000px;
        position: relative;
    }

    /* Add animation classes */
    .campaign-card.slide-in-right {
        animation: slideInRight 0.5s ease forwards;
    }

    .campaign-card.slide-in-left {
        animation: slideInLeft 0.5s ease forwards;
    }

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
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .campaign-header {
        position: relative;
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

    .campaign-header .campaign-image {
        width: 100%;
        height: 180px;
        /* Ensure consistent image height */
        object-fit: cover;
        /* Maintain aspect ratio while filling the container */
    }

    .campaign-body {
        padding: 15px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
        /* Ensure content fills available space */
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
        color: #666;
        line-height: 1.5;
        margin-bottom: 15px;
        height: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .campaign-progress {
        margin-top: auto;
        /* Push progress bar to the bottom of the card */
    }

    .campaign-progress {
        position: relative;
        background: #f0f0f0;
        border-radius: 5px;
        overflow: hidden;
        height: 8px;
        margin-bottom: 15px;
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

    .btn-donate {
        background: #28a745;
        color: white;
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
        background: #28a745;
        color: white;
    }

    .btn-view {
        background: #1d3557;
        color: white;
    }

    .btn-donate:hover,
    .btn-view:hover {
        opacity: 0.9;
    }

    /* Align the arrows for navigation */
    .arrow-left,
    .arrow-right {
        display: flex;
        justify-content: center;
        align-items: center;
        background: #1d3557;
        color: #fff;
        border: none;
        padding: 10px;
        font-size: 18px;
        font-weight: bold;
        border-radius: 50%;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        width: 50px;
        height: 50px;
        transition: transform 0.3s ease;
    }

    .arrow-left:hover,
    .arrow-right:hover {
        opacity: 0.9;
        transform: scale(1.1);
    }

    .arrow-left:disabled,
    .arrow-right:disabled {
        background: #ccc;
        cursor: not-allowed;
    }

    /* Campaign Section End*/

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

    /* Responsive design tweaks */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 3rem;
        }

        .hero p {
            font-size: 1.2rem;
        }

        .campaign-card {
            width: 100%;
            max-width: 350px;
        }

        .campaign-navigation {
            flex-direction: column;
            align-items: center;
        }

        .campaign-navigation button {
            margin: 5px 0;
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

    /* Smooth Transition Animations */
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideInLeft {
        from {
            transform: translateX(-100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Support the Cause, Make a Difference</h1>
        <p>Join hands with us in supporting global campaigns that create change.</p>
        <a href="create_campaign.php" class="btn btn-light">Create Campaign</a>
        <a href="#campaigns-section" class="btn btn-outline-light">Donate Now</a>
    </div>
</section>

<!-- Campaigns Section -->
<section class="campaigns" id="campaigns-section">
    <div class="campaign-wrapper-container">
        <button class="arrow-left" onclick="prevCards()">←</button>
        <div class="campaign-wrapper">
            <!-- Dynamic PHP Cards -->
            <?php
            // Fetch campaigns from the database
            $query = "SELECT * FROM campaigns WHERE status = 'Accepted'";
            $query_run = mysqli_query($con, $query);

            if ($query_run && mysqli_num_rows($query_run) > 0) {
                foreach ($query_run as $campaign) {
                    // Calculate progress
                    $progress = ($campaign['raised'] / $campaign['goal']) * 100;
            ?>
                    <div class="campaign-card" onclick="window.location.href='donate.php?id=<?= $campaign['id']; ?>';" style="cursor: pointer;">
                        <div class="campaign-header">
                            <div class="verified-badge">
                                <span>✔ Verified</span>
                            </div>
                            <img src="<?= htmlspecialchars($campaign['image']); ?>" alt="<?= htmlspecialchars($campaign['title']); ?>" class="campaign-image">
                        </div>

                        <div class="campaign-body">
                            <h3 class="campaign-title"><?= htmlspecialchars($campaign['title']); ?></h3>
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
            <?php
                }
            } else {
                echo "<p>No campaigns available at the moment.</p>";
            }
            ?>
        </div>
        <button class="arrow-right" onclick="nextCards()">→</button>
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

<script>
    let currentIndex = 0;
    const cardsToShow = 3; // Number of cards visible at a time
    const campaignWrapper = document.querySelector(".campaign-wrapper");
    const campaignCards = Array.from(document.querySelectorAll(".campaign-card")); // Convert NodeList to Array

    function updateCardDisplay(direction = null) {
        const totalCards = campaignCards.length;
        const visibleCards = campaignCards.slice(currentIndex, currentIndex + cardsToShow);

        // Add animation classes based on the direction
        campaignCards.forEach((card, index) => {
            card.style.display = "none"; // Hide all cards initially
            card.classList.remove("slide-in-left", "slide-in-right"); // Reset animation classes
            if (visibleCards.includes(card)) {
                card.style.display = "block"; // Show visible cards
                if (direction === "next") card.classList.add("slide-in-right");
                if (direction === "prev") card.classList.add("slide-in-left");
            }
        });

        // Enable/Disable navigation arrows
        document.querySelector(".arrow-left").disabled = currentIndex === 0;
        document.querySelector(".arrow-right").disabled =
            currentIndex + cardsToShow >= totalCards;
    }

    function nextCards() {
        const totalCards = campaignCards.length;
        if (currentIndex + cardsToShow < totalCards) {
            currentIndex++;
            updateCardDisplay("next");
        }
    }

    function prevCards() {
        if (currentIndex > 0) {
            currentIndex--;
            updateCardDisplay("prev");
        }
    }

    // Initialize the card display
    updateCardDisplay();
</script>

<?php
include('includes/footer.php');
?>