<?php
session_start();
include "config.php";
$role = strtolower(trim($_SESSION['role'] ?? ''));
if (!in_array($role, ['headteacher', 'director'])) {
    die("Access denied. Only Headteacher/Director can approve staff. Your role is: " . htmlspecialchars($_SESSION['role'] ?? 'NOT SET'));
}
// Handle approve
if (isset($_GET['approve'])) {
    $id = (int)$_GET['approve'];
    $stmt = $conn->prepare("UPDATE users SET status='active', approved_by=?, approved_at=NOW() WHERE id=?");
    $stmt->bind_param("si", $_SESSION['username'], $id);
    $stmt->execute();
    header("Location: approve_staff.php?success=1");
    exit;
}

// Handle reject
if (isset($_GET['reject'])) {
    $id = (int)$_GET['reject'];
    $stmt = $conn->prepare("UPDATE users SET status='rejected' WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: approve_staff.php?rejected=1");
    exit;
}

$pending = $conn->query("SELECT id, full_name, role, created_at FROM users WHERE status='pending' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Approve Staff - Fairway MIS</title>
<link rel="stylesheet" href="style1.css">
</head>
<body>
<header><h1>Fairway Nursery and Primary School</h1></header>

<nav>
  <a href="index1.php">Home</a>
  <a href="admission.html">Admission</a>
  <a href="approve_staff.php">Approve New Staff</a>
  <a href="logout.php">Logout</a>
</nav>

<center><div class="container" style="background:white; padding:30px; border-radius:15px; margin:20px;">
  <h2>Pending Staff Registrations</h2>
  <?php if (isset($_GET['success'])) echo "<p style='color:green;'>Staff approved successfully.</p>"; ?>
  <?php if (isset($_GET['rejected'])) echo "<p style='color:red;'>Staff rejected.</p>"; ?>

  <table border="1" cellpadding="8" style="border-collapse:collapse; width:100%;">
    <tr><th>Name</th><th>Role</th><th>Date</th><th>Action</th></tr>
    <?php if ($pending && $pending->num_rows > 0): ?>
      <?php while ($row = $pending->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
        <td><?php echo htmlspecialchars($row['role']); ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td>
          <a href="approve_staff.php?approve=<?php echo $row['id']; ?>">Approve</a> |
          <a href="approve_staff.php?reject=<?php echo $row['id']; ?>" onclick="return confirm('Reject this staff?')">Reject</a>
        </td>
      </tr>
      <?php endwhile; ?>
    <?php else: ?>
      <tr><td colspan="4">No pending staff registrations.</td></tr>
    <?php endif; ?>
  </table>
</div></center>
<footer style="background:#0b3d2e; color:white; padding:30px 20px; margin-top:40px; font-family:Arial, sans-serif;">
  <div style="max-width:1100px; margin:auto; display:flex; flex-wrap:wrap; gap:30px; justify-content:space-between;">
    
    <div style="min-width:250px;">
      <h3 style="margin-top:0;">Fairway Primary School Gganda</h3>
      <p>Quality education with discipline and care.</p>
      <a href="terms.php" style="color:#ffd700; text-decoration:none;">Terms &amp; Conditions</a>
    </div>

    <div style="min-width:250px;">
      <h3 style="margin-top:0;">Contact Us</h3>
      <p>Tel: 0700442188 / 0701686997</p>
      <p>Email: <a href="mailto:fairwayprimaryschoolgganda@gmail.com" style="color:white;">fairwayprimaryschoolgganda@gmail.com</a></p>
    </div>

    <div style="min-width:200px;">
      <h3 style="margin-top:0;">Follow Us</h3>
      <a href="https://www.tiktok.com/@fairwaynpschoolgganda?_r=1&_t=ZS-9BQksJEzcV2" target="_blank" style="color:white; text-decoration:none; display:inline-flex; align-items:center; gap:8px;">
        <!-- TikTok Logo -->
        <svg width="24" height="24" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
          <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
        </svg>
        TikTok
      </a>
      <p style="font-size:13px; margin-top:8px;">@fairwaynpschoolgganda</p>
    </div>

  </div>
  <div style="text-align:center; margin-top:25px; font-size:13px; border-top:1px solid rgba(255,255,255,0.2); padding-top:15px;">
    © 2026 Fairway Primary School Gganda. All rights reserved.
  </div>
</footer>
</body>
</html>