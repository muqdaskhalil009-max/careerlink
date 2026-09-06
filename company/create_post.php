<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "company") {
    header("Location: ../login.php");
    exit;
}

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $company_id = $_SESSION["user_id"];
    $title = trim($_POST["title"]);
    $type = $_POST["type"];
    $description = trim($_POST["description"]);
    $requirements = trim($_POST["requirements"]);
    $location = trim($_POST["location"]);
    $salary = trim($_POST["salary"]);
    $deadline = $_POST["deadline"];

    if (
        empty($title) ||
        empty($type) ||
        empty($description) ||
        empty($deadline)
    ) {
        $message = "Please fill in all required fields.";
        $message_type = "danger";
    } else {

        $stmt = $conn->prepare(
            "INSERT INTO job_posts
            (company_id, title, type, description, requirements, location, salary, deadline)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "isssssss",
            $company_id,
            $title,
            $type,
            $description,
            $requirements,
            $location,
            $salary,
            $deadline
        );

        if ($stmt->execute()) {
            $message = "Job/Internship post created successfully.";
            $message_type = "success";

            $_POST = [];
        } else {
            $message = "Something went wrong. Please try again.";
            $message_type = "danger";
        }

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Job/Internship Post</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow-sm">

                <div class="card-body">

                    <h2 class="mb-4">Create Job / Internship Post</h2>

                    <?php if (!empty($message)): ?>

                        <div class="alert alert-<?php echo $message_type; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>

                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Title *
                            </label>

                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                placeholder="e.g. PHP Developer"
                                value="<?php echo htmlspecialchars($_POST["title"] ?? ""); ?>"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Type *
                            </label>

                            <select name="type" class="form-select" required>

                                <option value="">
                                    Select Type
                                </option>

                                <option value="job"
                                    <?php echo (($_POST["type"] ?? "") === "job") ? "selected" : ""; ?>>
                                    Job
                                </option>

                                <option value="internship"
                                    <?php echo (($_POST["type"] ?? "") === "internship") ? "selected" : ""; ?>>
                                    Internship
                                </option>

                            </select>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Description *
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="5"
                                placeholder="Describe the job or internship..."
                                required
                            ><?php echo htmlspecialchars($_POST["description"] ?? ""); ?></textarea>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Requirements
                            </label>

                            <textarea
                                name="requirements"
                                class="form-control"
                                rows="4"
                                placeholder="Required education, skills, experience..."
                            ><?php echo htmlspecialchars($_POST["requirements"] ?? ""); ?></textarea>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Location
                            </label>

                            <input
                                type="text"
                                name="location"
                                class="form-control"
                                placeholder="e.g. Lahore"
                                value="<?php echo htmlspecialchars($_POST["location"] ?? ""); ?>"
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Salary / Stipend
                            </label>

                            <input
                                type="text"
                                name="salary"
                                class="form-control"
                                placeholder="e.g. 50,000 PKR or Negotiable"
                                value="<?php echo htmlspecialchars($_POST["salary"] ?? ""); ?>"
                            >

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Application Deadline *
                            </label>

                            <input
                                type="date"
                                name="deadline"
                                class="form-control"
                                value="<?php echo htmlspecialchars($_POST["deadline"] ?? ""); ?>"
                                required
                            >

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Create Post
                        </button>

                        <a href="dashboard.php" class="btn btn-secondary">
                            Back to Dashboard
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>