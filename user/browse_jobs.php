<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "user") {
    header("Location: ../login.php");
    exit;
}

/* Search and filter values */
$search = isset($_GET["search"]) ? trim($_GET["search"]) : "";
$type = isset($_GET["type"]) ? trim($_GET["type"]) : "";
$location = isset($_GET["location"]) ? trim($_GET["location"]) : "";

/* Build query */
$sql = "SELECT id, title, type, description, location, salary, deadline, created_at
        FROM job_posts
        WHERE deadline >= CURDATE()";

$params = [];
$types = "";

/* Search by title */
if ($search !== "") {
    $sql .= " AND title LIKE ?";
    $params[] = "%" . $search . "%";
    $types .= "s";
}

/* Filter by type */
if ($type !== "") {
    $sql .= " AND type = ?";
    $params[] = $type;
    $types .= "s";
}

/* Filter by location */
if ($location !== "") {
    $sql .= " AND location LIKE ?";
    $params[] = "%" . $location . "%";
    $types .= "s";
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();

$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Browse Opportunities</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body>

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Browse Opportunities</h2>

        <a href="dashboard.php" class="btn btn-secondary">
            Back to Dashboard
        </a>

    </div>


    <!-- Search and Filters -->

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <form method="GET">

                <div class="row g-3">

                    <!-- Search -->

                    <div class="col-md-4">

                        <label class="form-label">
                            Search by Title
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="e.g. PHP Developer"
                            value="<?php echo htmlspecialchars($search); ?>"
                        >

                    </div>


                    <!-- Type -->

                    <div class="col-md-3">

                        <label class="form-label">
                            Type
                        </label>

                        <select name="type" class="form-select">

                            <option value="">All</option>

                            <option value="job"
                                <?php echo ($type === "job") ? "selected" : ""; ?>>
                                Job
                            </option>

                            <option value="internship"
                                <?php echo ($type === "internship") ? "selected" : ""; ?>>
                                Internship
                            </option>

                        </select>

                    </div>


                    <!-- Location -->

                    <div class="col-md-3">

                        <label class="form-label">
                            Location
                        </label>

                        <input
                            type="text"
                            name="location"
                            class="form-control"
                            placeholder="e.g. Lahore"
                            value="<?php echo htmlspecialchars($location); ?>"
                        >

                    </div>


                    <!-- Buttons -->

                    <div class="col-md-2 d-flex align-items-end">

                        <div class="w-100">

                            <button
                                type="submit"
                                class="btn btn-primary w-100 mb-2">
                                Search
                            </button>

                            <a
                                href="browse_jobs.php"
                                class="btn btn-outline-secondary w-100">
                                Reset
                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    <!-- Job Results -->

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

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="alert alert-info">
            No available job or internship opportunities found.
        </div>

    <?php endif; ?>

</div>

</body>

</html>

<?php

$stmt->close();

?>