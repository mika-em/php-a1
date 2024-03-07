<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($_SESSION['user_id'])) {
  header('location: /');
  exit;
}
spl_autoload_register(function ($class_name) {
  include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});
require_once("../../utils.php");


Database::getConnection();

if (isset($_POST['submit'])) {
  $transactionId = sanitize_input($_POST['transactionId']);
  $date = sanitize_input($_POST['Date']);
  $debit = sanitize_input($_POST['Debit']);
  $credit = sanitize_input($_POST['Credit']);
  $description = sanitize_input($_POST['Description']);
  $bucketId = Transaction::getBucketIdForKeyword($description);
  $success = Transaction::update($transactionId, $date, $credit, $debit, $description, $bucketId);

  if ($success) {
    header('Location: ../../actions/display/display.php?message=Transaction updated successfully');
  } else {
    header('Location: update_transaction.php?id=' . $transactionId . '&error=Unable to update the transaction');
  }
  exit;
}
?>
