<?php
session_start();
if (!isset($_SESSION['role']) || !in_array(strtolower($_SESSION['role']), ['headteacher','director'])) {
    header("Location: index1.php");
    exit;
}
include "authentic.php";
requireRole(["Headteacher"]);
include "config.php";

// APPROVE - works for Pending and Rejected
if (isset($_POST['approveBtn'])) {
  $id = intval($_POST['admission_id']);
  $conn->query("UPDATE admissions SET status='Approved' WHERE id='$id'");
  echo "<script>alert('Child Approved Successfully'); window.location='headteacher.php';</script>";
  exit();
}

// REJECT - works for Pending AND Approved
if (isset($_POST['rejectBtn'])) {
  $id = intval($_POST['admission_id']);
  $conn->query("UPDATE admissions SET status='Rejected' WHERE id='$id'");
  echo "<script>alert('Child Admission Rejected'); window.location='headteacher.php';</script>";
  exit();
}

// PENDING ADMISSIONS
$pending = $conn->query("SELECT * FROM admissions WHERE status='Pending Headteacher Approval' ORDER BY created_at DESC");
$pendingCount = $pending ? $pending->num_rows : 0;

// APPROVED CHILDREN - these can now be rejected
$approved = $conn->query("SELECT * FROM admissions WHERE status='Approved' ORDER BY created_at DESC");
$approvedCount = $approved ? $approved->num_rows : 0;

// REJECTED CHILDREN
$rejected = $conn->query("SELECT * FROM admissions WHERE status='Rejected' ORDER BY created_at DESC");
$rejectedCount = $rejected ? $rejected->num_rows : 0;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Headteacher Dashboard - Fairway School</title>
  <link rel="stylesheet" href="style1.css">
  <style>
    .card { background:#1565c0; color:white; padding:25px; border-radius:12px; margin:20px 0; text-align:center; }
    table { width:100%; border-collapse:collapse; background:white; color:black; margin-top:15px; }
    th, td { padding:12px; border:1px solid #ddd; text-align:left; }
    th { background:#f2f2f2; }
    .approve-btn { background:#2e7d32; color:white; border:none; padding:8px 15px; border-radius:5px; cursor:pointer; }
    .reject-btn { background:#c62828; color:white; border:none; padding:8px 15px; border-radius:5px; cursor:pointer; }
    .section-title { margin-top:35px; }
	p,h2,h3{
	color:black;
}
th{
	color:black;
}
td{
	color:blue;
}
}
  </style>
</head>
<body>

<header><h1>Fairway Nursery and Primary School</h1></header>
<nav>
  <a href="index1.php">Home</a>
  <a href="admission.html">Admission</a>
  <?php if (in_array(strtolower(trim($_SESSION['role'] ?? '')), ['headteacher','director'])): ?>
  <a href="approve_staff.php">Approve New Staff</a>
<?php endif; ?>
</nav>

<center><div class="container" style="background:white; padding:30px; border-radius:15px; margin:20px;">
  <h2>Headteacher Dashboard</h2>

  <div class="card">
    <h1>Pending: <?php echo $pendingCount; ?> | Approved: <?php echo $approvedCount; ?> | Rejected: <?php echo $rejectedCount; ?></h1>
  </div>

  <!-- PENDING SECTION -->
  <h3 class="section-title">Pending Admissions to Approve</h3>
  <table>
    <tr><th>Admission No</th><th>Child Name</th><th>Class</th><th>Parent Phone</th><th>Action</th></tr>
    <?php if ($pending && $pending->num_rows > 0): ?>
      <?php while ($row = $pending->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['admission_no']; ?></td>
          <td><?php echo $row['childName']; ?></td>
          <td><?php echo $row['className']; ?></td>
          <td><?php echo $row['parentPhone']; ?></td>
          <td>
            <form method="POST" style="display:inline;" onsubmit="return confirm('Approve <?php echo $row['childName']; ?>?');">
              <input type="hidden" name="admission_id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="approveBtn" class="approve-btn">Approve</button>
            </form>
            <form method="POST" style="display:inline;" onsubmit="return confirm('Reject <?php echo $row['childName']; ?>?');">
              <input type="hidden" name="admission_id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="rejectBtn" class="reject-btn">Reject</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5" style="text-align:center;">No pending admissions</td></tr>
    <?php endif; ?>
  </table>

  <!-- APPROVED SECTION - NEW: CAN REJECT APPROVED -->
  <h3 class="section-title">Approved Children (Click Reject to revoke approval)</h3>
  <table>
    <tr><th>Admission No</th><th>Child Name</th><th>Class</th><th>Parent Phone</th><th>Action</th></tr>
    <?php if ($approved && $approved->num_rows > 0): ?>
      <?php while ($row = $approved->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['admission_no']; ?></td>
          <td><?php echo $row['childName']; ?></td>
          <td><?php echo $row['className']; ?></td>
          <td><?php echo $row['parentPhone']; ?></td>
          <td>
            <form method="POST" onsubmit="return confirm('Are you sure you want to REJECT approved child <?php echo $row['childName']; ?>? This will revoke their admission.');">
              <input type="hidden" name="admission_id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="rejectBtn" class="reject-btn"> Reject again</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5" style="text-align:center;">No approved children yet</td></tr>
    <?php endif; ?>
  </table>

  <!-- REJECTED SECTION -->
  <h3 class="section-title">Rejected Children</h3>
  <table>
    <tr><th>Admission No</th><th>Child Name</th><th>Class</th><th>Parent Phone</th><th>Action</th></tr>
    <?php if ($rejected && $rejected->num_rows > 0): ?>
      <?php while ($row = $rejected->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['admission_no']; ?></td>
          <td><?php echo $row['childName']; ?></td>
          <td><?php echo $row['className']; ?></td>
          <td><?php echo $row['parentPhone']; ?></td>
          <td>
            <form method="POST" onsubmit="return confirm('Re-approve <?php echo $row['childName']; ?>?');">
              <input type="hidden" name="admission_id" value="<?php echo $row['id']; ?>">
              <button type="submit" name="approveBtn" class="approve-btn">Approve Again</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="5" style="text-align:center;">No rejected children</td></tr>
    <?php endif; ?>
  </table>

</div></center>

<footer><p>Headteacher Office</p></footer>
</body>
</html>