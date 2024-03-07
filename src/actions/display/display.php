<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($_SESSION['user_id'])) {
  header('location: /');
  exit;
}

include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_header.php");
spl_autoload_register(function ($class_name) {
  include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});
include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_db.php");

Transaction::recategorize();

if (isset($_GET['message'])) {
  echo "<p class='success'>{$_GET['message']}</p>";
}
if (isset($_GET['error'])) {
  echo "<p class='error'>{$_GET['error']}</p>";
}

$transactions = Transaction::fetchAll();
$otherTransactions = Transaction::fetchUncategorized();

echo "<br/><br/><br/>";
include("../../tables/transactions.php");

if ($otherTransactions) {
  echo "<h4>Uncategorized transactions, please contact administrator to add to categories.</h4>";
  displayTransactions($otherTransactions);
  echo "<br/><br/><br/>";
}

echo "<h2>Transaction Records</h2>";
echo "<a href='/actions/create/create_transaction.php' class='btn btn-success'>Create New Transaction</a><br/><br/>";
echo '<div class="d-flex">';
echo '<a href="/actions/summary" class="btn btn-info" style="margin-right: 10px;">Summary</a>';
echo '</div>';
displayTransactions($transactions);

include_once("../../inc_footer.php");
