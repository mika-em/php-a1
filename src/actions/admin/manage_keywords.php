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

if (isset($_GET['message'])) {
  echo "<p class='success'>{$_GET['message']}</p>";
}
if (isset($_GET['error'])) {
  echo "<p class='error'>{$_GET['error']}</p>";
}


include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_db.php");
$keywords = Keyword::fetchAll();
$dashboardUrl = "../../dashboard/admin_dashboard.php";
$addKeywordUrl = "/actions/create/create_keyword.php";
echo "<h2>Keyword Records</h2>";
echo "<div class='d-flex justify-content-start'>";
echo "<a href='" . htmlspecialchars($dashboardUrl) . "' class='btn btn-primary'>Back To Dashboard</a>";
echo "<div class='mx-2'>";
echo "<a href='" . htmlspecialchars($addKeywordUrl) . "' class='btn btn-success'>Add New Keyword</a>";
echo "</div>";
echo "</div>";
echo "<br/>";
if (!empty($keywords)) {
  echo "<table width='100%' class='table table-striped'>";
  echo "<thead>";
  echo "<tr>";
  echo "<th>ID</th>";
  echo "<th>Keyword</th>";
  echo "<th>Category</th>";
  echo "<th>Actions</th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody>";
  foreach ($keywords as $keyword) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($keyword['id']) . "</td>";
    echo "<td>" . htmlspecialchars($keyword['keyword']) . "</td>";
    echo "<td>" . htmlspecialchars($keyword['category']) . "</td>";
    echo "<td>";
    echo "<a href='/actions/update/update_keyword.php?id=" . htmlspecialchars($keyword['id']) . "' class='btn btn-dark'>Edit</a> ";
    echo "<a href='/actions/delete/delete_keyword.php?id=" . htmlspecialchars($keyword['id']) . "' class='btn btn-danger'>Delete</a>";
    echo "</td>";
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";
} else {
  echo "<p>No keyword records found.</p>";
}
?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_footer.php"); ?>