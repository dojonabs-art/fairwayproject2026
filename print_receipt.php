<?php
session_start();
include "config.php";
include "authentic.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.html");
    exit();
}

requireRole(["Bursar", "Director", "Secretary", "Headteacher"]);

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    die("Invalid payment ID");
}

$stmt = $conn->prepare("SELECT * FROM payments WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$payment = $stmt->get_result()->fetch_assoc();

if (!$payment) {
    die("Payment not found");
}

$child_name = $payment['child_name'] ?? '';
$amount_paid = floatval($payment['amount'] ?? 0);
$payment_date = $payment['payment_date'] ?? date('Y-m-d');
$term = $payment['term'] ?? '';
$status = $payment['status'] ?? 'success';

// Set your expected fees per term here
$expected_fees = 500000;
$balance = max(0, $expected_fees - $amount_paid);
$receipt_no = "RCP-" . date('Ymd') . $payment['id'];
?>
<!DOCTYPE html>
<html>
<head>
<title>Official Fees Receipt</title>
<style>
  body { font-family: Arial, sans-serif; padding: 20px; }
  .receipt { border: 2px solid #000; padding: 20px; width: 600px; margin: auto; }
  h2 { text-align: center; margin-bottom: 5px; }
  .center { text-align: center; }
  hr { border: 1px solid #000; }
  .row { margin: 10px 0; }
  .sign { margin-top: 40px; display: flex; justify-content: space-between; }
</style>
</head>
<body onload="window.print()">

<div class="receipt">
  <h2>FAIRWAY PRIMARY SCHOOL GGANDa</h2>
  <p class="center">Official Fees Receipt</p>
  <hr>

  <div class="row"><strong>Receipt No:</strong> <?php echo htmlspecialchars($receipt_no); ?></div>
  <div class="row"><strong>Date:</strong> <?php echo htmlspecialchars($payment_date); ?></div>
  <div class="row"><strong>Child Name:</strong> <?php echo htmlspecialchars($child_name); ?></div>
  <div class="row"><strong>Term:</strong> <?php echo htmlspecialchars($term); ?></div>
  <div class="row"><strong>Status:</strong> <?php echo htmlspecialchars(ucfirst($status)); ?></div>
  <hr>
  <div class="row"><strong>Amount Paid: UGX</strong> <?php echo number_format($amount_paid); ?></div>
  <div class="row"><strong>Balance: UGX</strong> <?php echo number_format($balance); ?></div>
  <hr>

  <div class="sign">
    <div>Received By (Bursar): ___________________</div>
    <div>Stamp: _______________</div>
  </div>
  <p style="font-size:12px; margin-top:20px;">Fees payable ONLY at School Cash Office. Keep this receipt.</p>
</div>

</body>
</html>