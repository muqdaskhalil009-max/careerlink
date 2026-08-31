<?php

session_start();

require_once __DIR__ . "/../config/db.php";


// Make sure company is logged in

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "company") {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$message = "";
$message_type = "";


// Get company profile

$stmt = $conn->prepare("
    SELECT
        u.name,
        u.email,
        cp.company_name,
        cp.industry,
        cp.location,
        cp.website,
        cp.description,
        cp.company_logo
    FROM users u
    LEFT JOIN company_profiles cp
        ON u.id = cp.user_id
    WHERE u.id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();

$profile = $result->fetch_assoc();

$stmt->close();


// Save company profile

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $company_name = trim($_POST["company_name"]);
    $industry = trim($_POST["industry"]);
    $location = trim($_POST["location"]);
    $website = trim($_POST["website"]);
    $description = trim($_POST["description"]);


    if (empty($company_name)) {

        $message = "Company name is required.";
        $message_type = "danger";

    } else {

        // Update name in users table

        $update_user = $conn->prepare("
            UPDATE users
            SET name = ?
            WHERE id = ?
        ");

        $update_user->bind_param(
            "si",
            $company_name,
            $user_id
        );

        $update_user->execute();

        $update_user->close();


        // Check if company profile exists

        $check = $conn->prepare("
            SELECT user_id
            FROM company_profiles
            WHERE user_id = ?
        ");

        $check->bind_param("i", $user_id);

        $check->execute();

        $check_result = $check->get_result();

        $check->close();


        if ($check_result->num_rows > 0) {

            // Update existing profile

            $update = $conn->prepare("
                UPDATE company_profiles
                SET company_name = ?,
                    industry = ?,
                    location = ?,
                    website = ?,
                    description = ?
                WHERE user_id = ?
            ");

            $update->bind_param(
                "sssssi",
                $company_name,
                $industry,
                $location,
                $website,
                $description,
                $user_id
            );

            $update->execute();

            $update->close();

        } else {

            // Create new company profile

            $insert = $conn->prepare("
                INSERT INTO company_profiles
                (
                    user_id,
                    company_name,
                    industry,
                    location,
                    website,
                    description
                )
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            $insert->bind_param(
                "isssss",
                $user_id,
                $company_name,
                $industry,
                $location,
                $website,
                $description
            );

            $insert->execute();

            $insert->close();
        }


        $_SESSION["user_name"] = $company_name;

        $message = "Company profile updated successfully!";
        $message_type = "success";


        // Reload profile

        $stmt = $conn->prepare("
            SELECT
                u.name,
                u.email,
                cp.company_name,
                cp.industry,
                cp.location,
                cp.website,
                cp.description,
                cp.company_logo
            FROM users u
            LEFT JOIN company_profiles cp
                ON u.id = cp.user_id
            WHERE u.id = ?
        ");

        $stmt->bind_param("i", $user_id);

        $stmt->execute();

        $result = $stmt->get_result();

        $profile = $result->fetch_assoc();

        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Company Profile | CareerLink</title>

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
            CareerLink
        </a>


        <div>

            <a
                href="dashboard.php"
                class="btn btn-light btn-sm me-2"
            >
                Dashboard
            </a>

            <a
                href="../logout.php"
                class="btn btn-outline-light btn-sm"
            >
                Logout
            </a>

        </div>

    </div>

</nav>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h2 class="mb-1">
                        Company Profile
                    </h2>

                    <p class="text-muted mb-4">
                        Manage your company information.
                    </p>


                    <?php if (!empty($message)): ?>

                        <div class="alert alert-<?php echo $message_type; ?>">

                            <?php echo htmlspecialchars($message); ?>

                        </div>

                    <?php endif; ?>


                    <form method="POST">


                        <div class="mb-3">

                            <label class="form-label">
                                Company Name
                            </label>

                            <input
                                type="text"
                                name="company_name"
                                class="form-control"
                                value="<?php echo htmlspecialchars($profile["company_name"] ?? ""); ?>"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                value="<?php echo htmlspecialchars($profile["email"] ?? ""); ?>"
                                readonly
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Industry
                            </label>

                            <input
                                type="text"
                                name="industry"
                                class="form-control"
                                value="<?php echo htmlspecialchars($profile["industry"] ?? ""); ?>"
                                placeholder="Example: Software Development"
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Location
                            </label>

                            <input
                                type="text"
                                name="location"
                                class="form-control"
                                value="<?php echo htmlspecialchars($profile["location"] ?? ""); ?>"
                                placeholder="Example: Lahore, Pakistan"
                            >

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                Website
                            </label>

                            <input
                                type="url"
                                name="website"
                                class="form-control"
                                value="<?php echo htmlspecialchars($profile["website"] ?? ""); ?>"
                                placeholder="https://example.com"
                            >

                        </div>


                        <div class="mb-4">

                            <label class="form-label">
                                Company Description
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="5"
                                placeholder="Tell us about your company..."
                            ><?php echo htmlspecialchars($profile["description"] ?? ""); ?></textarea>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Save Company Profile
                        </button>


                        <a
                            href="dashboard.php"
                            class="btn btn-secondary"
                        >
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