
<?php

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "user") {
    header("Location: ../login.php");
    exit;
}

$user_name = $_SESSION["user_name"];
$user_email = $_SESSION["user_email"];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Student Dashboard | CareerLink</title>

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
            background: #f4f7fb;
            color: #172033;
            font-family: Arial, sans-serif;
        }

        /* =========================
           NAVBAR
        ========================= */

        .career-navbar {
            background: linear-gradient(135deg, #0b1f3a, #123f73);
            padding: 14px 0;
        }

        .brand-logo {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff !important;
            text-decoration: none;
            letter-spacing: 0.3px;
        }

        .brand-logo i {
            color: #5bbcff;
            margin-right: 8px;
        }

        .logout-btn {
            border: 1px solid rgba(255, 255, 255, 0.7);
            color: white;
            border-radius: 8px;
            padding: 7px 18px;
        }

        .logout-btn:hover {
            background: white;
            color: #123f73;
        }


        /* =========================
           HERO
        ========================= */

        .dashboard-hero {
            background: linear-gradient(135deg, #123f73, #1769aa);
            border-radius: 18px;
            padding: 42px;
            color: white;
            box-shadow: 0 10px 30px rgba(18, 63, 115, 0.18);
        }

        .dashboard-hero h1 {
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .dashboard-hero p {
            margin-bottom: 0;
            color: #e5f2ff;
            font-size: 16px;
        }

        .hero-icon {
            width: 74px;
            height: 74px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
        }


        /* =========================
           SECTION
        ========================= */

        .section-title {
            font-weight: 700;
            color: #172033;
        }

        .section-subtitle {
            color: #6b7280;
        }


        /* =========================
           FEATURE CARDS
        ========================= */

        .feature-card {
            background: white;
            border: none;
            border-radius: 16px;
            height: 100%;
            padding: 28px;
            box-shadow: 0 6px 22px rgba(20, 40, 70, 0.08);
            transition: all 0.25s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(20, 40, 70, 0.14);
        }

        .feature-icon {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            margin-bottom: 20px;
            background: #eaf4ff;
            color: #1769aa;
        }

        .feature-card h4 {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: #6b7280;
            line-height: 1.6;
            min-height: 52px;
        }

        .primary-btn {
            background: #1769aa;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            color: white;
            font-weight: 600;
        }

        .primary-btn:hover {
            background: #0f4f83;
            color: white;
        }


        /* =========================
           ACCOUNT INFORMATION
        ========================= */

        .account-section {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 6px 22px rgba(20, 40, 70, 0.08);
        }

        .account-title {
            font-weight: 700;
            margin-bottom: 25px;
        }

        .account-item {
            background: #f7faff;
            border: 1px solid #e4eef9;
            border-radius: 12px;
            padding: 18px;
            height: 100%;
        }

        .account-icon {
            color: #1769aa;
            font-size: 20px;
            margin-right: 8px;
        }

        .account-label {
            display: block;
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .account-value {
            font-weight: 600;
            color: #172033;
        }

        .active-status {
            color: #198754;
        }


        /* =========================
           QUICK ACCESS
        ========================= */

        .quick-link {
            background: white;
            border-radius: 14px;
            padding: 20px;
            text-decoration: none;
            color: #172033;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 5px 18px rgba(20, 40, 70, 0.06);
            transition: 0.2s;
            height: 100%;
        }

        .quick-link:hover {
            transform: translateY(-3px);
            color: #1769aa;
        }

        .quick-link-icon {
            width: 45px;
            height: 45px;
            border-radius: 11px;
            background: #eef6ff;
            color: #1769aa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .quick-link strong {
            display: block;
            margin-bottom: 3px;
        }

        .quick-link small {
            color: #6b7280;
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            background: #0b1f3a;
            color: #cbd5e1;
            padding: 24px 0;
            margin-top: 70px;
        }

        footer strong {
            color: white;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            .dashboard-hero {
                padding: 28px;
            }

            .dashboard-hero h1 {
                font-size: 26px;
            }

            .hero-icon {
                display: none;
            }

        }

    </style>

</head>

<body>


<!-- =========================
     NAVBAR
========================= -->

<nav class="navbar career-navbar">

    <div class="container">

        <a
            class="brand-logo"
            href="../index.php"
        >
            <i class="bi bi-briefcase-fill"></i>
            CareerLink
        </a>

        <a
            href="../logout.php"
            class="btn logout-btn"
        >
            <i class="bi bi-box-arrow-right me-1"></i>
            Logout
        </a>

    </div>

</nav>


<!-- =========================
     MAIN CONTENT
========================= -->

<main class="container py-5">


    <!-- HERO -->

    <div class="dashboard-hero mb-5">

        <div class="row align-items-center">

            <div class="col-md-9">

                <p class="text-uppercase small fw-semibold mb-2">
                    Student Portal
                </p>

                <h1>
                    Student Dashboard
                </h1>

                <p>
                    Explore career opportunities, manage your profile and track your applications from one place.
                </p>

            </div>

            <div class="col-md-3 text-md-end mt-4 mt-md-0">

                <div class="hero-icon ms-md-auto">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         MAIN FEATURES
    ========================= -->

    <div class="mb-4">

        <h2 class="section-title">
            CareerLink Services
        </h2>

        <p class="section-subtitle">
            Manage your career profile and discover opportunities that match your goals.
        </p>

    </div>


    <div class="row g-4 mb-5">


        <!-- PROFILE -->

        <div class="col-lg-4 col-md-6">

            <div class="feature-card">

                <div class="feature-icon">
                    <i class="bi bi-person-badge"></i>
                </div>

                <h4>
                    My Profile
                </h4>

                <p>
                    View and update your personal, educational and professional information.
                </p>

                <a
                    href="profile.php"
                    class="btn primary-btn"
                >
                    <i class="bi bi-pencil-square me-1"></i>
                    Manage Profile
                </a>

            </div>

        </div>


        <!-- OPPORTUNITIES -->

        <div class="col-lg-4 col-md-6">

            <div class="feature-card">

                <div class="feature-icon">
                    <i class="bi bi-briefcase"></i>
                </div>

                <h4>
                    Jobs & Internships
                </h4>

                <p>
                    Search and explore available jobs and internship opportunities.
                </p>

                <a
                    href="browse_jobs.php"
                    class="btn primary-btn"
                >
                    <i class="bi bi-search me-1"></i>
                    Browse Opportunities
                </a>

            </div>

        </div>


        <!-- APPLICATIONS -->

        <div class="col-lg-4 col-md-6">

            <div class="feature-card">

                <div class="feature-icon">
                    <i class="bi bi-file-earmark-check"></i>
                </div>

                <h4>
                    My Applications
                </h4>

                <p>
                    View your submitted applications and track their current status.
                </p>

                <a
                    href="application_history.php"
                    class="btn primary-btn"
                >
                    <i class="bi bi-clipboard-check me-1"></i>
                    View Applications
                </a>

            </div>

        </div>


    </div>


    <!-- =========================
         QUICK ACCESS
    ========================= -->

    <div class="mb-4">

        <h2 class="section-title">
            Quick Access
        </h2>

        <p class="section-subtitle">
            Quickly access the main areas of your CareerLink account.
        </p>

    </div>


    <div class="row g-3 mb-5">


        <div class="col-md-4">

            <a
                href="profile.php"
                class="quick-link"
            >

                <div class="quick-link-icon">
                    <i class="bi bi-person"></i>
                </div>

                <div>

                    <strong>
                        My Profile
                    </strong>

                    <small>
                        View and update your profile
                    </small>

                </div>

            </a>

        </div>


        <div class="col-md-4">

            <a
                href="browse_jobs.php"
                class="quick-link"
            >

                <div class="quick-link-icon">
                    <i class="bi bi-search"></i>
                </div>

                <div>

                    <strong>
                        Find Opportunities
                    </strong>

                    <small>
                        Browse jobs and internships
                    </small>

                </div>

            </a>

        </div>


        <div class="col-md-4">

            <a
                href="application_history.php"
                class="quick-link"
            >

                <div class="quick-link-icon">
                    <i class="bi bi-clock-history"></i>
                </div>

                <div>

                    <strong>
                        Application History
                    </strong>

                    <small>
                        Track your applications
                    </small>

                </div>

            </a>

        </div>


    </div>


    <!-- =========================
         ACCOUNT INFORMATION
    ========================= -->

    <div class="account-section">

        <h3 class="account-title">
            Account Information
        </h3>


        <div class="row g-3">


            <!-- NAME -->

            <div class="col-md-6">

                <div class="account-item">

                    <span class="account-label">
                        <i class="bi bi-person account-icon"></i>
                        Full Name
                    </span>

                    <span class="account-value">
                        <?php echo htmlspecialchars($user_name); ?>
                    </span>

                </div>

            </div>


            <!-- EMAIL -->

            <div class="col-md-6">

                <div class="account-item">

                    <span class="account-label">
                        <i class="bi bi-envelope account-icon"></i>
                        Email Address
                    </span>

                    <span class="account-value">
                        <?php echo htmlspecialchars($user_email); ?>
                    </span>

                </div>

            </div>


            <!-- ACCOUNT TYPE -->

            <div class="col-md-6">

                <div class="account-item">

                    <span class="account-label">
                        <i class="bi bi-mortarboard account-icon"></i>
                        Account Type
                    </span>

                    <span class="account-value">
                        Job Seeker / Student
                    </span>

                </div>

            </div>


            <!-- STATUS -->

            <div class="col-md-6">

                <div class="account-item">

                    <span class="account-label">
                        <i class="bi bi-shield-check account-icon"></i>
                        Account Status
                    </span>

                    <span class="account-value active-status">
                        <i class="bi bi-check-circle-fill me-1"></i>
                        Active
                    </span>

                </div>

            </div>


        </div>

    </div>


</main>


<!-- =========================
     FOOTER
========================= -->

<footer>

    <div class="container text-center">

        <strong>
            CareerLink
        </strong>

        <div class="small mt-1">
            Connecting talent with opportunities.
        </div>

        <div class="small mt-2">
            © 2026 CareerLink. All rights reserved.
        </div>

    </div>

</footer>


</body>

</html>
