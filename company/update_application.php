<?php

session_start();

require_once __DIR__ . "/../config/db.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["user_role"] !== "company") {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET["id"]) || !isset($_GET["status"])) {
    header("Location: applications.php");
    exit;
}

$application_id = (int) $_GET["id"];
$status = $_GET["status"];

$allowed_statuses = ["Pending", "Shortlisted", "Rejected", "Accepted"];

if (!in_array($status, $allowed_statuses)) {
    header("Location: applications.php");
    exit;
}

$company_id = $_SESSION["user_id"];

$stmt = $conn->prepare(
    "UPDATE applications
     INNER JOIN job_posts
        ON applications.job_post_id = job_posts.id
     SET applications.status = ?
     WHERE applications.id = ?
     AND job_posts.company_id = ?"
);

$stmt->bind_param("sii", $status, $application_id, $company_id);

$stmt->execute();

$stmt->close();

header("Location: applications.php");
exit;
?>