<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  header('Location: /errors/error.php?type=admin_only');
  exit;
}

require_once($_SERVER['DOCUMENT_ROOT'] . "/inc_header.php");
spl_autoload_register(function ($class_name) {
  require $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});
include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_db.php");

if (isset($_GET['message'])) {
  echo "<p class='success'>{$_GET['message']}</p>";
}
if (isset($_GET['error'])) {
  echo "<p class='error'>{$_GET['error']}</p>";
}

echo "<h2>Bucket Records</h2>";
echo "<div class='d-flex justify-content-start'>";
echo "<a href='../../dashboard/admin_dashboard.php' class='btn btn-primary'>Back To Dashboard</a>";
echo "<div class='mx-2'>";
echo "<a href='/actions/create/create_bucket.php' class='btn btn-success'>Create New Bucket</a>";
echo "</div>";
echo "</div>";
echo "<br/>";
include_once($_SERVER['DOCUMENT_ROOT'] . "/tables/buckets.php");
displayBuckets(false);


?>
<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_footer.php"); ?>