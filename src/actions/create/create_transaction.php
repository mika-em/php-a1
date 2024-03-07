<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
  header('Location: /errors/error.php?type=user_only');
  exit;
}
include("../../inc_header.php");
?>

<h1>Create New Transaction</h1>
<form action="create_transaction_process.php" method="post">
  <div class="form-group">
    <label for="Date" class="control-label">Date</label>
    <input type="date" class="form-control" name="Date" id="Date" required>
  </div>

  <div class="form-group">
    <label for="Debit" class="control-label">Debit Amount</label>
    <input type="number" step="0.01" class="form-control" name="Debit" id="Debit" value="<?php echo $transaction['debit']; ?>">
  </div>
  <div class="form-group">
    <label for="Credit" class="control-label">Credit Amount</label>
    <input type="number" step="0.01" class="form-control" name="Credit" id="Credit" value="<?php echo $transaction['credit']; ?>">
  </div>

  <div class="form-group">
    <label for="Description" class="control-label">Description</label>
    <input type="text" class="form-control" name="Description" id="Description" required>
  </div>

  <div class="form-group">
    <input type="submit" value="Create" name="submit" class="btn btn-success">
    <a href="../../actions/display/display.php" class="btn btn-primary">&lt;&lt; BACK</a>
  </div>
</form>

<?php
include("../../inc_footer.php");
?>