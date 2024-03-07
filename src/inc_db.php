<?php
spl_autoload_register(function ($class_name) {
  include $_SERVER['DOCUMENT_ROOT'] . '/src/classes/' . $class_name . '.php';
});

try {
  $db = Database::getConnection();
  Database::initializeTables();
  Database::insertKeywordDataFromCSV();
  Database::insertCSVDataIntoBuckets();
  Admin::initalizeAdminUsers();
} catch (Exception $e) {
  echo "<p>" . $e->getMessage() . "</p>";
}
