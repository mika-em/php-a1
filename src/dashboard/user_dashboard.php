<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_header.php");
// session_start();
if (!isset($_SESSION['user_role'])) {
  header("Location: /");
  exit();
} else if ($_SESSION['user_role'] !== 'admin' && basename($_SERVER['PHP_SELF']) === 'admin_dashboard.php') {
  header("Location: /");
  exit();
} else if ($_SESSION['user_role'] !== 'user' && basename($_SERVER['PHP_SELF']) === 'user_dashboard.php') {
  header("Location: /");
  exit();
}
?>

<h2>User Dashboard</h2>
<p>Welcome, <?= htmlspecialchars($_SESSION['user_email']) ?>! Here's what you can do:</p>

<ul>
  <li><a href="/actions/upload/upload_csv.php">Upload CSV File</a></li>
  <li><a href="/actions/display/display.php">View Transactions</a></li>
</ul>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_footer.php"); ?>