
<?php

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "user") {
    header("Location: ../login.php");
    exit;
}

$user_name = $_SESSION["user_name"];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Dashboard | CareerLink</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background-color: #f5f7fb;
        }

        .navbar-brand {
            font-size: 1.4rem;
        }

        .welcome-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        }

        .dashboard-card {
            background: white;
            border: none;
            border-radius: 15px;
            padding: 25px;
            height: 100%;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
            transition: 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .card-icon {
            font-size: 35px;
            margin-bottom: 15px;
        }

        .profile-box {
            background: #ffffff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.06);
        }

        footer {
            margin-top: 60px;
            padding: 20px;
            background: white;
            text-align: center;
            color: #777;
        }

    </style>

</head>

<body>

<!-- Navigation -->

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        <a class="navbar-brand fw-bold" href="../index.php">
            CareerLink
        </a>

        <div class="d-flex align-items-center">

            <span class="text-white me-3">
                <?php echo htmlspecialchars($user_name); ?>
            </span>

            <a href="../logout.php" class="btn btn-light btn-sm">
                Logout
            </a>

        </div>

    </div>

</nav>


<!-- Main Content -->

<div class="container py-5">

    <!-- Welcome -->

    <div class="welcome-section mb-4">

        <h2 class="fw-bold">
            Welcome back, <?php echo htmlspecialchars($user_name); ?>! 👋
        </h2>

        <p class="text-muted mb-0">
            Manage your CareerLink account and explore career opportunities.
        </p>

    </div>


    <!-- Dashboard Cards -->

    <div class="row g-4">

        <!-- Profile -->

        <div class="col-md-4">

            <div class="dashboard-card">

                <div class="card-icon">
                    👤
                </div>

                <h4>
                    My Profile
                </h4>

                <p class="text-muted">
                    View and update your personal, educational and professional information.
                </p>

                <a href="profile.php" class="btn btn-primary">
                    Manage Profile
                </a>

            </div>

        </div>


        <!-- Opportunities -->

        <div class="col-md-4">

            <div class="dashboard-card">

                <div class="card-icon">
                    💼
                </div>

                <h4>
                    Opportunities
                </h4>

                <p class="text-muted">
                    Search and explore available jobs and internship opportunities.
                </p>

                <a href="browse_jobs.php" class="btn btn-success">
                    Browse Opportunities
                </a>

            </div>

        </div>


        <!-- Applications -->

        <div class="col-md-4">

            <div class="dashboard-card">

                <div class="card-icon">
                    📄
                </div>

                <h4>
                    Applications
                </h4>

                <p class="text-muted">
                    View and track the status of your job and internship applications.
                </p>

                <a href="application_history.php" class="btn btn-primary">
                    My Applications
                </a>

            </div>

        </div>

    </div>


    <!-- Account Information -->

    <div class="profile-box mt-4">

        <h4 class="mb-3">
            Account Information
        </h4>

        <div class="row">

            <div class="col-md-6 mb-3">

                <strong>Name</strong>

                <p class="text-muted mb-0">
                    <?php echo htmlspecialchars($_SESSION["user_name"]); ?>
                </p>

            </div>


            <div class="col-md-6 mb-3">

                <strong>Email</strong>

                <p class="text-muted mb-0">
                    <?php echo htmlspecialchars($_SESSION["user_email"]); ?>
                </p>

            </div>


            <div class="col-md-6">

                <strong>Account Type</strong>

                <p class="text-muted mb-0">
                    Job Seeker / Student
                </p>

            </div>


            <div class="col-md-6">

                <strong>Account Status</strong>

                <p class="text-success mb-0">
                    ● Active
                </p>

            </div>

        </div>

    </div>

</div>


<!-- Footer -->

<footer>

    <p class="mb-0">
        © 2026 CareerLink | Connecting Talent with Opportunity
    </p>

</footer>


</body>

</html>

