<?php
spl_autoload_register(function ($class_name) {
  include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});
require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/Database.php");

try {
  $db = Database::getConnection();
  Database::initializeTables();
  Database::insertKeywordDataFromCSV();
  Database::insertCSVDataIntoBuckets();
  Admin::initalizeAdminUsers();
} catch (Exception $e) {
  echo "<p>" . $e->getMessage() . "</p>";
}

