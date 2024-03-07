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

if (isset($_GET['id'])) {
  $keywordId = $_GET['id'];
  $keyword = Keyword::findById($keywordId);

  if ($keyword) {
?>

    <h1>Update Keyword</h1>
    <form action="update_keyword_process.php" method="post">
      <div class="form-group">
        <label for="Keyword" class="control-label">Keyword</label>
        <input type="text" class="form-control" name="Keyword" id="Keyword" value="<?php echo htmlspecialchars($keyword['keyword']); ?>" required>
      </div>

      <div class="form-group">
        <label for="Bucket_Id" class="control-label">Bucket ID</label>
        <input type="text" class="form-control" name="Bucket_Id" id="Bucket_Id" value="<?php echo htmlspecialchars($keyword['bucket_id']); ?>" required>
      </div>



      <div class="form-group">
        <input type="submit" value="Update" name="submit" class="btn btn-success">
        <a href="../../actions/admin/manage_keywords.php" class="btn btn-primary">&lt;&lt; BACK</a>
      </div>
      <?php
      include($_SERVER['DOCUMENT_ROOT'] . "/tables/buckets.php");
      displayBuckets();
      ?>
    </form>
<?php
  } else {
    echo "<p>Keyword with ID $bucketId not found.</p>";
  }
} else {
  echo "<p>No keyword ID provided.</p>";
}

include("../../inc_footer.php");
?>