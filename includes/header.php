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

    <style>
        /* Custom Styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            overflow-x: hidden;
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

</head>


<!-- Loader -->
<div id="loader">
    <div class="spinner"></div>
</div>