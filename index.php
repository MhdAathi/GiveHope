<?php
session_start();
include('admin/config/dbcon.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<style>
    /* Enable smooth scrolling across the page */
    .navbar {
        width: 100%;
        box-sizing: border-box;
        position: relative;
        z-index: 1000;
    }

    html {
        scroll-behavior: smooth;
    }

    /* Hero Section */
    .hero {
        background: linear-gradient(to right, #1d3557, #457b9d);
        color: white;
        text-align: center;
        padding: 150px 0;
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

    .see-more {
        display: inline-block;
        font-size: 14px;
        color: #1d3557;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    /* Feedback Section */
    .feedback {
        background: linear-gradient(to right, #1d3557, #457b9d);
        padding: 30px 0;
        text-align: center;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    }

    .feedback img {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feedback img:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .feedback h2 {
        color: white;
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    }

    .feedback p {
        color: #0C120C;
        font-size: 20px;
        margin-bottom: 40px;
    }

    .feedback form {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feedback form:hover {
        transform: translateY(-8px);
    }

    .feedback .form-group {
        margin-bottom: 15px;
    }

    .feedback input,
    .feedback textarea {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        font-size: 16px;
        transition: border-color 0.3s;
        width: 100%;
    }

    .feedback input:focus,
    .feedback textarea:focus {
        border-color: #1d3557;
        outline: none;
    }

    .feedback button {
        background-color: #1d3557;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        font-size: 16px;
        cursor: pointer;
    }

    .feedback button:hover {
        background-color: #fff;
        color: black;
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

    /* Slide In Right Animation */
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
    /* Slide In Left Animation */
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

    /* Apply Animation to Cards */
    /* Classes Added Dynamically in JS */
    .slide-in-right {
        animation-name: slideInRight;
    }

    .slide-in-left {
        animation-name: slideInLeft;
    }

    /* Testimonials Section */
    .testimonials {
        background-color: #f8f8f8;
        padding: 60px 0;
        text-align: center;
    }

    .testimonials h2 {
        font-size: 2.5rem;
        color: #1d3557;
        margin-bottom: 60px;
    }

    .testimonials-wrapper {
        display: flex;
        justify-content: center;
        gap: 60px;
        flex-wrap: wrap;
    }

    .testimonial-card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 320px;
        padding: 20px;
        position: relative;
        text-align: left;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .testimonial-header {
        position: absolute;
        top: -40px;
        left: 20px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #f1f1f1;
        overflow: hidden;
        border: 5px solid #fff;
    }

    .person-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .testimonial-body {
        margin-top: 40px;
    }

    .client-name {
        font-size: 1.2rem;
        font-weight: bold;
        color: #1d3557;
        margin: 10px 0 5px;
    }

    .client-role {
        font-size: 0.9rem;
        color: #777;
        margin-bottom: 15px;
    }

    .testimonial-text {
        font-size: 1rem;
        color: #555;
        line-height: 1.6;
    }

    .testimonial-footer {
        margin-top: 10px;
        text-align: center;
    }

    .stars {
        font-size: 1.5rem;
        color: #ff7f50;
        letter-spacing: 2px;
    }

    .about-us {
        background: linear-gradient(to left, #1d3557, #457b9d);
        padding: 60px 0;
    }

    .about-us h2 {
        font-size: 2.5rem;
        color: #f1f1f1;
        text-align: center;
        margin-bottom: 30px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
    }

    .about-us p {
        font-size: 1.2rem;
        text-shadow: 1px 1px 6px rgba(0, 0, 0, 0.3);
        text-align: center;
        margin-bottom: 40px;
    }

    .about-us-cards {
        display: flex;
        justify-content: center;
        gap: 40px;
    }

    .about-us-card {
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        width: 250px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .about-us-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    .about-us-card h3 {
        font-size: 1.6rem;
        color: #1d3557;
        margin-top: 20px;
        margin-bottom: 15px;
    }

    .about-us-card p {
        font-size: 1rem;
        color: #666;
    }

    /* Image styles */
    .about-img {
        display: flex;
        justify-content: center;
    }

    .about-img img {
        max-width: 50%;
        width: 100%;
        height: auto;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
</style>

<div class="mt-3 mb-3" style="justify-content: center; margin: 20px auto;">
    <?php include('message.php'); ?>
</div>

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
            <?php
                }
            } else {
                echo "<p>No campaigns available at the moment.</p>";
            }
            ?>
        </div>
        <button class="arrow-right" onclick="nextCards()">→</button>

    </div>
    <div style="text-align: center; margin-top: 25px;">
        <a href="all_campaigns.php" class="btn-see-more">See More Campaigns</a>
    </div>
</section>

<!-- How It Works Section -->
<section class="how-it-works">
    <div class="container text-center">
        <h4>How it Works</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="icon">
                    <i class="bi bi-lightbulb"></i>
                </div>
                <h2>Create Campaign</h2>
                <p>Create your campaign and tell your story.</p>
            </div>
            <div class="col-md-4">
                <div class="icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <h2>Donate</h2>
                <p>Support the cause by donating money.</p>
            </div>
            <div class="col-md-4">
                <div class="icon">
                    <i class="bi bi-people"></i>
                </div>
                <h2>Make a Difference</h2>
                <p>Your donation helps those in need.</p>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="about-us" id="about-us-section">
    <div class="container">
        <h2>About Us</h2>
        <p>We are a dedicated platform committed to making a positive impact by supporting global campaigns and bringing people together for a common cause. Our mission is to create a community that empowers individuals to make meaningful contributions to the world.</p>
        <div class="about-us-cards">
            <div class="about-us-card">
                <div class="about-img">
                    <img src="assets\images\goal.png" alt="Our Mission">
                </div>
                <h3>Our Mission</h3>
                <p>To support campaigns that create sustainable change.</p>
            </div>
            <div class="about-us-card">
                <div class="about-img">
                    <img src="assets\images\target.png" alt="Our Vision">
                </div>
                <h3>Our Vision</h3>
                <p>To be a leading platform for social change through collaboration and giving.</p>
            </div>
            <div class="about-us-card">
                <div class="about-img">
                    <img src="assets\images\binoculars.png" alt="Our Values">
                </div>
                <h3>Our Values</h3>
                <p>Transparency, integrity, and community-driven efforts.</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="testimonials" id="testimonials-section">
    <div class="container">
        <h2>What People Are Saying</h2>
        <div class="testimonials-wrapper">
            <!-- Testimonial Card 1 -->
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="assets/images/person01.jpg" alt="Person 1" class="person-image">
                </div>
                <div class="testimonial-body">
                    <h3 class="client-name">Sarah L.</h3>
                    <p class="client-role">Campaign Creator</p>
                    <p class="testimonial-text">
                        "This platform gave me the opportunity to bring awareness to my cause and receive support from people worldwide. It's an amazing way to create change!"
                    </p>
                </div>
                <div class="testimonial-footer">
                    <div class="stars">
                        ★★★★★
                    </div>
                </div>
            </div>

            <!-- Testimonial Card 2 -->
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="assets/images/person02.jpg" alt="Person 2" class="person-image">
                </div>
                <div class="testimonial-body">
                    <h3 class="client-name">John D.</h3>
                    <p class="client-role">Donor</p>
                    <p class="testimonial-text">
                        "I donated to a campaign that truly made a difference. It was simple, quick, and I felt like my contribution mattered. Highly recommend!"
                    </p>
                </div>
                <div class="testimonial-footer">
                    <div class="stars">
                        ★★★★☆
                    </div>
                </div>
            </div>

            <!-- Testimonial Card 3 -->
            <div class="testimonial-card">
                <div class="testimonial-header">
                    <img src="assets/images/person03.jpg" alt="Person 3" class="person-image">
                </div>
                <div class="testimonial-body">
                    <h3 class="client-name">Emily R.</h3>
                    <p class="client-role">Supporter</p>
                    <p class="testimonial-text">
                        "The community here is fantastic! I love seeing the impact of donations and how the platform keeps everyone engaged."
                    </p>
                </div>
                <div class="testimonial-footer">
                    <div class="stars">
                        ★★★★★
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Feedback starts -->
<section class="feedback section-padding mb-3" id="feedback">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-header text-center">
                    <h2>We Value Your Feedback</h2>
                    <p>Your thoughts matter to us! Share your feedback to help us improve.</p>
                </div>
            </div>
        </div>
        <div class="row m-0 align-items-stretch">
            <!-- Image Column -->
            <div class="col-md-6 p-1 text-center">
                <img src="assets/images/feedback.jpeg" class="img-fluid feedback-image" alt="Feedback Image">
            </div>
            <!-- Form Column -->
            <div class="col-md-6 p-1">
                <form action="all_code.php" method="POST" class="bg-light p-4 feedback-form">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" required placeholder="Your Full Name">
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" required placeholder="Your Email Address">
                    </div>
                    <div class="form-group">
                        <textarea name="feedback" rows="5" required class="form-control" placeholder="Your Feedback"></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning btn-sm" name="btn-feedback">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Feedback ends -->


<script>
    let currentIndex = 0;
    const cardsToShow = 3; // Number of cards visible at a time
    const campaignWrapper = document.querySelector(".campaign-wrapper");
    const campaignCards = Array.from(document.querySelectorAll(".campaign-card")); // Convert NodeList to Array

    function updateCardDisplay(direction = "") {
        const totalCards = campaignCards.length;

        // Add animation classes based on direction
        campaignCards.forEach((card, index) => {
            card.classList.remove("slide-in-left", "slide-in-right"); // Reset animation
            card.style.display = "none"; // Hide all cards initially
            if (index >= currentIndex && index < currentIndex + cardsToShow) {
                card.style.display = "block"; // Show current cards
                if (direction === "next") card.classList.add("slide-in-right");
                if (direction === "prev") card.classList.add("slide-in-left");
            }
        });

        // Enable/Disable navigation arrows
        document.querySelector(".arrow-left").disabled = currentIndex === 0;
        document.querySelector(".arrow-right").disabled = currentIndex + cardsToShow >= totalCards;
    }

    function nextCards() {
        const totalCards = campaignCards.length;
        if (currentIndex + cardsToShow < totalCards) {
            currentIndex += cardsToShow;
            updateCardDisplay("next");
        }
    }

    function prevCards() {
        if (currentIndex > 0) {
            currentIndex -= cardsToShow;
            updateCardDisplay("prev");
        }
    }

    // Initialize the card display
    updateCardDisplay();
</script>

<?php
include('includes/footer.php');
?>