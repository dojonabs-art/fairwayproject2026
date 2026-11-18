<?php
session_start();
include "authentic.php";
requireRole(["Teacher"]);
include "config.php";

$children = $conn->query("SELECT * FROM admissions ORDER BY className, childName");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Teacher Dashboard - Fairway</title>
  <link rel="stylesheet" href="style.css">
  <style>
  p,h2,h3{
	color:yellow;
}
</style>
</head>
<body>
<div class="main-content">
  <h2>Welcome Teacher: <?php echo $_SESSION['full_name']; ?></h2>
  <p>Today is: <span id="todayDate"></span></p>
  <h3>Children By Class</h3>
 <input type="text" id="searchBox" placeholder="Search child..." onkeyup="searchTable()">
  <table id="studentsTable" border="1">
    <tr><th>Child Name</th><th>Class</th><th>Gender</th></tr>
    <?php while($row = $children->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['childName']; ?></td>
        <td><?php echo $row['className']; ?></td>
        <td><?php echo $row['gender']; ?></td>
      </tr>
    <?php } ?>
  </table>
  <button onclick="quickSearch()">Quick Search</button>
  <a href="logout.php"><button style="background-color:red;">Logout</button></a>
</div>
<script src="script.js"></script>
</body>
</html>