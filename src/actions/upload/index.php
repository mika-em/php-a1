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

$allowedFileTypes = ['csv'];
$errorMessages = [];

if (isset($_POST["submit"])) {
  $file = $_FILES["fileToUpload"]["tmp_name"];
  $fileName = basename($_FILES["fileToUpload"]["name"]);
  $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

  if (!in_array($fileExtension, $allowedFileTypes)) {
    $errorMessages[] = "Error: Invalid file format. Only CSV files are allowed.";
  }

  if ($_FILES["fileToUpload"]["error"] > 0) {
    $errorMessages[] = "Error: There was an error uploading your file.";
  }

  if (empty($errorMessages)) {
    $destination = $_SERVER['DOCUMENT_ROOT'] . '/actions/upload/' . $fileName;
    if (move_uploaded_file($file, $destination)) {
      $insertedTransactions = Transaction::importFromCSV($destination);
      rename($destination, $destination . '.imported');
      header('Location: /actions/display/display.php');
      exit;
    } else {
      $errorMessages[] = "Sorry, there was an error uploading your file.";
    }
  }
}

include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_header.php");
?>

<div class="container mt-4">
  <?php foreach ($errorMessages as $message) : ?>
    <div class="alert alert-danger" role="alert">
      <?= htmlspecialchars($message); ?>
    </div>
  <?php endforeach; ?>

  <form action="index.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
      <label for="fileToUpload">Select CSV File to Upload:</label>
      <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload" required>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Upload File</button>
  </form>
</div>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_footer.php"); ?>