<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header('Location: /errors/error.php?type=admin_only');
  exit;
}

include("../../inc_header.php");
spl_autoload_register(function ($class_name) {
  include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});
Database::getConnection();

if (isset($_POST['keywordId'])) {
  $keywordId = $_POST['keywordId'];
  if (Keyword::delete($keywordId)) {
    header('Location: ../../actions/admin/manage_keywords.php?message=Keyword deleted successfully');
  } else {
    header("Location: ../../actions/admin/manage_keywords.php?error=Unable+to+delete+keyword");
  }
} else {
  header("Location: ../../dashboard/admin_dashboard.php?error=No+keyword+ID+provided");
}
