<?php

session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "company") {
    header("Location: ../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Company Dashboard | CareerLink</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">


<nav class="navbar navbar-dark bg-primary">

    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="dashboard.php"
        >
            CareerLink
        </a>

        <a
            href="../logout.php"
            class="btn btn-outline-light btn-sm"
        >
            Logout
        </a>

    </div>

</nav>


<div class="container py-5">

    <div class="row">

        <div class="col-12">

            <div class="card shadow border-0">

                <div class="card-body p-5">

                    <h1 class="mb-3">
                        Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>!
                    </h1>

                    <p class="text-muted">
                        Welcome to your CareerLink company dashboard.
                    </p>

                    <hr>

                    <div class="row g-4 mt-2">

                        <div class="col-md-6">

                            <div class="card border-0 bg-light h-100">

                                <div class="card-body">

                                    <h4>
                                        🏢 Company Profile
                                    </h4>

                                    <p class="text-muted">
                                        Manage your company information.
                                    </p>

                                    <a
                                        href="profile.php"
                                        class="btn btn-primary"
                                    >
                                        Manage Profile
                                    </a>

                                </div>

                            </div>

                        </div>


                        <div class="col-md-6">

                            <div class="card border-0 bg-light h-100">

                                <div class="card-body">

                                    <h4>
                                        📋 Job Management
                                    </h4>

                                    <p class="text-muted">
                                        Job posting features will be available in the next module.
                                    </p>

                                    <button
                                        class="btn btn-secondary"
                                        disabled
                                    >
                                        Coming Soon
                                    </button>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


</body>

</html>