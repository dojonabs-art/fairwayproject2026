<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

function requireLogin() {
  if (!isset($_SESSION['user_id'])) {
    header("Location: login_page.html");
    exit();
  }
}

function requireRole($allowedRoles) {
  requireLogin();

  // Make role check case-insensitive: "Director" = "director"
  $currentRole = strtolower(trim($_SESSION['role'] ?? ''));
  $allowed = array_map(function($r) {
      return strtolower(trim($r));
  }, $allowedRoles);

  if (!in_array($currentRole, $allowed)) {
    die("Access Denied. You are logged in as " . htmlspecialchars($_SESSION['role']));
  }
}

// Optional: call this on every dashboard page to block unapproved staff
function requireApproved($conn) {
  requireLogin();

  $user_id = intval($_SESSION['user_id']);
  $stmt = $conn->prepare("SELECT status FROM users WHERE user_id = ?");
  $stmt->bind_param("i", $user_id);
  $stmt->execute();
  $user = $stmt->get_result()->fetch_assoc();

  if (!$user || $user['status'] !== 'approved') {
    session_destroy();
    header("Location: login_page.html");
    exit();
  }
}
?>