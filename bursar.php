<?php
session_start();
include "authentic.php";
requireRole(["Bursar"]);
include "config.php";

if (isset($_POST['payBtn'])) {
  $child = $_POST['child_name'];
  $amount = $_POST['amount'];
  $conn->query("INSERT INTO payments (child_name, amount) VALUES ('$child', '$amount')");
  echo "<script>alert('Payment Recorded'); window.location='bursar.php';</script>";
}

$payments = $conn->query("SELECT * FROM payments ORDER BY id DESC");
$total = $conn->query("SELECT SUM(amount) as total FROM payments")->fetch_assoc()['total'];
if ($total == "") $total = 0;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bursar Dashboard - Fairway</title>
  <link rel="stylesheet" href="style.css">
  <style>
  p,h2,h3{
	color:yellow;
}
</style>
</head>
<body>
<div class="main-content">
<a href="report.php"><button style="background-color:yellow; color:red;">Fees Report</button></a>
  <h2>Welcome Bursar: <?php echo $_SESSION['full_name']; ?></h2>
  <h3>Total Collected: UGX <?php echo number_format($total); ?></h3>

  <h3>Record New Payment</h3>
  <form method="POST">
    <input type="text" name="child_name" placeholder="Child Name" required>
    <input type="number" name="amount" placeholder="Amount UGX" required>
    <button type="submit" name="payBtn">Save Payment</button>
  </form>

  <h3>Payment History</h3>
  <input type="text" id="searchBox" placeholder="Search by name, class, phone..." onkeyup="searchTable()"
  <table id="studentsTable" border="1">
    <tr><th>Child</th><th>Amount</th><th>Date</th></tr>
    <?php while($p = $payments->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $p['child_name']; ?></td>
        <td><?php echo number_format($p['amount']); ?></td>
        <td><?php echo $p['payment_date']; ?></td>
      </tr>
    <?php } ?>
  </table>
  <a href="logout.php"><button style="background-color:red;">Logout</button></a>
</div>
<script src="script.js"></script>
</body>
</html>