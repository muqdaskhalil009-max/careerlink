<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "company") {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET["id"])) {
    header("Location: my_posts.php");
    exit;
}

$company_id = $_SESSION["user_id"];
$post_id = (int) $_GET["id"];

$stmt = $conn->prepare(
    "DELETE FROM job_posts
     WHERE id = ? AND company_id = ?"
);

$stmt->bind_param("ii", $post_id, $company_id);

if ($stmt->execute()) {

    header("Location: my_posts.php");
    exit;

} else {

    echo "Delete failed: " . $stmt->error;
}

$stmt->close();

?>