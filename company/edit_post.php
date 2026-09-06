<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "company") {
    header("Location: ../login.php");
    exit;
}

$company_id = $_SESSION["user_id"];

if (!isset($_GET["id"])) {
    header("Location: my_posts.php");
    exit;
}

$post_id = (int) $_GET["id"];

$message = "";
$message_type = "";

/* Get the selected post */

$stmt = $conn->prepare(
    "SELECT id, title, type, description, requirements, location, salary, deadline
     FROM job_posts
     WHERE id = ? AND company_id = ?"
);

$stmt->bind_param("ii", $post_id, $company_id);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    $stmt->close();
    header("Location: my_posts.php");
    exit;
}

$post = $result->fetch_assoc();
$stmt->close();


/* Update the post */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

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
            "UPDATE job_posts
             SET title = ?,
                 type = ?,
                 description = ?,
                 requirements = ?,
                 location = ?,
                 salary = ?,
                 deadline = ?
             WHERE id = ? AND company_id = ?"
        );

        $stmt->bind_param(
            "sssssssii",
            $title,
            $type,
            $description,
            $requirements,
            $location,
            $salary,
            $deadline,
            $post_id,
            $company_id
        );

        if ($stmt->execute()) {

            header("Location: my_posts.php");
            exit;

        } else {

            $message = "Something went wrong. Please try again.";
            $message_type = "danger";
        }

        $stmt->close();
    }

    /* Show updated values in the form */

    $post["title"] = $title;
    $post["type"] = $type;
    $post["description"] = $description;
    $post["requirements"] = $requirements;
    $post["location"] = $location;
    $post["salary"] = $salary;
    $post["deadline"] = $deadline;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Job/Internship Post</title>

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

                    <h2 class="mb-4">Edit Job / Internship Post</h2>

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
                                value="<?php echo htmlspecialchars($post["title"]); ?>"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Type *
                            </label>

                            <select name="type" class="form-select" required>

                                <option value="job"
                                    <?php echo ($post["type"] === "job") ? "selected" : ""; ?>>
                                    Job
                                </option>

                                <option value="internship"
                                    <?php echo ($post["type"] === "internship") ? "selected" : ""; ?>>
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
                                required
                            ><?php echo htmlspecialchars($post["description"]); ?></textarea>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Requirements
                            </label>

                            <textarea
                                name="requirements"
                                class="form-control"
                                rows="4"
                            ><?php echo htmlspecialchars($post["requirements"]); ?></textarea>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Location
                            </label>

                            <input
                                type="text"
                                name="location"
                                class="form-control"
                                value="<?php echo htmlspecialchars($post["location"]); ?>"
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
                                value="<?php echo htmlspecialchars($post["salary"]); ?>"
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
                                value="<?php echo htmlspecialchars($post["deadline"]); ?>"
                                required
                            >

                        </div>


                        <button type="submit" class="btn btn-primary">
                            Save Changes
                        </button>

                        <a href="my_posts.php" class="btn btn-secondary">
                            Cancel
                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>
