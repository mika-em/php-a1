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
  require $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});
require_once("../../utils.php");

Database::getConnection();

if (isset($_POST['submit'])) {
  $keywordId = sanitize_input($_POST['keywordId']);
  $keyword = sanitize_input($_POST['Keyword']);
  $bucketId = sanitize_input($_POST['bucketId']);
  $success = Keyword::update($keywordId, $keyword, $bucketId);

  if ($success) {
    header('Location: ../../actions/admin/manage_keywords.php?message=Keyword updated successfully');
  } else {
    header('Location: update_bucket.php?id=' . $bucketId . '&error=Unable to update the keyword');
  }
  exit;
}
