<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "company") {
    header("Location: ../login.php");
    exit;
}

$company_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT
        applications.id,
        applications.cover_letter,
        applications.status,
        applications.applied_at,
        job_posts.title,
        users.name,
        users.email
     FROM applications
     INNER JOIN job_posts
        ON applications.job_post_id = job_posts.id
     INNER JOIN users
        ON applications.user_id = users.id
     WHERE job_posts.company_id = ?
     ORDER BY applications.applied_at DESC"
);

$stmt->bind_param("i", $company_id);

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Applications</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Applications</h2>

        <a href="dashboard.php" class="btn btn-secondary">
            Back to Dashboard
        </a>

    </div>


    <?php if ($result->num_rows > 0): ?>

        <?php while ($application = $result->fetch_assoc()): ?>

            <div class="card shadow-sm mb-4">

                <div class="card-body">

                    <h4>
                        <?php echo htmlspecialchars($application["title"]); ?>
                    </h4>

                    <p>
                        <strong>Applicant:</strong>
                        <?php echo htmlspecialchars($application["name"]); ?>
                    </p>

                    <p>
                        <strong>Email:</strong>
                        <?php echo htmlspecialchars($application["email"]); ?>
                    </p>

                    <p>
                        <strong>Status:</strong>
                        <?php echo htmlspecialchars($application["status"]); ?>
                    </p>
                    <div class="mt-3">

    <strong>Update Status:</strong>

    <a href="update_application.php?id=<?php echo $application["id"]; ?>&status=Shortlisted"
       class="btn btn-warning btn-sm">
        Shortlist
    </a>

    <a href="update_application.php?id=<?php echo $application["id"]; ?>&status=Accepted"
       class="btn btn-success btn-sm">
        Accept
    </a>

    <a href="update_application.php?id=<?php echo $application["id"]; ?>&status=Rejected"
       class="btn btn-danger btn-sm">
        Reject
    </a>

</div>

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

    <?php else: ?>

        <div class="alert alert-info">
            No applications received yet.
        </div>

    <?php endif; ?>

</div>

</body>

</html>

<?php

$stmt->close();

?>