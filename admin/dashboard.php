
<?php

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$admin_name = $_SESSION["user_name"];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Admin Dashboard | CareerLink</title>

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
           ADMIN CARDS
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
            href="dashboard.php"
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
                    Administration Portal
                </p>

                <h1>
                    Admin Dashboard
                </h1>

                <p>
                    Welcome,
                    <strong><?php echo htmlspecialchars($admin_name); ?></strong>.
                    Manage and monitor the CareerLink platform from one central workspace.
                </p>

            </div>

            <div class="col-md-3 text-md-end mt-4 mt-md-0">

                <div class="hero-icon ms-md-auto">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         MANAGEMENT
    ========================= -->

    <div class="mb-4">

        <h2 class="section-title">
            Platform Management
        </h2>

        <p class="section-subtitle">
            Manage users, companies, job opportunities and applications.
        </p>

    </div>


    <div class="row g-4 mb-5">


        <!-- USERS -->

        <div class="col-lg-6 col-md-6">

            <div class="feature-card">

                <div class="feature-icon">
                    <i class="bi bi-people-fill"></i>
                </div>

                <h4>
                    User Management
                </h4>

                <p>
                    View and manage registered job seekers and students using the CareerLink platform.
                </p>

                <a
                    href="users.php"
                    class="btn primary-btn"
                >
                    <i class="bi bi-people me-1"></i>
                    Manage Users
                </a>

            </div>

        </div>


        <!-- COMPANIES -->

        <div class="col-lg-6 col-md-6">

            <div class="feature-card">

                <div class="feature-icon">
                    <i class="bi bi-building"></i>
                </div>

                <h4>
                    Company Management
                </h4>

                <p>
                    View and manage companies registered on the CareerLink platform.
                </p>

                <a
                    href="companies.php"
                    class="btn primary-btn"
                >
                    <i class="bi bi-building me-1"></i>
                    Manage Companies
                </a>

            </div>

        </div>


        <!-- JOBS -->

        <div class="col-lg-6 col-md-6">

            <div class="feature-card">

                <div class="feature-icon">
                    <i class="bi bi-briefcase-fill"></i>
                </div>

                <h4>
                    Job & Internship Management
                </h4>

                <p>
                    Monitor job and internship postings published by registered companies.
                </p>

                <a
                    href="jobs.php"
                    class="btn primary-btn"
                >
                    <i class="bi bi-list-check me-1"></i>
                    Manage Jobs
                </a>

            </div>

        </div>


        <!-- APPLICATIONS -->

        <div class="col-lg-6 col-md-6">

            <div class="feature-card">

                <div class="feature-icon">
                    <i class="bi bi-file-earmark-text-fill"></i>
                </div>

                <h4>
                    Application Monitoring
                </h4>

                <p>
                    Monitor applications submitted by users for available job and internship opportunities.
                </p>

                <a
                    href="applications.php"
                    class="btn primary-btn"
                >
                    <i class="bi bi-clipboard-data me-1"></i>
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
            Quickly navigate to the main administration areas.
        </p>

    </div>


    <div class="row g-3">


        <div class="col-md-3">

            <a
                href="users.php"
                class="quick-link"
            >

                <div class="quick-link-icon">
                    <i class="bi bi-person-lines-fill"></i>
                </div>

                <div>

                    <strong>
                        Users
                    </strong>

                    <small>
                        Manage users
                    </small>

                </div>

            </a>

        </div>


        <div class="col-md-3">

            <a
                href="companies.php"
                class="quick-link"
            >

                <div class="quick-link-icon">
                    <i class="bi bi-buildings"></i>
                </div>

                <div>

                    <strong>
                        Companies
                    </strong>

                    <small>
                        Manage companies
                    </small>

                </div>

            </a>

        </div>


        <div class="col-md-3">

            <a
                href="jobs.php"
                class="quick-link"
            >

                <div class="quick-link-icon">
                    <i class="bi bi-briefcase"></i>
                </div>

                <div>

                    <strong>
                        Jobs
                    </strong>

                    <small>
                        Manage opportunities
                    </small>

                </div>

            </a>

        </div>


        <div class="col-md-3">

            <a
                href="applications.php"
                class="quick-link"
            >

                <div class="quick-link-icon">
                    <i class="bi bi-file-earmark-check"></i>
                </div>

                <div>

                    <strong>
                        Applications
                    </strong>

                    <small>
                        Monitor applications
                    </small>

                </div>

            </a>

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
            Administration Portal
        </div>

        <div class="small mt-2">
            © 2026 CareerLink. All rights reserved.
        </div>

    </div>

</footer>


</body>

</html>

