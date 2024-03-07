<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_header.php");

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

<h2>Admin Dashboard</h2>
<p>Hello,
  <?php
  $email = $_SESSION['user_email'];
  if ($email === 'aa@aa.aa') {
    echo 'Admin';
  } else {
    echo htmlspecialchars($email);
  }
  ?>! Here's what you can do:</p>

<ul>
  <li><a href="../actions/admin/admin_process.php">Approve Users</a></li>
  <li><a href="../actions/admin/manage_buckets.php">Manage Users and Transaction Categories</a></li>
  <li><a href="../actions/admin/manage_keywords.php">Manage Keywords for CSV Upload</a></li>
</ul>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_footer.php"); ?>