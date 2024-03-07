<?php
require_once 'Admin.php';
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
class Database
{
  private static $dbPath = '/db.sqlite';
  private static $dbInstance = null;

  private function __construct()
  {
  }
  private function __clone()
  {
  }
  public static function getConnection()
  {
    if (self::$dbInstance === null) {
      $fullPath = $_SERVER['DOCUMENT_ROOT'] . self::$dbPath;
      try {
        self::$dbInstance = new SQLite3($fullPath);
        self::initializeTables();
      } catch (Exception $e) {
        exit("Error connecting to the database: " . $e->getMessage());
      }
    }
    return self::$dbInstance;
  }
  public static function initializeTables()
  {
    $queries = [
      "CREATE TABLE IF NOT EXISTS buckets (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                category TEXT NOT NULL,
                description TEXT NOT NULL
            )",
      "CREATE TABLE IF NOT EXISTS transactions (
                transaction_id INTEGER PRIMARY KEY AUTOINCREMENT,
                date TEXT,
                credit REAL,
                debit REAL,
                description TEXT,
                bucket_id INTEGER,
                user_id INTEGER,
                FOREIGN KEY (bucket_id) REFERENCES buckets(id),
                FOREIGN KEY (user_id) REFERENCES users(id)
            )",
      "CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role TEXT NOT NULL DEFAULT 'user',
                is_approved BOOLEAN NOT NULL DEFAULT 0
            )",
      "CREATE TABLE IF NOT EXISTS keywords (
          id INTEGER PRIMARY KEY AUTOINCREMENT,
          keyword VARCHAR(255) UNIQUE NOT NULL,
          bucket_id INTEGER NOT NULL,
          FOREIGN KEY (bucket_id) REFERENCES buckets(id)
      )"
    ];
    foreach ($queries as $query) {
      self::$dbInstance->exec($query);
    }
  }

  public static function insertCSVDataIntoBuckets()
  {
    $exists = self::$dbInstance->querySingle("SELECT COUNT(*) FROM buckets");
    if ($exists == 0) {
      if (($handle = fopen($_SERVER['DOCUMENT_ROOT'] . "/import/Buckets.csv", "r")) !== FALSE) {

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          if (count($data) == 3) {
            $sql = "INSERT INTO buckets (id, category, description) VALUES (?, ?, ?)";
            $stmt = self::$dbInstance->prepare($sql);
            $stmt->bindValue(1, $data[0]);
            $stmt->bindValue(2, $data[1]);
            $stmt->bindValue(3, $data[2]);
            $stmt->execute();
          }
        }
        fclose($handle);
      }
    }
  }

  public static function insertMockDataIntoTransactions()
  {
    $exists = self::$dbInstance->querySingle("SELECT COUNT(*) FROM transactions");
    if ($exists == 0) {
      $sql = "INSERT INTO transactions (date, credit, description, bucket_id) VALUES
                ('2020-01-01', 100.00, 'Electric bill', 1),
                ('2020-01-02', 200.00, 'Water bill', 1),
                ('2020-01-03', 300.00, 'Gas bill', 1),
                ('2020-01-04', 400.00, 'Groceries', 2),
                ('2020-01-05', 500.00, 'Car payment', 3),
                ('2020-01-06', 600.00, 'Car maintenance', 3),
                ('2020-01-07', 700.00, 'Movie night', 4),
                ('2020-01-08', 800.00, 'Game night', 4),
                ('2020-01-09', 900.00, 'Other', 5)";
      self::$dbInstance->exec($sql);
    }
  }

  public static function insertKeywordDataFromCSV()
  {
    $exists = self::$dbInstance->querySingle("SELECT COUNT(*) FROM keywords");
    if ($exists == 0) {
      if (($handle = fopen($_SERVER['DOCUMENT_ROOT'] . "/import/Keywords.csv", "r")) !== FALSE) {

        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
          if (count($data) == 2) {
            $sql = "INSERT INTO keywords (keyword, bucket_id) VALUES (?, ?)";
            $stmt = self::$dbInstance->prepare($sql);
            $stmt->bindValue(1, $data[0]);
            $stmt->bindValue(2, $data[1]);
            $stmt->execute();
          }
        }
        fclose($handle);
      }
    }
  }
}
