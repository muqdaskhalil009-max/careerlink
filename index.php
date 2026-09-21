
<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>CareerLink | Jobs & Internships</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fb;
            color: #172033;
        }

        /* Navbar */

        .navbar {
            background: linear-gradient(
                135deg,
                #0b1f3a,
                #123f73
            );
            padding: 15px 0;
        }

        .navbar-brand {
            font-size: 23px;
            letter-spacing: 0.3px;
        }

        .brand-icon {
            color: #5bbcff;
            margin-right: 8px;
        }

        .navbar .nav-link {
            color: rgba(255,255,255,0.85);
            margin-left: 12px;
            transition: 0.3s;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link.active {
            color: #ffffff;
        }

        .nav-register {
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 8px;
            padding: 7px 16px !important;
        }

        .nav-register:hover {
            background-color: rgba(255,255,255,0.1);
        }


        /* Hero */

        .hero {
            background:
                linear-gradient(
                    135deg,
                    #0b1f3a,
                    #123f73,
                    #1769aa
                );

            color: white;
            padding: 95px 20px 105px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: "";
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: rgba(91,188,255,0.10);
            top: -140px;
            right: -80px;
        }

        .hero::after {
            content: "";
            position: absolute;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            bottom: -120px;
            left: -80px;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 900px;
            margin: auto;
        }

        .hero-badge {
            display: inline-block;
            background: rgba(255,255,255,0.10);
            border: 1px solid rgba(255,255,255,0.18);
            padding: 8px 16px;
            border-radius: 30px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .hero h1 {
            font-size: 52px;
            font-weight: 700;
            line-height: 1.15;
        }

        .hero p {
            font-size: 19px;
            line-height: 1.7;
            max-width: 720px;
            margin: 20px auto 0;
            color: rgba(255,255,255,0.88);
        }

        .hero-buttons {
            margin-top: 32px;
        }

        .btn-hero-primary {
            background-color: white;
            color: #123f73;
            border: none;
            padding: 12px 25px;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-hero-primary:hover {
            background-color: #f1f5f9;
            color: #0b1f3a;
        }

        .btn-hero-outline {
            color: white;
            border: 1px solid rgba(255,255,255,0.6);
            padding: 12px 25px;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-hero-outline:hover {
            background-color: rgba(255,255,255,0.1);
            color: white;
        }


        /* Section */

        .section-title {
            font-weight: 700;
            color: #172033;
        }

        .section-subtitle {
            color: #6b7280;
            max-width: 650px;
            margin: 10px auto 0;
        }


        /* Feature Cards */

        .feature-card {
            background-color: white;
            border: 1px solid #e5eaf1;
            border-radius: 14px;
            transition: 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(11,31,58,0.10);
        }

        .feature-icon {
            width: 58px;
            height: 58px;
            border-radius: 12px;
            background-color: #eaf4fc;
            color: #1769aa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            margin: 0 auto;
        }

        .feature-card h4 {
            color: #172033;
            font-weight: 600;
        }

        .feature-card p {
            color: #6b7280;
            line-height: 1.7;
        }


        /* Portal Section */

        .portal-section {
            background-color: white;
        }

        .portal-card {
            border-radius: 15px;
            padding: 35px;
            height: 100%;
            border: 1px solid #e4eaf2;
        }

        .portal-card.job-seeker {
            background: linear-gradient(
                135deg,
                #f5faff,
                #ffffff
            );
        }

        .portal-card.company {
            background: linear-gradient(
                135deg,
                #f7f9fc,
                #ffffff
            );
        }

        .portal-icon {
            font-size: 32px;
            color: #1769aa;
        }

        .portal-card h3 {
            font-weight: 700;
            margin-top: 15px;
        }

        .portal-card p {
            color: #6b7280;
            line-height: 1.7;
        }

        .portal-list {
            padding-left: 0;
            list-style: none;
        }

        .portal-list li {
            margin-bottom: 10px;
            color: #4b5563;
        }

        .portal-list i {
            color: #1769aa;
            margin-right: 8px;
        }


        /* CTA */

        .cta-section {
            background:
                linear-gradient(
                    135deg,
                    #0b1f3a,
                    #123f73
                );
            color: white;
        }

        .cta-section p {
            color: rgba(255,255,255,0.78);
        }

        .cta-button {
            background-color: white;
            color: #123f73;
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 600;
        }

        .cta-button:hover {
            background-color: #f1f5f9;
            color: #0b1f3a;
        }


        /* Footer */

        .footer {
            background-color: #0b1f3a;
            color: white;
            padding: 50px 0 20px;
        }

        .footer h5 {
            font-weight: 600;
        }

        .footer p {
            color: rgba(255,255,255,0.68);
            line-height: 1.7;
        }

        .footer a {
            color: rgba(255,255,255,0.72);
            text-decoration: none;
            transition: 0.3s;
        }

        .footer a:hover {
            color: white;
        }

        .footer-divider {
            border-color: rgba(255,255,255,0.15);
        }

        .footer-bottom {
            color: rgba(255,255,255,0.55);
            font-size: 14px;
        }


        /* Responsive */

        @media (max-width: 768px) {

            .hero {
                padding: 70px 20px 80px;
            }

            .hero h1 {
                font-size: 38px;
            }

            .hero p {
                font-size: 17px;
            }

            .hero-buttons .btn {
                display: block;
                width: 100%;
                margin: 10px 0 !important;
            }

            .portal-card {
                padding: 28px;
            }

        }
       .brand-logo {
    height: 48px;
    width: auto;
    display: block;
}

    </style>

</head>

<body>


<!-- =========================
     NAVIGATION
========================= -->

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">

       <a class="navbar-brand d-flex align-items-center" href="index.php">
    <i class="bi bi-briefcase-fill me-2"></i>
    CareerLink
</a>
        <!-- Mobile Menu Button -->
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="login.php">
                        Login
                    </a>
                </li>

                <li class="nav-item ms-lg-2">
                    <a class="btn btn-outline-light px-3"
                       href="register.php">
                        Register
                    </a>
                </li>

            </ul>

        </div>

    </div>
</nav>


<!-- =========================
     HERO
========================= -->

<section class="hero text-center">

    <div class="container">

        <div class="hero-content">

            <div class="hero-badge">
                <i class="bi bi-stars me-1"></i>
                Jobs & Internship Management Platform
            </div>

            <h1>
                Build Your Future with the Right Opportunity
            </h1>

            <p>
                CareerLink connects students and job seekers with
                jobs and internships while helping companies discover
                and manage talented candidates.
            </p>

            <div class="hero-buttons">

                <a
                    href="login.php"
                    class="btn btn-hero-primary btn-lg me-2"
                >
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Login
                </a>

                <a
                    href="register.php"
                    class="btn btn-hero-outline btn-lg"
                >
                    <i class="bi bi-person-plus me-2"></i>
                    Create Account
                </a>

            </div>

        </div>

    </div>

</section>


<!-- =========================
     FEATURES
========================= -->

<section class="py-5">

    <div class="container py-3">

        <div class="text-center mb-5">

            <h2 class="section-title">
                Everything You Need to Connect
            </h2>

            <p class="section-subtitle">
                CareerLink provides a simple platform for discovering
                opportunities, applying for positions and managing
                recruitment activities.
            </p>

        </div>


        <div class="row g-4">


            <!-- Feature 1 -->

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="card-body text-center p-4">

                        <div class="feature-icon">
                            <i class="bi bi-search"></i>
                        </div>

                        <h4 class="mt-4">
                            Discover Opportunities
                        </h4>

                        <p class="mt-3 mb-0">
                            Browse available jobs and internships and
                            search for opportunities that match your
                            interests and career goals.
                        </p>

                    </div>

                </div>

            </div>


            <!-- Feature 2 -->

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="card-body text-center p-4">

                        <div class="feature-icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>

                        <h4 class="mt-4">
                            Apply & Track
                        </h4>

                        <p class="mt-3 mb-0">
                            Submit applications for suitable positions
                            and keep track of your application status
                            from your account.
                        </p>

                    </div>

                </div>

            </div>


            <!-- Feature 3 -->

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="card-body text-center p-4">

                        <div class="feature-icon">
                            <i class="bi bi-building"></i>
                        </div>

                        <h4 class="mt-4">
                            Connect Companies
                        </h4>

                        <p class="mt-3 mb-0">
                            Companies can create opportunities,
                            manage job postings and review submitted
                            applications.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================
     PORTAL OPTIONS
========================= -->

<section class="portal-section py-5">

    <div class="container py-3">

        <div class="text-center mb-5">

            <h2 class="section-title">
                A Platform for Both Sides
            </h2>

            <p class="section-subtitle">
                Whether you are looking for an opportunity or hiring
                talent, CareerLink provides the tools you need.
            </p>

        </div>


        <div class="row g-4">


            <!-- Job Seeker -->

            <div class="col-md-6">

                <div class="portal-card job-seeker">

                    <i class="bi bi-person-workspace portal-icon"></i>

                    <h3>
                        For Job Seekers
                    </h3>

                    <p>
                        Create your profile, explore available
                        opportunities and manage your applications
                        through one convenient account.
                    </p>

                    <ul class="portal-list mt-4">

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Create and manage your profile
                        </li>

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Browse jobs and internships
                        </li>

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Apply with a cover letter
                        </li>

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Track application status
                        </li>

                    </ul>

                    <a
                        href="register.php"
                        class="btn btn-primary mt-3"
                    >
                        Get Started
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>

                </div>

            </div>


            <!-- Company -->

            <div class="col-md-6">

                <div class="portal-card company">

                    <i class="bi bi-building portal-icon"></i>

                    <h3>
                        For Companies
                    </h3>

                    <p>
                        Build your company profile, publish opportunities
                        and manage applications from potential candidates.
                    </p>

                    <ul class="portal-list mt-4">

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Create a company profile
                        </li>

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Post jobs and internships
                        </li>

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Edit and manage postings
                        </li>

                        <li>
                            <i class="bi bi-check-circle-fill"></i>
                            Review candidate applications
                        </li>

                    </ul>

                    <a
                        href="register.php"
                        class="btn btn-primary mt-3"
                    >
                        Register as Company
                        <i class="bi bi-arrow-right ms-1"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- =========================
     CALL TO ACTION
========================= -->

<section class="cta-section py-5">

    <div class="container text-center py-3">

        <h2 class="fw-bold">
            Start Your Career Journey Today
        </h2>

        <p class="mt-3">
            Create your CareerLink account and take the next step
            toward finding the right opportunity.
        </p>

        <a
            href="register.php"
            class="btn cta-button btn-lg mt-3"
        >
            <i class="bi bi-person-plus me-2"></i>
            Create Your Account
        </a>

    </div>

</section>


<!-- =========================
     FOOTER
========================= -->

<footer class="footer">

    <div class="container">

        <div class="row">


            <!-- About -->

            <div class="col-md-5 mb-4">

                <h5>
                    <i class="bi bi-briefcase-fill me-2"></i>
                    CareerLink
                </h5>

                <p class="mt-3 mb-0">
                    CareerLink is a web-based job and internship portal
                    designed to connect job seekers, students and
                    companies through career opportunities.
                </p>

            </div>


            <!-- Quick Links -->

            <div class="col-md-3 mb-4">

                <h5>
                    Quick Links
                </h5>

                <ul class="list-unstyled mt-3">

                    <li class="mb-2">
                        <a href="index.php">
                            Home
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="login.php">
                            Login
                        </a>
                    </li>

                    <li class="mb-2">
                        <a href="register.php">
                            Register
                        </a>
                    </li>

                </ul>

            </div>


            <!-- Platform -->

            <div class="col-md-4 mb-4">

                <h5>
                    Platform
                </h5>

                <ul class="list-unstyled mt-3">

                    <li class="mb-2">
                        <i class="bi bi-briefcase me-2"></i>
                        Jobs & Internships
                    </li>

                    <li class="mb-2">
                        <i class="bi bi-file-earmark-check me-2"></i>
                        Application Management
                    </li>

                    <li class="mb-2">
                        <i class="bi bi-building me-2"></i>
                        Company Recruitment
                    </li>

                </ul>

            </div>

        </div>


        <hr class="footer-divider">


        <div class="text-center footer-bottom">

            <p class="mb-1">
                © 2026 CareerLink. All Rights Reserved.
            </p>

            <span>
                Connecting talent with opportunities.
            </span>

        </div>

    </div>

</footer>


<!-- Bootstrap JavaScript -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
></script>

</body>

</html>

