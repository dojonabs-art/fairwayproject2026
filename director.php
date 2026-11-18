<?php
session_start();
include "authentic.php";
requireRole(["Director"]);
include "config.php";


// TOTAL PUPILS
$totalResult = $conn->query("SELECT COUNT(*) as total FROM admissions");
$totalPupils = $totalResult->fetch_assoc()['total'] ?? 0;

// APPROVED / PENDING / REJECTED
$approved = $conn->query("SELECT COUNT(*) as total FROM admissions WHERE status='Approved'")->fetch_assoc()['total'] ?? 0;
$pending = $conn->query("SELECT COUNT(*) as total FROM admissions WHERE status='Pending Headteacher Approval'")->fetch_assoc()['total'] ?? 0;
$rejected = $conn->query("SELECT COUNT(*) as total FROM admissions WHERE status='Rejected'")->fetch_assoc()['total'] ?? 0;

// PUPILS BY CLASS
$classResult = $conn->query("SELECT className, COUNT(*) as total FROM admissions GROUP BY className ORDER BY FIELD(className,'Baby Class','Middle Class','Top Class','P.1','P.2','P.3','P.4','P.5','P.6','P.7')");
$classLabels = [];
$classData = [];
while ($row = $classResult->fetch_assoc()) {
  $classLabels[] = $row['className'];
  $classData[] = (int)$row['total'];
}

// PUPILS BY GENDER
$genderResult = $conn->query("SELECT gender, COUNT(*) as total FROM admissions GROUP BY gender");
$genderLabels = [];
$genderData = [];
while ($row = $genderResult->fetch_assoc()) {
  $genderLabels[] = $row['gender'];
  $genderData[] = (int)$row['total'];
}

// NURSERY VS PRIMARY
$nursery = $conn->query("SELECT COUNT(*) as total FROM admissions WHERE className IN ('Baby Class','Middle Class','Top Class')")->fetch_assoc()['total'] ?? 0;
$primary = $conn->query("SELECT COUNT(*) as total FROM admissions WHERE className IN ('P.1','P.2','P.3','P.4','P.5','P.6','P.7')")->fetch_assoc()['total'] ?? 0;

// RECENT ADMISSIONS
$recent = $conn->query("SELECT * FROM admissions ORDER BY created_at DESC LIMIT 10");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Director Dashboard - Fairway School</title>
  <link rel="stylesheet" href="style1.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .stats-container { display:flex; gap:20px; flex-wrap:wrap; margin:20px 0; }
    .stat-card { flex:1; min-width:160px; background:#f2f2f2; padding:20px; border-radius:8px; text-align:center; }
    .stat-card h3 { margin:0; font-size:15px; }
    .stat-card p { font-size:32px; font-weight:bold; margin:10px 0 0 0; color:#1a5c2e; }
    .charts-container { display:flex; gap:30px; flex-wrap:wrap; margin-top:30px; }
    .chart-box { flex:1; min-width:320px; background:#fff; padding:20px; border:1px solid #ddd; border-radius:8px; }

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

<div class="container">
  <h2>Director Dashboard</h2>
  <p>All school details below are loaded live from the database</p>

  <div class="stats-container">
    <div class="stat-card"><h3>Total Pupils</h3><p><?php echo $totalPupils; ?></p></div>
    <div class="stat-card"><h3>Approved</h3><p><?php echo $approved; ?></p></div>
    <div class="stat-card"><h3>Pending Approval</h3><p><?php echo $pending; ?></p></div>
    <div class="stat-card"><h3>Rejected</h3><p><?php echo $rejected; ?></p></div>
    <div class="stat-card"><h3>Nursery Pupils</h3><p><?php echo $nursery; ?></p></div>
    <div class="stat-card"><h3>Primary Pupils</h3><p><?php echo $primary; ?></p></div>
  </div>

  <div class="charts-container">
    <div class="chart-box">
      <h3>Number of Pupils by Class (Bar Chart)</h3>
      <canvas id="barChart"></canvas>
    </div>
    <div class="chart-box">
      <h3>Pupils by Gender (Pie Chart)</h3>
      <canvas id="genderPieChart"></canvas>
    </div>
  </div>

  <div class="charts-container">
    <div class="chart-box">
      <h3>Pupils by Class (Pie Chart)</h3>
      <canvas id="classPieChart"></canvas>
    </div>
    <div class="chart-box">
      <h3>Admission Status (Pie Chart)</h3>
      <canvas id="statusPieChart"></canvas>
    </div>
  </div>

  <div class="chart-box" style="margin-top:30px;">
    <h3>Recent Admissions</h3>
    <table>
      <tr><th>Admission No</th><th>Child Name</th><th>Gender</th><th>Class</th><th>Parent Phone</th><th>Status</th><th>Date</th></tr>
      <?php if ($recent && $recent->num_rows > 0): ?>
        <?php while ($row = $recent->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['admission_no']; ?></td>
            <td><?php echo $row['childName']; ?></td>
            <td><?php echo $row['gender']; ?></td>
            <td><?php echo $row['className']; ?></td>
            <td><?php echo $row['parentPhone']; ?></td>
            <td><?php echo $row['status']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
          <tr><td colspan="7">No admissions yet. Secretary needs to admit a child first.</td></tr>
      <?php endif; ?>
    </table>
  </div>

</div>

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

<script>
  const classLabels = <?php echo json_encode($classLabels); ?>;
  const classData = <?php echo json_encode($classData); ?>;
  const genderLabels = <?php echo json_encode($genderLabels); ?>;
  const genderData = <?php echo json_encode($genderData); ?>;

  // Bar Chart by Class
  new Chart(document.getElementById("barChart"), {
    type: "bar",
    data: {
      labels: classLabels,
      datasets: [{ label: "Number of Pupils", data: classData, backgroundColor: "#1a5c2e" }]
    },
    options: { responsive: true, scales: { y: { beginAtZero: true } } }
  });

  // Pie Chart by Gender
  new Chart(document.getElementById("genderPieChart"), {
    type: "pie",
    data: {
      labels: genderLabels.length ? genderLabels : ["No Data"],
      datasets: [{ data: genderData.length ? genderData : [1], backgroundColor: ["#e91e63", "#2196f3", "#9c27b0"] }]
    },
    options: { responsive: true, plugins: { legend: { position: "bottom" } } }
  });

  // Pie Chart by Class
  new Chart(document.getElementById("classPieChart"), {
    type: "pie",
    data: {
      labels: classLabels.length ? classLabels : ["No Data"],
      datasets: [{ data: classData.length ? classData : [1], backgroundColor: ["#1a5c2e","#2e7d32","#43a047","#66bb6a","#81c784","#ffb300","#fb8c00","#f4511e","#e91e63","#8e24aa"] }]
    },
    options: { responsive: true, plugins: { legend: { position: "right" } } }
  });

  // Pie Chart by Status
  new Chart(document.getElementById("statusPieChart"), {
    type: "pie",
    data: {
      labels: ["Approved", "Pending", "Rejected"],
      datasets: [{ data: [<?php echo $approved; ?>, <?php echo $pending; ?>, <?php echo $rejected; ?>], backgroundColor: ["#2e7d32", "#ffb300", "#c62828"] }]
    },
    options: { responsive: true, plugins: { legend: { position: "bottom" } } }
  });
</script>

</body>
</html>