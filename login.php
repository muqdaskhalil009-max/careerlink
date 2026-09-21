
<?php

session_start();

require_once __DIR__ . "/config/db.php";

$message = "";
$message_type = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {

        $message = "Please enter your email and password.";
        $message_type = "danger";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Please enter a valid email address.";
        $message_type = "danger";

    } else {

        $stmt = $conn->prepare(
            "SELECT id, name, email, password, role
             FROM users
             WHERE email = ?"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {

            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {

                session_regenerate_id(true);

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["user_name"] = $user["name"];
                $_SESSION["user_email"] = $user["email"];
                $_SESSION["user_role"] = trim(strtolower($user["role"]));

                if ($_SESSION["user_role"] === "user") {

                    header("Location: user/dashboard.php");
                    exit;

                } elseif ($_SESSION["user_role"] === "company") {

                    header("Location: company/dashboard.php");
                    exit;

                } elseif ($_SESSION["user_role"] === "admin") {

                    header("Location: admin/dashboard.php");
                    exit;

                } else {

                    $message = "Invalid user role.";
                    $message_type = "danger";
                }

            } else {

                $message = "Incorrect email or password.";
                $message_type = "danger";
            }

        } else {

            $message = "Incorrect email or password.";
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

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login | CareerLink</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fb;
            color: #172033;
        }

        /* Navbar */

        .navbar {
            background: linear-gradient(
                135deg,
                #0b1f3a,
                #123f73
            );
            padding: 15px 0;
        }

        .navbar-brand {
            font-size: 23px;
        }

        .brand-icon {
            color: #5bbcff;
            margin-right: 8px;
        }

        .home-btn {
            border: 1px solid rgba(255,255,255,0.5);
            border-radius: 8px;
            padding: 7px 16px;
        }

        .home-btn:hover {
            background-color: rgba(255,255,255,0.1);
        }


        /* Login Area */

        .login-wrapper {
            min-height: calc(100vh - 72px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 15px;
        }

        .login-card {
            width: 100%;
            max-width: 460px;
            background-color: white;
            border: 1px solid #e3e9f1;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(11,31,58,0.10);
        }


        /* Login Header */

        .login-header {
            background: linear-gradient(
                135deg,
                #0b1f3a,
                #1769aa
            );
            color: white;
            padding: 35px 30px;
            text-align: center;
        }

        .login-icon {
            width: 62px;
            height: 62px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            font-size: 27px;
        }

        .login-header h2 {
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-header p {
            margin-bottom: 0;
            color: rgba(255,255,255,0.78);
        }


        /* Login Body */

        .login-body {
            padding: 35px;
        }

        .form-label {
            color: #172033;
        }

        .input-group-text {
            background-color: #f4f7fb;
            border-color: #dbe2ea;
            color: #1769aa;
        }

        .form-control {
            padding: 12px 13px;
            border-color: #dbe2ea;
        }

        .form-control:focus {
            border-color: #1769aa;
            box-shadow: 0 0 0 0.2rem rgba(23,105,170,0.12);
        }


        /* Login Button */

        .btn-login {
            background-color: #1769aa;
            border-color: #1769aa;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
        }

        .btn-login:hover {
            background-color: #123f73;
            border-color: #123f73;
        }


        /* Register Link */

        .register-link {
            color: #1769aa;
        }

        .register-link:hover {
            color: #0b1f3a;
        }


        /* Alert */

        .alert {
            border-radius: 8px;
            font-size: 14px;
        }


        /* Footer */

        .login-footer {
            text-align: center;
            margin-top: 25px;
            color: #6b7280;
            font-size: 13px;
        }


        /* Responsive */

        @media (max-width: 576px) {

            .login-wrapper {
                padding: 30px 15px;
            }

            .login-body {
                padding: 28px 22px;
            }

            .login-header {
                padding: 30px 20px;
            }

        }

    </style>

</head>

<body>


<!-- =========================
     NAVIGATION
========================= -->

<nav class="navbar navbar-dark">

    <div class="container">

        <a
            class="navbar-brand fw-bold"
            href="index.php"
        >
            <i class="bi bi-briefcase-fill brand-icon"></i>
            CareerLink
        </a>


        <a
            href="index.php"
            class="btn btn-outline-light btn-sm home-btn"
        >
            <i class="bi bi-house me-1"></i>
            Home
        </a>

    </div>

</nav>


<!-- =========================
     LOGIN
========================= -->

<div class="login-wrapper">

    <div class="login-card">


        <!-- Header -->

        <div class="login-header">

            <div class="login-icon">
                <i class="bi bi-person-lock"></i>
            </div>

            <h2>
                Welcome Back
            </h2>

            <p>
                Sign in to continue to CareerLink
            </p>

        </div>


        <!-- Body -->

        <div class="login-body">


            <?php if (!empty($message)): ?>

                <div class="alert alert-<?php echo $message_type; ?> mb-4">

                    <i class="bi bi-exclamation-circle me-2"></i>

                    <?php echo htmlspecialchars($message); ?>

                </div>

            <?php endif; ?>


            <form method="POST" action="">


                <!-- Email -->

                <div class="mb-3">

                    <label
                        for="email"
                        class="form-label fw-semibold"
                    >
                        Email Address
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control"
                            placeholder="Enter your email"
                            required
                        >

                    </div>

                </div>


                <!-- Password -->

                <div class="mb-4">

                    <label
                        for="password"
                        class="form-label fw-semibold"
                    >
                        Password
                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control"
                            placeholder="Enter your password"
                            required
                        >

                    </div>

                </div>


                <!-- Login -->

                <button
                    type="submit"
                    class="btn btn-primary btn-login w-100"
                >

                    <i class="bi bi-box-arrow-in-right me-2"></i>

                    Login to CareerLink

                </button>

            </form>


            <!-- Register -->

            <div class="text-center mt-4">

                <p class="mb-1 text-muted">
                    Don't have an account?
                </p>

                <a
                    href="register.php"
                    class="register-link fw-semibold text-decoration-none"
                >
                    Create an Account
                    <i class="bi bi-arrow-right ms-1"></i>
                </a>

            </div>


            <div class="login-footer">

                <i class="bi bi-shield-check me-1"></i>
                Secure CareerLink account access

            </div>

        </div>

    </div>

</div>


</body>

</html>

