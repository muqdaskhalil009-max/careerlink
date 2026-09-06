<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "company") {
    header("Location: ../login.php");
    exit;
}

$company_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "SELECT id, title, type, description, location, salary, deadline, created_at
     FROM job_posts
     WHERE company_id = ?
     ORDER BY created_at DESC"
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

    <title>My Job Posts</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>My Job & Internship Posts</h2>

        <a href="create_post.php" class="btn btn-primary">
            + Create New Post
        </a>

    </div>

    <?php if ($result->num_rows > 0): ?>

        <div class="row">

            <?php while ($post = $result->fetch_assoc()): ?>

                <div class="col-md-6 mb-4">

                    <div class="card shadow-sm h-100">

                        <div class="card-body">

                            <h4 class="card-title">
                                <?php echo htmlspecialchars($post["title"]); ?>
                            </h4>

                            <span class="badge bg-primary mb-3">
                                <?php echo htmlspecialchars(ucfirst($post["type"])); ?>
                            </span>

                            <p>
                                <strong>Location:</strong>
                                <?php echo htmlspecialchars($post["location"] ?: "Not specified"); ?>
                            </p>

                            <p>
                                <strong>Salary/Stipend:</strong>
                                <?php echo htmlspecialchars($post["salary"] ?: "Not specified"); ?>
                            </p>

                            <p>
                                <strong>Deadline:</strong>
                                <?php echo htmlspecialchars($post["deadline"]); ?>
                            </p>

                            <p>
                                <?php echo nl2br(htmlspecialchars($post["description"])); ?>
                            </p>

                            <div class="mt-3">

                               <a href="edit_post.php?id=<?php echo $post["id"]; ?>"
   class="btn btn-secondary btn-sm">
    Edit
</a>

                              <a href="delete_post.php?id=<?php echo $post["id"]; ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Are you sure you want to delete this post?');">
    Delete
</a>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="alert alert-info">
            You have not created any job or internship posts yet.
        </div>

    <?php endif; ?>

    <a href="dashboard.php" class="btn btn-secondary">
        Back to Dashboard
    </a>

</div>

</body>

</html>

<?php

$stmt->close();

?>