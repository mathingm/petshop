<?php
include "db.php";
session_start();

$email = $_SESSION['user'] ?? null;

if(!$email){
    header("Location: login.php");
    exit;
}

$admin = $conn->query("SELECT * FROM users WHERE email='$email'")->fetch_assoc();

if(!$admin || $admin['role'] !== 'admin'){
    die("Access denied");
}

$id = $_GET['id'] ?? 0;

$stmt = $conn->prepare("UPDATE cart SET status = 2 WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin_dashboard.php");
exit;
?>