<!-- <form action="index.php" method="post" enctype="multipart/form-data">
  Select CSV File to Upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload File" name="submit">
</form> -->


<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
  session_start();
}
if (!isset($_SESSION['user_id'])) {
  header('location: /');
  exit;
}
include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_header.php");
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

