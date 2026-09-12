<?php
session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "user") {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT applications.id, job_posts.title, job_posts.type,
            applications.cover_letter, applications.status,
            applications.applied_at
     FROM applications
     INNER JOIN job_posts
     ON applications.job_post_id = job_posts.id
     WHERE applications.user_id = ?
     ORDER BY applications.applied_at DESC"
);

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Application History</title>

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>

</head>

<body>

<div class="container mt-5">

<h2 class="mb-4">My Applications</h2>

<?php if ($result->num_rows === 0): ?>

    <div class="alert alert-info">
        You have not submitted any applications yet.
    </div>

<?php else: ?>

    <?php while ($application = $result->fetch_assoc()): ?>

        <div class="card shadow-sm mb-4">

            <div class="card-body">

                <h4>
                    <?php echo htmlspecialchars($application["title"]); ?>
                </h4>

                <p>
                    <strong>Type:</strong>
                    <?php echo htmlspecialchars(ucfirst($application["type"])); ?>
                </p>

                <p>
                    <strong>Status:</strong>
                    <?php echo htmlspecialchars($application["status"]); ?>
                </p>

                <p>
                    <strong>Applied At:</strong>
                    <?php echo htmlspecialchars($application["applied_at"]); ?>
                </p>

                <hr>

                <p>
                    <strong>Cover Letter:</strong>
                </p>

                <p>
                    <?php echo nl2br(htmlspecialchars($application["cover_letter"])); ?>
                </p>

            </div>

        </div>

    <?php endwhile; ?>

<?php endif; ?>

<a href="browse_jobs.php" class="btn btn-secondary">
    Back to Opportunities
</a>

</div>

</body>
</html>

<?php
$stmt->close();
?>
