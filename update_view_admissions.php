<?php
session_start();
include "authentic.php";
requireRole(["Secretary", "Headteacher", "Director"]);
include "config.php";

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM admissions WHERE id='$id'");
$row = $result->fetch_assoc();

if (!$row) {
  die("Admission not found");
}

// UPDATE ACTION
if (isset($_POST['updateBtn'])) {
  $childName     = $_POST['childName'];
  $date_of_birth = $_POST['date_of_birth'];
  $gender        = $_POST['gender'];
  $className     = $_POST['className'];
  $parentName    = $_POST['parentName'];
  $parentPhone   = $_POST['parentPhone'];
  $homeaddress   = $_POST['homeaddress'];

  $sql = "UPDATE admissions SET 
            childName='$childName',
            date_of_birth='$date_of_birth',
            gender='$gender',
            className='$className',
            parentName='$parentName',
            parentPhone='$parentPhone',
            homeaddress='$homeaddress'
          WHERE id='$id'";

  if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Admission Updated Successfully'); window.location='view_admissions.php';</script>";
    exit();
  } else {
    echo "Error: " . $conn->error;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Update Admission - Fairway</title>
  <link rel="stylesheet" href="style1.css">
  <style>
  p,h2,h3{
	color:yellow;
}
</style>
</head>
<body>
  <h2>Update Admission: <?php echo $row['admission_no']; ?></h2>

  <form method="POST">
    <label>Child Name:</label><br>
    <input type="text" name="childName" value="<?php echo $row['childName']; ?>" required><br><br>

    <label>Date of Birth:</label><br>
    <input type="date" name="date_of_birth" value="<?php echo $row['date_of_birth']; ?>" required><br><br>

    <label>Gender:</label><br>
    <select name="gender" required>
      <option value="Female" <?php if($row['gender']=='Female') echo 'selected'; ?>>Female</option>
      <option value="Male" <?php if($row['gender']=='Male') echo 'selected'; ?>>Male</option>
    </select><br><br>

    <label>Class:</label><br>
    <select name="className" required>
      <?php
        $classes = ['Baby Class','Middle Class','Top Class','P.1','P.2','P.3','P.4','P.5','P.6','P.7'];
        foreach ($classes as $c) {
          $sel = ($row['className'] == $c) ? 'selected' : '';
          echo "<option value='$c' $sel>$c</option>";
        }
      ?>
    </select><br><br>

    <label>Parent Name:</label><br>
    <input type="text" name="parentName" value="<?php echo $row['parentName']; ?>" required><br><br>

    <label>Parent Phone:</label><br>
    <input type="text" name="parentPhone" value="<?php echo $row['parentPhone']; ?>" required><br><br>

    <label>Home Address:</label><br>
    <textarea name="homeaddress" required><?php echo $row['homeaddress']; ?></textarea><br><br>

    <button type="submit" name="updateBtn">Update Admission</button>
    <a href="view_admissions.php"><button style="background-color:red;">Cancel</button></a>
  </form>
</body>
</html>