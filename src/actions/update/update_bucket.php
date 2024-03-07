<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header('Location: /errors/error.php?type=admin_only');
  exit;
}

include("../../inc_header.php");
require_once("../../classes/Bucket.php");
require_once("../../classes/Database.php");
Database::getConnection();

if (isset($_GET['id'])) {
  $bucketId = $_GET['id'];
  $bucket = Bucket::findById($bucketId);

  if ($bucket) {
?>
    <h1>Update Bucket</h1>
    <form action="update_bucket_process.php" method="post">
      <input type="hidden" name="bucketId" value="<?php echo htmlspecialchars($bucket['id']); ?>">

      <div class="form-group">
        <label for="Category" class="control-label">Category</label>
        <input type="text" class="form-control" name="Category" id="Category" value="<?php echo htmlspecialchars($bucket['category']); ?>">
      </div>

      <div class="form-group">
        <label for="Description" class="control-label">Description</label>
        <input type="text" class="form-control" name="Description" id="Description" value="<?php echo htmlspecialchars($bucket['description']); ?>">
      </div>

      <div class="form-group">
        <a href="../../actions/display/display.php" class="btn btn-small btn-primary">&lt;&lt; BACK</a>
        <input type="submit" value="Update" name="submit" class="btn btn-warning">
      </div>
    </form>
<?php
  } else {
    echo "<p>Bucket with ID $bucketId not found.</p>";
  }
} else {
  echo "<p>No bucket ID provided.</p>";
}

include("../../inc_footer.php");
?>