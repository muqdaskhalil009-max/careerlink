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

    // Basic validation
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
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $message = "An account with this email already exists.";
            $message_type = "danger";

        } else {

            // Secure password hashing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert user
            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)"
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

                // Create an empty profile for the registered account
                if ($role === "user") {

                    $profile = $conn->prepare(
                        "INSERT INTO user_profiles (user_id) VALUES (?)"
                    );

                    $profile->bind_param("i", $user_id);
                    $profile->execute();

                } elseif ($role === "company") {

                    $profile = $conn->prepare(
                        "INSERT INTO company_profiles (user_id, company_name) VALUES (?, ?)"
                    );

                    $profile->bind_param("is", $user_id, $name);
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register | CareerLink</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            CareerLink
        </a>
    </div>
</nav>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7 col-lg-6">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h2 class="text-center mb-2">
                        Create Your CareerLink Account
                    </h2>

                    <p class="text-center text-muted mb-4">
                        Join CareerLink as a job seeker or company.
                    </p>

                    <?php if (!empty($message)): ?>

                        <div class="alert alert-<?php echo $message_type; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>

                    <?php endif; ?>

                    <form method="POST" action="">

                        <div class="mb-3">

                            <label class="form-label">
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                class="form-control"
                                placeholder="Enter your full name"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Enter your email"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Enter password"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Confirm Password
                            </label>

                            <input
                                type="password"
                                name="confirm_password"
                                class="form-control"
                                placeholder="Confirm password"
                                required
                            >

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Register As
                            </label>

                            <select
                                name="role"
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

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Create Account
                        </button>

                    </form>

                    <p class="text-center mt-4 mb-0">

                        Already have an account?

                        <a href="login.php">
                            Login here
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>