
<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$sql = "
    SELECT
        applications.id,
        applications.cover_letter,
        applications.status,
        applications.applied_at,
        users.name AS user_name,
        users.email AS user_email,
        job_posts.title AS job_title
    FROM applications
    INNER JOIN users
        ON applications.user_id = users.id
    INNER JOIN job_posts
        ON applications.job_post_id = job_posts.id
    ORDER BY applications.id DESC
";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Applications | CareerLink</title>

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
            CareerLink Admin
        </a>

        <a
            href="dashboard.php"
            class="btn btn-outline-light btn-sm"
        >
            Dashboard
        </a>

    </div>

</nav>

<div class="container py-5">

    <div class="card shadow border-0">

        <div class="card-body">

            <h2 class="mb-4">
                📄 Application Monitoring
            </h2>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary">

                        <tr>
                            <th>ID</th>
                            <th>Applicant</th>
                            <th>Email</th>
                            <th>Job</th>
                            <th>Status</th>
                            <th>Applied On</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php if ($result && $result->num_rows > 0): ?>

                        <?php while ($application = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?php echo $application["id"]; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($application["user_name"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($application["user_email"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($application["job_title"]); ?>
                                </td>

                                <td>

                                    <span class="badge bg-primary">
                                        <?php echo htmlspecialchars($application["status"]); ?>
                                    </span>

                                </td>

                                <td>
                                    <?php echo htmlspecialchars($application["applied_at"]); ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-muted"
                            >
                                No applications found.
                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>

