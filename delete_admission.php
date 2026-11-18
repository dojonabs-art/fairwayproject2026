<?php
session_start();
include 'config.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM admissions WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Admission deleted successfully'); window.location='view_admissions.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: view_admissions.php");
    exit;
}
?>