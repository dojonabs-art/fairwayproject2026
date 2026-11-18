<?php
session_start();
include "authentic.php";
requireRole(["Secretary", "Headteacher", "Director"]);
include "config.php";

$result = $conn->query("SELECT * FROM admissions ORDER BY created_at DESC");

if (!$result) {
  die("Query Failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>View Admissions - Fairway</title>
  <link rel="stylesheet" href="style1.css">
  <style>p,h2,h3{
	color:yellow;
}
</style>
</head>
<body>
  <h2>Admitted Children</h2>

  <input type="text" id="searchBox" placeholder="Search by name, class, phone..." onkeyup="searchTable()" style="padding:10px; width:300px; margin-bottom:15px;">

  <table id="studentsTable" border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse:collapse;">
    <tr style="background:#f2f2f2;">
      <th>Admission No</th>
      <th>Child Name</th>
      <th>Class</th>
      <th>Gender</th>
      <th>Parent Name</th>
      <th>Parent Phone</th>
      <th>Address</th>
      <th>Status</th>
      <th>Date Admitted</th>
	  <th>Action</th>
	   <th>Action</th>
    </tr>
    <?php if ($result->num_rows > 0): ?>
      <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?php echo $row['admission_no']; ?></td>
          <td><?php echo $row['childName']; ?></td>
          <td><?php echo $row['className']; ?></td>
          <td><?php echo $row['gender']; ?></td>
          <td><?php echo $row['parentName']; ?></td>
          <td><?php echo $row['parentPhone']; ?></td>
          <td><?php echo $row['homeaddress']; ?></td>
          <td><?php echo $row['status']; ?></td>
          <td><?php echo $row['created_at']; ?></td>
		  <td>
  <a href="update_view_admissions.php?id=<?php echo $row['id']; ?>" style="background:#1565c0; color:white; padding:6px 12px; text-decoration:none; border-radius:5px;">Update</a>
</td>
	<td>
    <a href="delete_admission.php?id=<?php echo $row['id']; ?>" 
       onclick="return confirm('Are you sure you want to delete this admission?');"
       style="color:red; font-weight:bold;"><button style="background-color:red;">Delete</button></a>
</td>
        </tr>
      <?php } ?>
    <?php else: ?>
        <tr><td colspan="9" style="text-align:center;">No admissions found yet.</td></tr>
    <?php endif; ?>
  </table>
  <div style="padding:20px;">
<a style="padding:5px; margin-left:20px; background-color:yellow; color:black; border-radius:40px;" href="index1.php">Back to home</a>
</div>
  <script>
    function searchTable() {
      let input = document.getElementById("searchBox").value.toUpperCase();
      let table = document.getElementById("studentsTable");
      let tr = table.getElementsByTagName("tr");

      for (let i = 1; i < tr.length; i++) {
        let found = false;
        let tds = tr[i].getElementsByTagName("td");
        for (let j = 0; j < tds.length; j++) {
          if (tds[j].textContent.toUpperCase().includes(input)) {
            found = true;
            break;
          }
        }
        tr[i].style.display = found ? "" : "none";
      }
    }
  </script>
</body>
</html>