<?php
session_start();
include "config.php";

if (isset($_POST['loginBtn'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $selectedRole = $_POST['role'];

  $sql = "SELECT * FROM users WHERE email='$email'";
  $result = $conn->query($sql);

  if ($result->num_rows == 1) {
    $users = $result->fetch_assoc();
	if ($user['status'] !== 'active') {
    $error = "Your account is pending approval by Headteacher/Director. Please wait.";
}
    if (!password_verify($password, $users['password'])) {
      echo "<script>alert('Wrong password!'); window.location='login_page.html';</script>";
      exit();
    }
	$_SESSION['role'] = $row['role']; // Must be exactly: Secretary, Teacher, Headteacher, Director, or Bursar
    if ($users['role'] != $selectedRole) {
      echo "<script>alert('Role mismatch! You registered as " . $users['role'] . ". Please select the correct role.'); window.location='login_page.html';</script>";
      exit();
    }

    $_SESSION['user_id'] = $users['id'];
    $_SESSION['full_name'] = $users['full_name'];
    $_SESSION['role'] = $users['role'];

    if ($users['role'] == "Director") {
      header("Location: director.php");
    } elseif ($users['role'] == "Headteacher") {
      header("Location: headteacher.php");
    } elseif ($users['role'] == "Teacher") {
      header("Location: teacher.php");
    } elseif ($users['role'] == "Secretary") {
      header("Location: secretary.php");
    } elseif ($users['role'] == "Bursar") {
      header("Location: bursar.php");
    }
    exit();

  } else {
    echo "<script>alert('User not found! Please register first.'); window.location='login_page.html';</script>";
  }
}
?>