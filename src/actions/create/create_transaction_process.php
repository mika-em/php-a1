<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
  header('Location: /errors/error.php?type=user_only');
  exit;
}
spl_autoload_register(function ($class_name) {
  include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});
require_once("../../utils.php");



if (isset($_POST['submit'])) {
  $date = sanitize_input($_POST['Date']);
  $credit = sanitize_input($_POST['Credit']);
  $debit = sanitize_input($_POST['Debit']);
  $description = sanitize_input($_POST['Description']);
  $bucketId = Transaction::getBucketIdForKeyword($description);
  $user_id = $_SESSION['user_id'];
  $bucketId = Transaction::getBucketIdForKeyword($user_id);




  if (Transaction::create($date, $credit, $debit, $description, $bucketId)) {
    header("Location: ../../actions/display/display.php?message=Transaction+Created+Successfully");
  } else {
    header("Location: create_transaction.php?error=Unable+to+create+transaction");
  }
} else {
  header("Location: create_transaction.php?error=Form+submission+failed");
}
