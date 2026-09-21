
<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$sql = "
    SELECT
        job_posts.id,
        job_posts.title,
        job_posts.type,
        job_posts.location,
        job_posts.salary,
        job_posts.deadline,
        users.name AS company_name
    FROM job_posts
    INNER JOIN users
        ON job_posts.company_id = users.id
    ORDER BY job_posts.id DESC
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

    <title>Manage Jobs | CareerLink</title>

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
                📋 Manage Jobs
            </h2>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>ID</th>

                            <th>Job Title</th>

                            <th>Company</th>

                            <th>Type</th>

                            <th>Location</th>

                            <th>Salary / Stipend</th>

                            <th>Deadline</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if ($result && $result->num_rows > 0): ?>

                        <?php while ($job = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?php echo $job["id"]; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($job["title"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($job["company_name"]); ?>
                                </td>

                                <td>
                                    <span class="badge bg-primary">
                                        <?php echo htmlspecialchars($job["type"]); ?>
                                    </span>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($job["location"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($job["salary"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($job["deadline"]); ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="7"
                                class="text-center text-muted"
                            >
                                No jobs found.
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

