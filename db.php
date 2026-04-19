<?php
$conn = new mysqli("localhost", "root", "", "petshop");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>