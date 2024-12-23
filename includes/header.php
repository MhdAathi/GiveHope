<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>GiveHope - Campaign Donation System</title>

    <!-- Bootstrap Link CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap5.min.css">

    <!-- Custom Link CSS Files -->
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom Link Styles Files -->
    <link rel="stylesheet" href="assets/css/styles.css">
    <script defer src="assets/js/script.js"></script>

    <!-- Font Awesome for Icons -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Include Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Include Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        /* Main */
        /* Import Montserrat Font */
        @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700&display=swap");

        /* Global Styles */
        * {
            font-family: "Montserrat", sans-serif;
            box-sizing: border-box;
            margin: 0%;
            padding: 0%;
        }

        body {
            background: linear-gradient(to right, #1d3557, #457b9d);
        }

        h2 {
            font-size: 25px;
            font-weight: 600;
            color: #0C120C;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            text-align: center;
        }

        h4 {
            font-size: 35px;
            font-weight: 600;
            color: #0C120C;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            text-align: center;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
            margin-bottom: 20px;
            color: #0C120C;
        }

        /* Loader */
        #loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        #loader.hidden {
            opacity: 0;
            visibility: hidden;
        }

        .spinner {
            border: 5px solid #f3f3f3;
            border-top: 5px solid #1d3557;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

</head>


<!-- Loader
<div id="loader">
    <div class="spinner"></div>
</div> -->