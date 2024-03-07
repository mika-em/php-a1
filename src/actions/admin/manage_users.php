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
$keywords = Keyword::fetchAll();

echo "<h2>Manage User Buckets</h2>";
echo "<table class='table'>";
echo "<thead><tr><th>User Email</th><th>Action</th></tr></thead>";
echo "<tbody>";
foreach ($users as $user) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($user['email']) . "</td>";
    echo "<td><a href='/actions/admin/manage_buckets.php?user_id=" . $user['id'] . "' class='btn btn-primary'>Manage Buckets</a></td>";
    echo "</tr>";
}
echo "</tbody></table>";
?>

<?php include_once($_SERVER['DOCUMENT_ROOT'] . "/inc_footer.php"); ?>
