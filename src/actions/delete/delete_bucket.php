<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($_SESSION['user_id'])) {
  header('location: /');
  exit;
}

include("../../inc_header.php");
spl_autoload_register(function ($class_name) {
  include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});
require_once("../../utils.php");
Database::getConnection();


if (isset($_GET['id'])) {
  $bucketId = $_GET['id'];
  echo "<h1>Delete Bucket</h1>";
  echo "<p>Are you sure you want to delete the bucket with ID: {$bucketId}?
  This will also delete any keywords associated with this bucket.
  </p>";
  echo "<form action='delete_bucket_process.php' method='post'>
            <input type='hidden' name='bucketId' value='{$bucketId}'>
            <input type='submit' value='Confirm' class='btn btn-danger'>
            <a href='../../actions/admin/manage_buckets.php' class='btn btn-primary'>Cancel</a>
        </form>";
} else {
  echo "<p>No bucket ID provided.</p>";
  echo "<a href='../../actions/admin/manage_buckets.php' class='btn btn-primary'>Go Back</a>";
}

include("../../inc_footer.php");
