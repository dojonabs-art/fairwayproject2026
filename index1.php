<?php session_start(); 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Fairway Nursery and Primary School - MIS</title>
  <link rel="stylesheet" href="style1.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Roboto&display=swap" rel="stylesheet">
</head>
<body>

<div class="layout">

  <!-- MAIN CONTENT ON LEFT -->
  <div class="main-content">
    <button class="menu-btn no-print" onclick="toggleSidebar()">Menu</button>

    <header>
      <h1>Fairway Nursery and Primary School</h1>
      <p>School Management System - Admitting Children</p>
    </header>

    <div class="stat1">
      <div class="img1">
        <img class="img_edit" src="candidates1.jpg" alt="Candidates 2023">
      </div>
      <hr>
      <div class="comment_img1">
        <p>Fairway Primary School Dedication day 2023 candidates as they prepared for their Final examinations.</p>

        <u><h2>VISION &amp; MISSION</h2></u>
        <h3 style="color:#4F5B2A;"><i>"To be a leading educational community that nurtures self-reliant, skilled and morally upright citizens."</i></h3>

        <u><h2>SCHOOL SLOGAN</h2></u>
        <h3 style="color:#4F5B2A;"><i>"Actions Not Words"</i></h3>

        <u><h2>SCHOOL MOTTO</h2></u>
        <h3 style="color:#4F5B2A;"><i>"In God, We Succeed"</i></h3>

        <h2 style="color:grey; text-align:center;">At Fairway We Strive For Excellence</h2>
      </div>
    </div>

    <hr>

    <h1 style="text-align:center; color:#333;">DIRECTOR</h1>
    <h2 style="text-align:center; color:#333;">FAIRWAY NURSERY AND PRIMARY SCHOOL GGANDA NASERE NANSANA</h2>
    <hr>
    <center><img class="img_edit_director" src="director.jpg" alt="Director"></center>
  </div>

  <!-- SIDEBAR ON RIGHT -->
  <div id="sidebar" class="sidebar">
    <h3>Fairway MIS</h3>

    <details open>
      <summary>Main</summary>
      <a href="index1.php">Home</a>
      <?php if (isset($_SESSION['role'])): ?>
        <a href="logout.php">Logout (<?php echo $_SESSION['role']; ?>)</a>
      <?php else: ?>
        <a href="login_page.html">Login</a>
        <a href="register_page.html">Register staff</a>
      <?php endif; ?>
    </details>

    <details>
      <summary>Admissions</summary>
      <a href="admission.html">Admission</a>
      <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ["Secretary", "Headteacher", "Director"])): ?>
        <a href="view_admissions.php">View Admissions</a>
      <?php endif; ?>
    </details>

    <details>
      <summary>Reports</summary>
      <?php if (isset($_SESSION['role'])): ?>
        <a href="admission_report.php">Admission Report</a>
        <a href="fees_report.php">Fees Report</a>
      <?php else: ?>
        <a href="login_page.html">Login to view Reports</a>
      <?php endif; ?>
    </details>

    <?php if (isset($_SESSION['role'])): ?>
    <details>
      <summary>Dashboards</summary>
      <?php if ($_SESSION['role'] == "Teacher"): ?>
        <a href="teacher.php">Teacher Dashboard</a>
      <?php endif; ?>
      <?php if ($_SESSION['role'] == "Headteacher"): ?>
        <a href="headteacher.php">Headteacher Dashboard</a>
      <?php endif; ?>
      <?php if ($_SESSION['role'] == "Director"): ?>
        <a href="director.php">Director Dashboard</a>
      <?php endif; ?>
      <?php if ($_SESSION['role'] == "Bursar"): ?>
        <a href="bursar.php">Bursar Dashboard</a>
      <?php endif; ?>
    </details>
    <?php endif; ?>

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
<script src="script.js"></script>
</body>
</html>