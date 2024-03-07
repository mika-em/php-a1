<?php
ob_start();
session_start();
session_unset();
$_SESSION = array();
session_destroy();
header('Location: /');
exit;
?>