<style>
    /* Navbar */
    .navbar {

        /* Increased blur for a more modern feel */
        transition: background-color 0.3s ease;
        -webkit-box-shadow: -1.5px 5.5px 10.5px -2px #d5bfbf;
        -moz-box-shadow: -1.5px 5.5px 10.5px -2px #d5bfbf;
        box-shadow: -1.5px 5.5px 10.5px -2px #d5bfbf;
        background: rgba(255, 255, 255, 0.7);
        -webkit-backdrop-filter: blur(13px);
        backdrop-filter: blur(13px);
        border: 1px solid rgba(255, 255, 255, 0.35);

    }

    .navbar.scrolled {
        background-color: rgba(255, 255, 255, 1);
        /* Fully opaque when scrolled */
    }

    .navbar .navbar-brand {
        color: #000;
        font-size: 26px;
        /* Slightly smaller font size for a cleaner look */
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 2px;
        transition: color 0.3s ease;
    }

    .navbar .navbar-brand:focus,
    .navbar .navbar-brand:hover {
        color: #1D3557;
        /* Bright red for hover */
    }

    .navbar .navbar-nav .nav-link {
        color: #333;
        font-size: 14px;
        font-weight: 500;
        margin-right: 15px;
        text-transform: capitalize;
        position: relative;
        transition: color 0.3s ease;
    }

    .navbar .navbar-nav .nav-link:focus,
    .navbar .navbar-nav .nav-link:hover {
        color: #1D3557;
        /* Hover color */
    }

    /* Underline animation on hover */
    .navbar .navbar-nav .nav-link:after {
        content: '';
        display: block;
        width: 0;
        height: 2px;
        background: #1D3557;
        transition: width 0.3s;
        position: absolute;
        bottom: -5px;
        left: 0;
    }

    .navbar .navbar-nav .nav-link:hover:after {
        width: 100%;
    }

    /* Get Started Button */
    .navbar .getstarted {
        background: linear-gradient(90deg, #1D3557, #457B9D);
        margin-left: 30px;
        border-radius: 30px;
        font-weight: 600;
        color: #fff;
        text-decoration: none;
        padding: 0.5rem 1.5rem;
        line-height: 2.3;
        transition: background 0.3s ease, box-shadow 0.3s ease;
        white-space: nowrap;
    }

    .navbar .getstarted:hover {
        background: linear-gradient(90deg, #457B9D, #1D3557);
        box-shadow: 0 8px 15px rgba(29, 53, 87, 0.2);
    }

    /* Navbar Toggler */
    .navbar-toggler {
        padding: 8px 10px;
        font-size: 18px;
        background: rgba(0, 0, 0, 0.8);
        color: #fff;
        border: none;
        transition: background 0.3s ease;
    }

    .navbar-toggler:focus,
    .navbar-toggler:hover {
        background: rgba(69, 123, 157, 0.5);
    }

    .w-100 {
        height: 50vh;
    }

    /* Mobile Styles */
    @media (max-width: 991px) {
        .navbar .navbar-nav {
            text-align: center;
        }

        .navbar .navbar-nav .nav-link {
            margin-bottom: 10px;
        }
    }
</style>

<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="pics/5.png" alt="">
            GiveHope
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav ">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Donate</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Campaigns</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Volunteer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link cta-button" href="#">Sign Up</a>
                </li>
            </ul>
        </div>
    </div>
</nav>