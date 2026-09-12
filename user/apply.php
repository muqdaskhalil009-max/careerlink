<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "user") {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: browse_jobs.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$job_id = (int) $_GET["id"];

$stmt = $conn->prepare(
    "SELECT id, title, type, description, requirements, location, salary, deadline
     FROM job_posts
     WHERE id = ?"
);

$stmt->bind_param("i", $job_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Job or internship not found.";
    exit;
}

$job = $result->fetch_assoc();

$stmt->close();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $cover_letter = trim($_POST["cover_letter"]);

    if ($cover_letter === "") {

        $error = "Please enter a cover letter.";

    } else {

        $check = $conn->prepare(
            "SELECT id FROM applications
             WHERE job_post_id = ? AND user_id = ?"
        );

        $check->bind_param("ii", $job_id, $user_id);
        $check->execute();

        $check_result = $check->get_result();

        if ($check_result->num_rows > 0) {

            $error = "You have already applied for this opportunity.";

        } else {

            $insert = $conn->prepare(
                "INSERT INTO applications
                 (job_post_id, user_id, cover_letter)
                 VALUES (?, ?, ?)"
            );

            $insert->bind_param("iis", $job_id, $user_id, $cover_letter);

            if ($insert->execute()) {

                header("Location: application_history.php");
                exit;

            } else {

                $error = "Application could not be submitted.";
            }

            $insert->close();
        }

        $check->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Apply for Opportunity</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <h2 class="mb-4">Apply for Opportunity</h2>

    <?php if ($error !== ""): ?>

        <div class="alert alert-danger">
            <?php echo htmlspecialchars($error); ?>
        </div>

    <?php endif; ?>

    <div class="card shadow-sm">

        <div class="card-body">

            <h3>
                <?php echo htmlspecialchars($job["title"]); ?>
            </h3>

            <p>
                <strong>Type:</strong>
                <?php echo htmlspecialchars(ucfirst($job["type"])); ?>
            </p>

            <p>
                <strong>Location:</strong>
                <?php echo htmlspecialchars($job["location"] ?: "Not specified"); ?>
            </p>

            <p>
                <strong>Salary/Stipend:</strong>
                <?php echo htmlspecialchars($job["salary"] ?: "Not specified"); ?>
            </p>

            <p>
                <strong>Deadline:</strong>
                <?php echo htmlspecialchars($job["deadline"]); ?>
            </p>

            <hr>

            <form method="POST">

                <div class="mb-3">

                    <label for="cover_letter" class="form-label">
                        Cover Letter
                    </label>

                    <textarea
                        name="cover_letter"
                        id="cover_letter"
                        class="form-control"
                        rows="6"
                        placeholder="Write your cover letter here..."
                        required
                    ></textarea>

                </div>

                <button type="submit" class="btn btn-primary">
                    Submit Application
                </button>

                <a href="browse_jobs.php" class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>

    </div>

</div>

</body>

</html>