<?php
include "config.php";

if (isset($_POST['registerBtn'])) {
  $fullname = $_POST['fullname'];
  $email = $_POST['email'];
  $role = $_POST['role'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $check = "SELECT * FROM users WHERE email='$email'";
  $result = $conn->query($check);

  if ($result->num_rows > 0) {
    echo "<script>alert('Email already exists!'); window.location='register_page.html';</script>";
    exit();
  }

  $sql = "INSERT INTO users (full_name, email, password, role) VALUES ('$fullname', '$email', '$password', '$role')";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Registration Successful! Please login.'); window.location='login_page.html';</script>";
  } else {
    echo "Error: " . $conn->error;
  }
}
?>