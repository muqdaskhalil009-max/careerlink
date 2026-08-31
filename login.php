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
            "SELECT id, name, email, password, role FROM users WHERE email = ?"
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
                $_SESSION["user_role"] = $user["role"];

                if ($user["role"] === "user") {

                    header("Location: user/dashboard.php");
                    exit;

                } elseif ($user["role"] === "company") {

                    header("Location: company/dashboard.php");
                    exit;
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
            href="index.php"
        >
            CareerLink
        </a>

    </div>

</nav>


<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card shadow border-0">

                <div class="card-body p-4">

                    <h2 class="text-center mb-2">
                        Welcome Back
                    </h2>

                    <p class="text-center text-muted mb-4">
                        Login to your CareerLink account.
                    </p>


                    <?php if (!empty($message)): ?>

                        <div class="alert alert-<?php echo $message_type; ?>">

                            <?php echo htmlspecialchars($message); ?>

                        </div>

                    <?php endif; ?>


                    <form method="POST" action="">

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


                        <div class="mb-4">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Enter your password"
                                required
                            >

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Login
                        </button>

                    </form>


                    <p class="text-center mt-4 mb-0">

                        Don't have an account?

                        <a href="register.php">
                            Create an account
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>