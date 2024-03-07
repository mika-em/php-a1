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
require_once("../../utils.php");
Database::getConnection();

if (isset($_POST['submit'])) {
  $keyword = sanitize_input($_POST['Keyword']);
  $bucket_id = sanitize_input($_POST['Bucket_Id']);

  if (Keyword::create($keyword, $bucket_id)) {
    header("Location: /actions/admin/manage_keywords.php?message=Keyword+Created+Successfully");
  } else {
    header("Location: create_keyword.php?error=Unable+to+create+keyword");
  }
} else {
  header("Location: create_keyword.php?error=Form+submission+failed");
}
