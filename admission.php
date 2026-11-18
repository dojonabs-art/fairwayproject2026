<?php
session_start();
include "config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != "Secretary") {
  header("Location: admission.html");
  exit();
}

if (isset($_POST['admitBtn'])) {
  $childName = $_POST['childName'];
  $date_of_birth = $_POST['date_of_birth'];
  $gender = $_POST['gender'];
  $className = $_POST['className'];
  $parentName = $_POST['parentName'];
  $parentPhone = $_POST['parentPhone'];
  $homeAddress = $_POST['homeaddress'];
  // AUTO GENERATE ADMISSION NUMBER
$year = date("Y");

// Get the last admission number from database
$lastResult = $conn->query("SELECT admission_no FROM admissions ORDER BY id DESC LIMIT 1");

if ($lastResult && $lastResult->num_rows > 0) {
    $lastRow = $lastResult->fetch_assoc();
    $lastNo = $lastRow['admission_no']; // e.g. FA/2026/005

    // Extract the number part after last /
    $parts = explode("/", $lastNo);
    $lastNumber = intval(end($parts));

    $nextNumber = $lastNumber + 1;
} else {
    // First child ever
    $nextNumber = 1;
}

// Format as 001, 002, 010, 100
$admissionNo = "FA/" . $year . "/" . str_pad($nextNumber, 3, "0", STR_PAD_LEFT);

  $sql = "INSERT INTO admissions (admission_no,childName, date_of_birth, gender, className, parentName, parentPhone, homeaddress, status) VALUES ('$admission_no','$childName', '$date_of_birth', '$gender', '$className', '$parentName', '$parentPhone', '$homeAddress', 'Pending Headteacher Approval')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Admission Successful for $childName'); window.location='admission.html';</script>";
  } else {
    echo "Error: " . $conn->error;
  }
}
?>