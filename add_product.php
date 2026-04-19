<?php
include "db.php";
session_start();

/* ONLY ADMIN SHOULD ACCESS */
$email = $_SESSION['user'] ?? null;

if(!$email){
    header("Location: login.php");
    exit;
}

$admin = $conn->query("SELECT * FROM users WHERE email='$email'")->fetch_assoc();

if(!$admin || $admin['role'] !== 'admin'){
    die("Access denied");
}

/* GET FORM DATA */
$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? 0;
$img = $_POST['img'] ?? '';

if(!$name || !$price){
    die("Name and price required");
}

/* INSERT PRODUCT */
$stmt = $conn->prepare("
    INSERT INTO products (name, description, price, img, type)
    VALUES (?, ?, ?, ?, 'pet')
");

$stmt->bind_param("ssis", $name, $description, $price, $img);
$stmt->execute();

header("Location: admin_dashboard.php");
exit;
?>