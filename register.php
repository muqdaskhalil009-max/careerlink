
<?php

require_once "config/db.php";

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $role = $_POST["role"];

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password) || empty($role)) {

        $message = "Please fill in all fields.";
        $message_type = "danger";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $message_type = "danger";

    } elseif (strlen($password) < 6) {

        $message = "Password must be at least 6 characters.";
        $message_type = "danger";

    } elseif ($password !== $confirm_password) {

        $message = "Passwords do not match.";
        $message_type = "danger";

    } else {

        // Check if email already exists

        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "An account with this email already exists.";
            $message_type = "danger";

        } else {

            // Secure password hashing

            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Insert user

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password, role)
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssss",
                $name,
                $email,
                $hashed_password,
                $role
            );

            if ($stmt->execute()) {

                $user_id = $stmt->insert_id;

                // Create empty profile

                if ($role === "user") {

                    $profile = $conn->prepare(
                        "INSERT INTO user_profiles (user_id)
                         VALUES (?)"
                    );

                    $profile->bind_param("i", $user_id);
                    $profile->execute();

                } elseif ($role === "company") {

                    $profile = $conn->prepare(
                        "INSERT INTO company_profiles (user_id, company_name)
                         VALUES (?, ?)"
                    );

                    $profile->bind_param(
                        "is",
                        $user_id,
                        $name
                    );

                    $profile->execute();
                }

                $message = "Registration successful! You can now login.";
                $message_type = "success";

            } else {

                $message = "Something went wrong. Please try again.";
                $message_type = "danger";
            }

            $stmt->close();
        }

        $check->close();
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

    <title>Register | CareerLink</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>

        body {
            background-color: #f8f9fa;
        }

        .register-wrapper {
            padding: 50px 15px;
        }

        .register-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .register-header {
            background: linear-gradient(135deg, #0d6efd, #084298);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .register-header h2 {
            font-weight: bold;
        }

        .register-body {
            padding: 35px;
        }

        .form-control,
        .form-select {
            padding: 12px;
        }

        .btn-register {
            padding: 12px;
            font-weight: bold;
        }

        .footer-link {
            color: #adb5bd;
            text-decoration: none;
        }

        .footer-link:hover {
            color: white;
        }

    </style>

</head>

<body>

<!-- Navigation -->

<nav class="navbar navbar-dark bg-primary">

    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="index.php"
        >
            CareerLink
        </a>

        <div>

            <a
                href="index.php"
                class="btn btn-outline-light btn-sm me-2"
            >
                Home
            </a>

            <a
                href="login.php"
                class="btn btn-light btn-sm"
            >
                Login
            </a>

        </div>

    </div>

</nav>


<!-- Registration -->

<div class="register-wrapper">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8 col-lg-6">

                <div class="card register-card shadow-lg">

                    <div class="register-header">

                        <h2 class="mb-2">
                            Create Your Account
                        </h2>

                        <p class="mb-0">
                            Join CareerLink and discover new opportunities.
                        </p>

                    </div>


                    <div class="register-body">

                        <?php if (!empty($message)): ?>

                            <div class="alert alert-<?php echo $message_type; ?>">

                                <?php echo htmlspecialchars($message); ?>

                            </div>

                        <?php endif; ?>


                        <form method="POST" action="">

                            <!-- Name -->

                            <div class="mb-3">

                                <label
                                    for="name"
                                    class="form-label fw-semibold"
                                >
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control"
                                    placeholder="Enter your full name"
                                    required
                                >

                            </div>


                            <!-- Email -->

                            <div class="mb-3">

                                <label
                                    for="email"
                                    class="form-label fw-semibold"
                                >
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    placeholder="Enter your email"
                                    required
                                >

                            </div>


                            <!-- Password -->

                            <div class="mb-3">

                                <label
                                    for="password"
                                    class="form-label fw-semibold"
                                >
                                    Password
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    class="form-control"
                                    placeholder="Enter password"
                                    required
                                >

                                <small class="text-muted">
                                    Password must be at least 6 characters.
                                </small>

                            </div>


                            <!-- Confirm Password -->

                            <div class="mb-3">

                                <label
                                    for="confirm_password"
                                    class="form-label fw-semibold"
                                >
                                    Confirm Password
                                </label>

                                <input
                                    type="password"
                                    name="confirm_password"
                                    id="confirm_password"
                                    class="form-control"
                                    placeholder="Confirm password"
                                    required
                                >

                            </div>


                            <!-- Role -->

                            <div class="mb-4">

                                <label
                                    for="role"
                                    class="form-label fw-semibold"
                                >
                                    Register As
                                </label>

                                <select
                                    name="role"
                                    id="role"
                                    class="form-select"
                                    required
                                >

                                    <option value="">
                                        Select account type
                                    </option>

                                    <option value="user">
                                        Job Seeker / Student
                                    </option>

                                    <option value="company">
                                        Company
                                    </option>

                                </select>

                                <small class="text-muted">
                                    Admin accounts are created separately by the system administrator.
                                </small>

                            </div>


                            <!-- Button -->

                            <button
                                type="submit"
                                class="btn btn-primary btn-register w-100"
                            >
                                Create Account
                            </button>

                        </form>


                        <div class="text-center mt-4">

                            <p class="mb-1 text-muted">
                                Already have an account?
                            </p>

                            <a
                                href="login.php"
                                class="fw-semibold text-decoration-none"
                            >
                                Login here
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Footer -->

<footer class="bg-dark text-white pt-5 pb-3">

    <div class="container">

        <div class="row">

            <!-- About -->

            <div class="col-md-4 mb-4">

                <h4 class="fw-bold">
                    CareerLink
                </h4>

                <p class="text-light">
                    CareerLink connects students, job seekers and
                    companies through jobs and internship opportunities.
                </p>

            </div>


            <!-- Quick Links -->

            <div class="col-md-4 mb-4">

                <h5 class="fw-bold">
                    Quick Links
                </h5>

                <ul class="list-unstyled">

                    <li class="mb-2">
                        <a
                            href="index.php"
                            class="footer-link"
                        >
                            Home
                        </a>
                    </li>

                    <li class="mb-2">
                        <a
                            href="login.php"
                            class="footer-link"
                        >
                            Login
                        </a>
                    </li>

                    <li class="mb-2">
                        <a
                            href="register.php"
                            class="footer-link"
                        >
                            Register
                        </a>
                    </li>

                </ul>

            </div>


            <!-- Contact -->

            <div class="col-md-4 mb-4">

                <h5 class="fw-bold">
                    Contact
                </h5>

                <p class="mb-2">
                    📧 admin@careerlink.com
                </p>

                <p class="mb-2">
                    📍 Pakistan
                </p>

                <p>
                    💼 Jobs & Internship Portal
                </p>

            </div>

        </div>


        <hr class="border-secondary">


        <div class="text-center">

            <p class="mb-1">
                © 2026 CareerLink. All Rights Reserved.
            </p>

            <small class="text-secondary">
                Designed for connecting talent with opportunities.
            </small>

        </div>

    </div>

</footer>

</body>

</html>
