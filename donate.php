<?php
include('admin/authentication.php');
include('includes/header.php');
include('includes/navbar.php');

// Get the campaign ID from the URL
$campaign_id = isset($_GET['id']) ? $_GET['id'] : null;

if ($campaign_id) {
    $stmt = $con->prepare("SELECT * FROM campaigns WHERE id = ? AND status = 'Accepted'");
    $stmt->bind_param("i", $campaign_id); // "i" means integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $campaign = $result->fetch_assoc();
        $progress = ($campaign['raised'] / $campaign['goal']) * 100;
    } else {
        $_SESSION['message'] = "Campaign not found or unavailable.";
        header("Location: index.php");
        exit(0);
    }
} else {
    $_SESSION['message'] = "No campaign selected for donation.";
    header("Location: index.php");
    exit(0);
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

    /* Refined Side-By-Side Layout */
    .side-by-side {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        /* Adds space between elements */
        margin-bottom: 15px;
        /* Adds margin to the bottom */
    }

    /* Left Section of Side-by-Side */
    .side-by-side .left {
        flex: 1;
        /* Allows left section to take available space */
        text-align: left;
    }

    /* Right Section of Side-by-Side */
    .side-by-side .right {
        flex: 1;
        /* Allows right section to take available space */
        text-align: right;
    }

    /* Optional: Adjust for smaller screens */
    @media (max-width: 768px) {
        .side-by-side {
            flex-direction: column;
            /* Stack elements vertically on smaller screens */
            align-items: flex-start;
            /* Align them to the left */
        }

        .side-by-side .left,
        .side-by-side .right {
            text-align: left;
            width: 100%;
            /* Make each section take full width */
        }
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
        font-size: 13px;
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        font-size: 12px;
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

    /* Modern Radio Button Styles */
    .radio-group {
        display: flex;
        gap: 25px;
        align-items: center;
    }

    .radio-group input[type="radio"] {
        display: none;
    }

    .radio-group label {
        position: relative;
        display: inline-block;
        padding-left: 25px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        color: #333;
    }

    .radio-group label::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #ecebf3;
        border: 2px solid #ddd;
        transition: all 0.3s ease;
    }

    .radio-group input[type="radio"]:checked+label::before {
        background-color: #1d3557;
        border-color: #1d3557;
    }

    .radio-group input[type="radio"]:checked+label::after {
        content: "";
        position: absolute;
        left: 5px;
        top: 5px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: white;
    }

    .radio-group label:hover::before {
        background-color: #f5f5f5;
        border-color: #888;
    }
</style>

<div class="mt-5">
    <?php include('message.php'); ?>
</div>

<div class="main-container">
    <!-- Campaign Details -->
    <div class="campaign-details">
        <input type="hidden" name="campaign_id" value="<?= htmlspecialchars($campaign['id']); ?>">
        <h2><?= htmlspecialchars($campaign['title']); ?></h2>
        <img src="<?= htmlspecialchars($campaign['image']); ?>" alt="<?= htmlspecialchars($campaign['title']); ?>"
            class="campaign-image">
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

        <!-- Progress Bar -->
        <div class="progress-container">
            <div class="progress-bar">
                <span style="width: <?= round($progress, 2); ?>%;"></span>
            </div>
            <div class="progress-text"><?= round($progress, 2); ?>% Raised</div>
        </div>
    </div>

    <!-- Payment Section -->
    <div class="payment-section">
        <h4>Payment Details</h4>
        <form action="all_code.php" method="POST">
            <input type="hidden" name="campaign_id" value="<?= htmlspecialchars($campaign['id']); ?>">
            <!-- Payment Amount Selection -->
            <div class="form-group">
                <label>Select Payment Amount <span style="color: red;">*</span></label>
                <div class="radio-group">
                    <input type="radio" id="amount_1000" name="payment_amount" value="1000"
                        onclick="updateAmount(1000)">
                    <label for="amount_1000">1000</label>

                    <input type="radio" id="amount_2000" name="payment_amount" value="2000"
                        onclick="updateAmount(2000)">
                    <label for="amount_2000">2000</label>

                    <input type="radio" id="amount_5000" name="payment_amount" value="5000"
                        onclick="updateAmount(5000)">
                    <label for="amount_5000">5000</label>

                    <input type="radio" id="amount_custom" name="payment_amount" value="custom"
                        onclick="enableCustomAmount()">
                    <label for="amount_custom">Other</label>
                </div>
            </div>

            <div class="form-group">
                <label for="amount_display">Amount to Pay</label>
                <input type="text" id="amount_display" name="amount" readonly
                    placeholder="Amount will be displayed here">
            </div>

            <!-- Custom Amount Input -->
            <div class="form-group" id="custom_amount_group" style="display: none;">
                <label for="custom_amount">Enter Custom Amount</label>
                <input type="number" id="custom_amount" name="custom_amount" placeholder="Enter custom amount"
                    oninput="updateAmountFromInput()" min="1">
            </div>

            <!-- Payment Type Selection -->
            <div class="form-group">
                <label>Payment Type <span style="color: red;">*</span></label>
                <div class="radio-group">
                    <div>
                        <input type="radio" id="credit_card" name="payment_type" value="credit_card">
                        <label for="credit_card">Credit Card</label>
                    </div>
                    <div>
                        <input type="radio" id="paypal" name="payment_type" value="paypal">
                        <label for="paypal">PayPal</label>
                    </div>
                </div>
            </div>

            <!-- Credit Card Details -->
            <div id="credit_card_details">
                <div class="form-group">
                    <label for="card_number">Card Number <span style="color: red;">*</span></label>
                    <input type="text" id="card_number" name="card_number" placeholder="1234 5678 9876 5432" required>
                </div>

                <div class="side-by-side">
                    <div class="form-group">
                        <label for="security_code">Security Code (CVV) <span style="color: red;">*</span></label>
                        <input type="text" id="security_code" name="security_code" placeholder="123" required>
                    </div>
                    <div class="form-group">
                        <label for="expiration_month">Expiration Month <span style="color: red;">*</span></label>
                        <select id="expiration_month" name="expiration_month" required>
                            <option value="" disabled selected>MM</option>
                            <option value="01">01</option>
                            <option value="02">02</option>
                            <option value="03">03</option>
                            <option value="04">04</option>
                            <option value="05">05</option>
                            <option value="06">06</option>
                            <option value="07">07</option>
                            <option value="08">08</option>
                            <option value="09">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
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
                            <option value="2028">2028</option>
                            <option value="2029">2029</option>
                            <option value="2030">2030</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name_on_card">Name on Card <span style="color: red;">*</span></label>
                    <input type="text" id="name_on_card" name="name_on_card" placeholder="Enter the name on the card"
                        required>
                </div>
            </div>

            <!-- PayPal Details -->
            <div id="paypal_details" style="display: none;">
                <div class="form-group">
                    <label for="name">Name <span style="color: red;">*</span></label>
                    <input type="text" id="name" name="name" placeholder="Enter your Name">
                </div>
                <div class="form-group">
                    <label for="paypal_email">PayPal Email <span style="color: red;">*</span></label>
                    <input type="email" id="paypal_email" name="paypal_email" placeholder="Enter your PayPal email">
                </div>
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
                <label for="province">Province <span style="color: red;">*</span></label>
                <select id="province" name="province" class="form-control" required onchange="updateDistricts()">
                    <option value="" disabled selected>Select Province</option>
                    <option value="Western">Western</option>
                    <option value="Central">Central</option>
                    <option value="Southern">Southern</option>
                    <option value="Northern">Northern</option>
                    <option value="Eastern">Eastern</option>
                    <option value="North Western">North Western</option>
                    <option value="North Central">North Central</option>
                    <option value="Uva">Uva</option>
                    <option value="Sabaragamuwa">Sabaragamuwa</option>
                </select>
            </div>

            <div class="form-group">
                <label for="district">District <span style="color: red;">*</span></label>
                <select id="district" name="district" class="form-control" required>
                    <option value="" disabled selected>Select District</option>
                    <!-- District options will be populated dynamically -->
                </select>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" id="phone" name="phone" placeholder="Enter your phone number">
            </div>

            <button type="submit" class="btn-submit" name="btn-submit">Pay</button>
        </form>
    </div>

    <script>
        // Format the card number (e.g., 1234 5678 9012 3456)
        document.getElementById("card_number").addEventListener("input", function(event) {
            let cardNumber = event.target.value.replace(/\D/g, ''); // Remove all non-digits
            event.target.value = cardNumber.replace(/(\d{4})(?=\d)/g, '$1 '); // Add space every 4 digits
        });

        // CVV Validation: Restrict to 3-4 digits only
        document.getElementById("security_code").addEventListener("input", function(event) {
            let cvv = event.target.value.replace(/\D/g, ''); // Remove non-digits
            event.target.value = cvv.slice(0, 4); // Limit to 4 digits
        });

        // Function to toggle payment method details and disable unused fields
        function togglePaymentDetails() {
            const paymentType = document.querySelector('input[name="payment_type"]:checked').value;

            if (paymentType === 'credit_card') {
                document.getElementById('credit_card_details').style.display = 'block';
                document.getElementById('paypal_details').style.display = 'none';

                // Enable Credit Card fields
                document.getElementById('card_number').disabled = false;
                document.getElementById('expiration_month').disabled = false;
                document.getElementById('expiration_year').disabled = false;
                document.getElementById('security_code').disabled = false;
                document.getElementById('name_on_card').disabled = false;

                // Disable PayPal fields
                document.getElementById('paypal_email').disabled = true;
            } else if (paymentType === 'paypal') {
                document.getElementById('credit_card_details').style.display = 'none';
                document.getElementById('paypal_details').style.display = 'block';

                // Enable PayPal fields
                document.getElementById('paypal_email').disabled = false;

                // Disable Credit Card fields
                document.getElementById('card_number').disabled = true;
                document.getElementById('expiration_month').disabled = true;
                document.getElementById('expiration_year').disabled = true;
                document.getElementById('security_code').disabled = true;
                document.getElementById('name_on_card').disabled = true;
            }
        }

        // Validate Credit Card Details
        function validateCardDetails() {
            const cardNumber = document.getElementById("card_number").value.replace(/\s/g, '');
            const securityCode = document.getElementById("security_code").value;
            const expirationMonth = document.getElementById("expiration_month").value;
            const expirationYear = document.getElementById("expiration_year").value;
            const nameOnCard = document.getElementById("name_on_card").value.trim();

            const cardNumberRegex = /^\d{16}$/; // 16-digit card number
            const cvvRegex = /^\d{3,4}$/; // 3 or 4 digits for CVV

            if (!cardNumberRegex.test(cardNumber)) {
                alert("Invalid Card Number. Please enter a 16-digit card number.");
                return false;
            }

            if (!cvvRegex.test(securityCode)) {
                alert("Invalid CVV. Please enter a 3 or 4 digit security code.");
                return false;
            }

            if (!expirationMonth || !expirationYear) {
                alert("Please select a valid expiration date.");
                return false;
            }

            if (nameOnCard === "") {
                alert("Please enter the name on the card.");
                return false;
            }

            return true;
        }

        // Validate PayPal Details
        function validatePayPalDetails() {
            const paypalEmail = document.getElementById("paypal_email").value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email validation

            if (!emailRegex.test(paypalEmail)) {
                alert("Invalid PayPal email. Please enter a valid email address.");
                return false;
            }
            return true;
        }

        // Validate the selected payment method before submission
        document.querySelector("form").addEventListener("submit", function(event) {
            const paymentType = document.querySelector('input[name="payment_type"]:checked').value;

            let isValid = false;

            if (paymentType === "credit_card") {
                isValid = validateCardDetails(); // Validate credit card details
            } else if (paymentType === "paypal") {
                isValid = validatePayPalDetails(); // Validate PayPal email
            }

            if (!isValid) {
                event.preventDefault(); // Stop submission if validation fails
            }
        });

        // Attach event listeners for toggling payment method details
        window.onload = togglePaymentDetails;
        document.querySelectorAll('input[name="payment_type"]').forEach((elem) => {
            elem.addEventListener('change', togglePaymentDetails);
        });

        // Amount update functions
        function updateAmount(amount) {
            document.getElementById('amount_display').value = amount;
            document.getElementById('custom_amount_group').style.display = 'none';
        }

        function enableCustomAmount() {
            document.getElementById('amount_display').value = '';
            document.getElementById('custom_amount_group').style.display = 'block';
        }

        function updateAmountFromInput() {
            const customAmount = document.getElementById('custom_amount').value;
            document.getElementById('amount_display').value = customAmount;
        }

        const provinceDistricts = {
            "Western": ["Colombo", "Gampaha", "Kalutara"],
            "Central": ["Kandy", "Matale", "Nuwara Eliya"],
            "Southern": ["Galle", "Matara", "Hambantota"],
            "Northern": ["Jaffna", "Kilinochchi", "Mannar", "Vavuniya", "Mullaitivu"],
            "Eastern": ["Trincomalee", "Batticaloa", "Ampara"],
            "North Western": ["Kurunegala", "Puttalam"],
            "North Central": ["Anuradhapura", "Polonnaruwa"],
            "Uva": ["Badulla", "Monaragala"],
            "Sabaragamuwa": ["Ratnapura", "Kegalle"]
        };

        function updateDistricts() {
            const provinceSelect = document.getElementById("province");
            const districtSelect = document.getElementById("district");
            const selectedProvince = provinceSelect.value;

            // Clear existing district options
            districtSelect.innerHTML = '<option value="" disabled selected>Select District</option>';

            // Populate districts based on the selected province
            if (provinceDistricts[selectedProvince]) {
                provinceDistricts[selectedProvince].forEach(district => {
                    const option = document.createElement("option");
                    option.value = district;
                    option.textContent = district;
                    districtSelect.appendChild(option);
                });
            }
        }
    </script>


</div>
<?php include('includes/footer.php');
