<?php
include('admin/authentication.php');
include('includes/header.php');
include('includes/navbar.php');
?>

<style>
    .form-section {
        padding: 40px 0;
    }

    .campaign-container {
        max-width: 600px;
        margin: 30px auto;
        background-color: #ecebf3;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .campaign-header {
        text-align: center;
        padding: 10px 0;
        border-bottom: 2px solid #e5e5e5;
        margin-bottom: 10px;
        text-transform: uppercase;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .campaign-header h4 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #333333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 5px;
        color: #555555;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #cccccc;
        border-radius: 5px;
        background: #fafafa;
        font-size: 14px;
        color: #333333;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #457b9d;
        box-shadow: 0 0 5px rgba(69, 123, 157, 0.5);
    }

    .side-by-side {
        display: flex;
        gap: 20px;
        /* Adds spacing between the two items */
    }

    .input-item {
        flex: 1;
        /* Makes both input fields take up equal space */
    }

    .input-item label {
        display: block;
        font-weight: bold;
        font-size: 16px;
        color: #1d3557;
        margin-bottom: 5px;
    }

    .input-item input {
        font-size: 14px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        width: 100%;
        background-color: #f9f9f9;
    }

    .btn-block {
        display: block;
        margin: 20px auto 0;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        padding: 10px 16px;
        border-radius: 5px;
        width: 100%;
        cursor: pointer;
        background-color: #1d3557;
        color: #fff;
        border: 1px solid #fff;
        transition: all 0.3s ease;
    }

    .btn-block:hover {
        background-color: #fff;
        color: #000;
        border-color: #000;
    }

    .required {
        color: red;
        font-size: 12px;
    }

    .form-group span.note {
        display: block;
        font-size: 12px;
        color: #888888;
        margin-top: 5px;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .campaign-container {
            margin: 20px;
            padding: 15px;
        }

        .campaign-header h4 {
            font-size: 20px;
        }
    }
</style>

<section class="form-section">
    <div class="container mt-5">
        <?php include('message.php') ?>
        <div class="campaign-container">
            <div class="campaign-header">
                <h4>Create a Campaign</h4>
            </div>

            <form action="all_code.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <div class="side-by-side">
                        <div class="input-item">
                            <label for="campaign_title">Campaign Title <span style="color: red;">*</span></label>
                            <input type="text" id="campaign_title" name="campaign_title" required placeholder="Enter campaign title">
                        </div>

                        <div class="input-item">
                            <label for="campaign_location">Campaign Location <span style="color: red;">*</span></label>
                            <input type="text" id="campaign_location" name="campaign_location" required placeholder="Enter campaign location">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-item">
                        <label for="campaign_description">Description <span style="color: red;">*</span></label>
                        <textarea id="campaign_description" name="campaign_description" required placeholder="Describe your campaign..."></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <div class="side-by-side">
                        <div class="input-item">
                            <label for="campaign_goal">Fundraising Goal (in USD) <span style="color: red;">*</span></label>
                            <input type="number" id="campaign_goal" name="campaign_goal" required placeholder="Enter goal amount" min="1">
                        </div>

                        <div class="input-item">
                            <label for="campaign_category">Category <span style="color: red;">*</span></label>
                            <select id="campaign_category" name="campaign_category" required>
                                <option value="" disabled selected>Select a category</option>
                                <option value="Education">Education</option>
                                <option value="Health">Health</option>
                                <option value="Disaster Relief">Disaster Relief</option>
                                <option value="Environment">Environment</option>
                            </select>
                        </div>
                    </div>
                </div>


                <div class="form-group">
                    <div class="side-by-side">
                        <div class="input-item">
                            <label for="start_date">Start Date <span style="color: red;">*</span></label>
                            <input type="date" id="start_date" name="start_date" required>
                        </div>

                        <div class="input-item">
                            <label for="end_date">End Date <span style="color: red;">*</span></label>
                            <input type="date" id="end_date" name="end_date" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-item">
                        <label for="campaign_image">Upload Campaign Image <span style="color: red;">*</span></label>
                        <input type="file" id="campaign_image" name="campaign_image" required accept="image/*">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-item">
                        <label for="organizer_name">Organizer Name <span style="color: red;">*</span></label>
                    </div>
                    <div class="side-by-side">
                        <div class="input-item">
                            <input type="text" id="first_name" name="first_name" required placeholder="Enter First Name">
                        </div>
                        <div class="input-item">
                            <input type="text" id="last_name" name="last_name" required placeholder="Enter Last Name">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="side-by-side">
                        <div class="input-item">
                            <label for="organizer_contact">Contact Number <span style="color: red;">*</span></label>
                            <input type="tel" id="organizer_contact" name="organizer_contact" required placeholder="Enter your contact number">
                        </div>
                        <div class="input-item">
                            <label for="organizer_email_address">Email Address <span style="color: red;">*</span></label>
                            <input type="email" id="organizer_email_address" name="organizer_email_address" required placeholder="Enter your email address">
                        </div>
                    </div>
                </div>

                <button type="submit" name="create_campaign_btn" class="btn-block">Create Campaign</button>
            </form>
        </div>
    </div>
</section>

<?php
include('includes/footer.php');
?>