<body>

    <style>
        /* Ensuring the body and html take up full height */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        /* Main wrapper to ensure content takes up remaining space */
        .main-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Content section should take up available space */
        .content {
            flex: 1;
        }

        /* Footer Styles */
        .footer {
            background-color: #0C120C;
            /* Secondary color */
            color: #ecebf3;
            /* Primary color for text */
            padding: 20px 0;
            text-align: center;
            /* Center the footer content */
        }

        .footer .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .footer .col-md-4 {
            flex-basis: 33.33%;
            padding: 20px;
        }

        .footer h5 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #ecebf3;
            /* Primary color for header */
        }

        .footer p {
            font-size: 14px;
            margin-bottom: 20px;
            color: rgba(236, 235, 243, 0.8);
            /* Slightly transparent for readability */
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 10px;
        }

        .footer-links a {
            color: #ecebf3;
            /* Primary color for links */
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: #0C120C;
            /* Neutral color on hover */
        }

        .social-icons {
            display: flex;
            justify-content: center;
            /* Center social icons */
        }

        .social-icons a {
            color: #ecebf3;
            /* Primary color for social icons */
            font-size: 18px;
            margin-right: 20px;
            transition: color 0.2s ease;
        }

        .social-icons a:hover {
            color: #0C120C;
            /* Neutral color on hover */
        }

        .copyright {
            background-color: #a0153e;
            /* Darker shade for copyright section */
            color: #ecebf3;
            /* Primary color for text */
            padding: 10px 0;
            text-align: center;
            font-size: 14px;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .footer .col-md-4 {
                flex-basis: 50%;
            }
        }

        @media (max-width: 480px) {
            .footer .col-md-4 {
                flex-basis: 100%;
            }
        }

        /* Animations */
        .footer-links a:hover {
            animation: link-hover 0.2s ease;
        }

        .social-icons a:hover {
            animation: social-hover 0.2s ease;
        }

        @keyframes link-hover {
            0% {
                color: #ecebf3;
                /* Primary color */
            }

            100% {
                color: #0C120C;
                /* Neutral color on hover */
            }
        }

        @keyframes social-hover {
            0% {
                color: #ecebf3;
                /* Primary color */
            }

            100% {
                color: #0C120C;
                /* Neutral color on hover */
            }
        }
    </style>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- Contact Information -->
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <p>
                        <i class="fas fa-map-marker-alt"></i> 123 GiveHope St, City, Country<br>
                        <i class="fas fa-phone"></i> +123 456 7890<br>
                        <i class="fas fa-envelope"></i> contact@givehope.com
                    </p>
                </div>
                <!-- Quick Links -->
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <div class="footer-links">
                        <ul>
                            <li><a href="#">Home</a></li>
                            <li><a href="#">Donate</a></li>
                            <li><a href="#">Sign In</a></li>
                            <li><a href="#">About Us</a></li>
                        </ul>

                    </div>
                </div>
                <!-- Social Media Icons -->
                <div class="col-md-4">
                    <h5>Follow Us</h5>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <p class="mt-4">© 2024 GiveHope - Campaign Donation Management. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/boostrap5.bundle.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
        window.onload = () => {
            setTimeout(() => {
                document.getElementById('loader').classList.add('hidden');
            }, 2000);
        };

        // Navbar Scroll Effect
        window.onscroll = () => {
            let navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        };
    </script>

</body>

</html>

<body>