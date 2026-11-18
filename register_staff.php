<?php
session_start();
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role']; // teacher, bursar, etc. Not admin/headteacher/director

    $stmt = $conn->prepare("INSERT INTO users (username, password_hash, full_name, role, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("ssss", $username, $password_hash, $full_name, $role);
    $stmt->execute();

    echo "Registration submitted. Waiting for Headteacher/Director approval.";
}
?>