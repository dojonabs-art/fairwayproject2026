<?php
session_start();
include "config.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != "Secretary") {
  header("Location: login.php");
  exit();
}

$todayTotal = $conn->query("SELECT COUNT(*) as total FROM admissions WHERE created_at = CURDATE()")->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html>
<head>
  <title>Secretary Dashboard - Fairway</title>
  <link rel="stylesheet" href="style.css">
  <style>
  p,h2,h3{
	color:yellow;
}
</style>
</head>
<body>
<div class="main-content">
  <h2>Welcome Secretary: <?php echo $_SESSION['full_name']; ?></h2>
  <p>Admissions Today: <?php echo $todayTotal; ?></p>
  <a href="admission.html"><button>New Admission</button></a>
  <a href="view_admissions.php"><button>View Admissions</button></a>
  <a href="admission_report.php"><button>Admission Report</button></a>
  <a href="logout.php"><button>Logout</button></a>
  
</div>
<script src="script.js"></script>
</body>
</html>