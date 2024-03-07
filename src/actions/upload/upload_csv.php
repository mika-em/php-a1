<?php
ob_start();
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'user') {
  header('Location: /errors/error.php?type=user_only');
  exit;
}
include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_header.php");
echo '<a href="/dashboard/user_dashboard.php" class="btn btn-primary mt-5">Back To User Dashboard</a>';
echo '<br>';
echo '<br>';
?>

<div class="container mt-4"></div>
<form action="index.php" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="fileToUpload">Select CSV File to Upload:</label>
    <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload" required>
  </div>
  <button type="submit" class="btn btn-primary" name="submit">Upload File</button>
</form>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_footer.php"); ?>