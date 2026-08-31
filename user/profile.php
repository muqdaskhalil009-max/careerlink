<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "user") {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$message = "";
$message_type = "";


/* Get current profile information */

$stmt = $conn->prepare("
    SELECT 
        u.name,
        u.email,
        up.phone,
        up.education,
        up.skills,
        up.bio,
        up.profile_image
    FROM users u
    LEFT JOIN user_profiles up ON u.id = up.user_id
    WHERE u.id = ?
");

$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$profile = $result->fetch_assoc();

$stmt->close();


/* Update profile */

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $phone = trim($_POST["phone"]);
    $education = trim($_POST["education"]);
    $skills = trim($_POST["skills"]);
    $bio = trim($_POST["bio"]);


    if (empty($name)) {

        $message = "Name cannot be empty.";
        $message_type = "danger";

    } else {

        /* Update name */

        $update_user = $conn->prepare("
            UPDATE users
            SET name = ?
            WHERE id = ?
        ");

        $update_user->bind_param("si", $name, $user_id);
        $update_user->execute();
        $update_user->close();


        /* Check if profile exists */

        $check_profile = $conn->prepare("
            SELECT user_id
            FROM user_profiles
            WHERE user_id = ?
        ");

        $check_profile->bind_param("i", $user_id);
        $check_profile->execute();

        $profile_result = $check_profile->get_result();

        $check_profile->close();


        if ($profile_result->num_rows > 0) {

            /* Update existing profile */

            $update_profile = $conn->prepare("
                UPDATE user_profiles
                SET phone = ?,
                    education = ?,
                    skills = ?,
                    bio = ?
                WHERE user_id = ?
            ");

            $update_profile->bind_param(
                "ssssi",
                $phone,
                $education,
                $skills,
                $bio,
                $user_id
            );

            $update_profile->execute();
            $update_profile->close();

        } else {

            /* Create new profile */

            $insert_profile = $conn->prepare("
                INSERT INTO user_profiles
                (user_id, phone, education, skills, bio)
                VALUES (?, ?, ?, ?, ?)
            ");

            $insert_profile->bind_param(
                "issss",
                $user_id,
                $phone,
                $education,
                $skills,
                $bio
            );

            $insert_profile->execute();
            $insert_profile->close();
        }


        $_SESSION["user_name"] = $name;

        $message = "Profile updated successfully!";
        $message_type = "success";


        /* Refresh profile information */

        $stmt = $conn->prepare("
            SELECT 
                u.name,
                u.email,
                up.phone,
                up.education,
                up.skills,
                up.bio,
                up.profile_image
            FROM users u
            LEFT JOIN user_profiles up ON u.id = up.user_id
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

    <title>My Profile | CareerLink</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">


<!-- Navigation -->

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


<!-- Profile Form -->

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h2 class="mb-1">
                        My Profile
                    </h2>

                    <p class="text-muted mb-4">
                        Update your personal and professional information.
                    </p>


                    <?php if (!empty($message)): ?>

                        <div class="alert alert-<?php echo $message_type; ?>">

                            <?php echo htmlspecialchars($message); ?>

                        </div>

                    <?php endif; ?>


                    <form method="POST">


                        <!-- Name -->

                        <div class="mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="<?php echo htmlspecialchars($profile["name"] ?? ""); ?>"
                                required
                            >

                        </div>


                        <!-- Email -->

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


                        <!-- Phone -->

                        <div class="mb-3">

                            <label class="form-label">
                                Phone Number
                            </label>

                            <input
                                type="text"
                                name="phone"
                                class="form-control"
                                value="<?php echo htmlspecialchars($profile["phone"] ?? ""); ?>"
                                placeholder="Enter your phone number"
                            >

                        </div>


                        <!-- Education -->

                        <div class="mb-3">

                            <label class="form-label">
                                Education
                            </label>

                            <input
                                type="text"
                                name="education"
                                class="form-control"
                                value="<?php echo htmlspecialchars($profile["education"] ?? ""); ?>"
                                placeholder="Example: BS Information Technology"
                            >

                        </div>


                        <!-- Skills -->

                        <div class="mb-3">

                            <label class="form-label">
                                Skills
                            </label>

                            <textarea
                                name="skills"
                                class="form-control"
                                rows="3"
                                placeholder="Example: HTML, CSS, PHP, MySQL"
                            ><?php echo htmlspecialchars($profile["skills"] ?? ""); ?></textarea>

                        </div>


                        <!-- Bio -->

                        <div class="mb-4">

                            <label class="form-label">
                                About Me
                            </label>

                            <textarea
                                name="bio"
                                class="form-control"
                                rows="5"
                                placeholder="Write a short introduction about yourself"
                            ><?php echo htmlspecialchars($profile["bio"] ?? ""); ?></textarea>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Save Profile
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