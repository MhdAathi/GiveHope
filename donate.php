<?php
include('admin/authentication.php');
include('includes/header.php');
include('includes/navbar.php');

// Get the campaign ID from the URL
$campaign_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($campaign_id) {
    // Fetch the campaign details from the database
    $query = "SELECT * FROM campaigns WHERE id = '$campaign_id' AND status = 'Accepted'";
    $query_run = mysqli_query($con, $query);

    if ($query_run && mysqli_num_rows($query_run) > 0) {
        $campaign = mysqli_fetch_assoc($query_run);
        // Calculate progress
        $progress = ($campaign['raised'] / $campaign['goal']) * 100;
    } else {
        echo "<section><p>Campaign not found or unavailable.</p></section>";
        exit;
    }
} else {
    echo "<section><p>No campaign selected for donation.</p></section>";
    exit;
}
?>

<style>
    /* Navbar Fix */
    .navbar {
        width: 100%;
        box-sizing: border-box;
        position: relative;
        z-index: 1000;
    }

    .main-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 40px 0px;
        gap: 20px;
    }

    .campaign-details {
        flex: 1.5;
        background-color: #ecebf3;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 800px;
    }

    .campaign-details h2 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }
    
    .campaign-image {
        width: 100%;
        max-height: 500px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .campaign-info {
        margin-bottom: 20px;
    }

    .side-by-side {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .side-by-side .left {
        text-align: left;
        flex: 1;
    }

    .side-by-side .right {
        text-align: right;
        flex: 1;
    }

    .progress-container {
        margin-top: 20px;
    }

    .progress-bar {
        height: 10px;
        border-radius: 5px;
        background-color: #ddd;
        overflow: hidden;
    }

    .progress-bar span {
        display: block;
        height: 100%;
        background-color: #4CAF50;
        width: <?= round($progress, 2); ?>%;
    }

    .progress-text {
        font-size: 14px;
        color: #4CAF50;
        margin-top: 5px;
        text-align: right;
    }

    .payment-section {
        flex: 1;
        background-color: #ecebf3;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        max-width: 500px;
    }

    .payment-section h4 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        margin-bottom: 15px;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-size: 14px;
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #fff;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #4CAF50;
        outline: none;
    }

    .btn-submit {
        display: block;
        width: 100%;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: #1d3557;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        transition: background-color 0.3s ease;
    }

    .btn-submit:hover {
        background-color: #4CAF50;
    }
</style>

<div class="main-container">
    <!-- Campaign Details -->
    <div class="campaign-details">
        <h2><?= htmlspecialchars($campaign['title']); ?></h2>
        <img src="<?= htmlspecialchars($campaign['image']); ?>" alt="<?= htmlspecialchars($campaign['title']); ?>" class="campaign-image">
        <div class="campaign-info">
            <div class="side-by-side">
                <p class="left"><strong>Location:</strong> <?= htmlspecialchars($campaign['location']); ?></p>
                <p class="right"><strong>Category:</strong> <?= htmlspecialchars($campaign['category']); ?></p>
            </div>
            <div class="side-by-side">
                <p class="left"><strong>Amount Raised:</strong> LKR <?= number_format($campaign['raised'], 2); ?></p>
                <p class="right"><strong>Goal:</strong> LKR <?= number_format($campaign['goal'], 2); ?></p>
            </div>
            <p><strong>Description:</strong> <?= htmlspecialchars($campaign['description']); ?></p>
        </div>
        <div class="progress-container">
            <div class="progress-bar">
                <span></span>
            </div>
            <div class="progress-text"><?= round($progress, 2); ?>% of Goal</div>
        </div>
    </div>

    <!-- Payment Section -->
    <div class="payment-section">
        <h4>Payment Details</h4>
        <form action="process_payment.php" method="POST">
            <div class="form-group">
                <label>Payment Type <span style="color: red;">*</span></label>
                <div class="side-by-side">
                    <div>
                        <input type="radio" id="credit_card" name="payment_type" value="credit_card" checked>
                        <label for="credit_card">Credit Card</label>
                    </div>
                    <div>
                        <input type="radio" id="paypal" name="payment_type" value="paypal">
                        <label for="paypal">PayPal</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="card_number">Card Number <span style="color: red;">*</span></label>
                <input type="text" id="card_number" name="card_number" placeholder="Enter your card number" required>
            </div>

            <div class="side-by-side">
                <div class="form-group">
                    <label for="security_code">Security Code (CVV) <span style="color: red;">*</span></label>
                    <input type="text" id="security_code" name="security_code" placeholder="Enter CVV" required>
                </div>
                <div class="form-group">
                    <label for="expiration_month">Expiration Month <span style="color: red;">*</span></label>
                    <select id="expiration_month" name="expiration_month" required>
                        <option value="" disabled selected>MM</option>
                        <option value="01">January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="expiration_year">Expiration Year <span style="color: red;">*</span></label>
                    <select id="expiration_year" name="expiration_year" required>
                        <option value="" disabled selected>YYYY</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="name_on_card">Name on Card <span style="color: red;">*</span></label>
                <input type="text" id="name_on_card" name="name_on_card" placeholder="Enter the name on the card" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address <span style="color: red;">*</span></label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="address_line">Address, Line 1 <span style="color: red;">*</span></label>
                <input type="text" id="address_line" name="address_line" required placeholder="Enter your address">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="Enter your phone number">
            </div>

            <button type="submit" class="btn-submit">Pay</button>
        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>