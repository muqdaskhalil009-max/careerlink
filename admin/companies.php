
<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "admin") {
    header("Location: ../login.php");
    exit;
}

$result = $conn->query(
    "SELECT id, name, email, created_at
     FROM users
     WHERE role = 'company'
     ORDER BY id DESC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Manage Companies | CareerLink</title>

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
                🏢 Manage Companies
            </h2>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-primary">

                        <tr>

                            <th>ID</th>

                            <th>Company Name</th>

                            <th>Email</th>

                            <th>Registered</th>

                        </tr>

                    </thead>

                    <tbody>

                    <?php if ($result && $result->num_rows > 0): ?>

                        <?php while ($company = $result->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?php echo $company["id"]; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($company["name"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($company["email"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($company["created_at"]); ?>
                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="4"
                                class="text-center text-muted"
                            >
                                No companies found.
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

