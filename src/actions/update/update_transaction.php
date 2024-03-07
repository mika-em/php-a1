<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($_SESSION['user_id'])) {
  header('location: /');
  exit;
}
include($_SERVER['DOCUMENT_ROOT'] . "/inc_header.php");
spl_autoload_register(function ($class_name) {
  include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});

Database::getConnection();

if (isset($_GET['id'])) {
  $transactionId = $_GET['id'];
  $transaction = Transaction::findById($transactionId);
  if ($transaction) {
?>
    <h1>Update Transaction</h1>
    <form action="update_transaction_process.php" method="post">
      <input type="hidden" name="transactionId" value="<?php echo htmlspecialchars($transaction['transaction_id']); ?>">
      <div class="form-group">
        <label for="Date" class="control-label">Date</label>
        <input type="text" class="form-control" name="Date" id="date" value="<?php echo $transaction['date']; ?>">
      </div>
      <div class="form-group">
        <label for="Debit" class="control-label">Debit Amount</label>
        <input type="number" step="0.01" class="form-control" name="Debit" id="debit" value="<?php echo $transaction['debit']; ?>">
      </div>
      <div class="form-group">
        <label for="Credit" class="control-label">Credit Amount</label>
        <input type="number" step="0.01" class="form-control" name="Credit" id="credit" value="<?php echo $transaction['credit']; ?>">
      </div>
      <div class="form-group">
        <label for="Description" class="control-label">Description</label>
        <input type="text" class="form-control" name="Description" id="description" value="<?php echo $transaction['description']; ?>">
      </div>
      <div class="form-group">
        <a href="../../actions/display/display.php" class="btn btn-small btn-primary">&lt;&lt; BACK</a>
        <input type="submit" value="Update" name="submit" class="btn btn-warning">
      </div>
    </form>
<?php
  } else {
    echo "<p>Transaction with ID $transactionId not found.</p>";
  }
} else {
  echo "<p>No transaction ID provided.</p>";
}

include($_SERVER['DOCUMENT_ROOT'] . "/inc_footer.php");
?>