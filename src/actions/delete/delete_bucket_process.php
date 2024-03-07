<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header('Location: /errors/error.php?type=user_only');
  exit;
}

include("../../inc_header.php");
spl_autoload_register(function ($class_name) {
  include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});
Database::getConnection();

if (isset($_POST['bucketId'])) {
  $bucketId = $_POST['bucketId'];
  if (Bucket::delete($bucketId)) {
    header('Location: ../../actions/admin/manage_buckets.php?message=Bucket deleted successfully');
  } else {
    header("Location: ../../actions/admin/manage_buckets.php?error=Unable+to+delete+bucket");
  }
} else {
  header("Location: ../../dashboard/admin_dashboard.php?error=No+Bucket+ID+provided");
}
