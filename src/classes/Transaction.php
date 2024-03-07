<?php


class Transaction
{
  public static function fetchAll()
  {
    $user_id = $_SESSION['user_id'];

    $db = Database::getConnection();
    $stmt = $db->prepare('SELECT transactions.*, buckets.category FROM transactions LEFT JOIN buckets ON bucket_id = id WHERE user_id = ?');
    $stmt->bindValue(1, $user_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $transactions = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $transactions[] = $row;
    }
    return $transactions;
  }

  public static function fetchUncategorized()
  {
    $user_id = $_SESSION['user_id'];

    $db = Database::getConnection();
    $stmt = $db->prepare('SELECT transactions.*, buckets.category FROM transactions LEFT JOIN buckets ON bucket_id = id WHERE user_id = ? AND bucket_id = 11');
    $stmt->bindValue(1, $user_id, SQLITE3_INTEGER);
    $result = $stmt->execute();

    $transactions = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $transactions[] = $row;
    }
    return $transactions;
  }

  public static function getBucketIdForKeyword($description)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('SELECT bucket_id, keyword FROM keywords');
    $result = $stmt->execute();

    $description = strtoupper($description);

    while ($row = $result->fetchArray()) {
      if (strpos($description, strtoupper($row['keyword'])) !== false) {
        return $row['bucket_id'];
      }
    }

    return 0;
  }

  public static function importFromCSV($filePath)
  {
    $db = Database::getConnection();
    $insertedTransactions = [];

    if (($handle = fopen($filePath, "r")) !== FALSE) {
      fgetcsv($handle);
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $date = DateTime::createFromFormat('m/d/Y', $data[0])->format('Y-m-d');
        $description = $data[1];
        $credit = $data[2];
        $debit = $data[3];
        $bucket_id = self::getBucketIdForKeyword($description);

        $stmt = $db->prepare('INSERT INTO transactions (date, credit, debit, description, bucket_id, user_id) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bindValue(1, $date, SQLITE3_TEXT);
        $stmt->bindValue(2, $credit, SQLITE3_FLOAT);
        $stmt->bindValue(3, $debit, SQLITE3_FLOAT);
        $stmt->bindValue(4, $description, SQLITE3_TEXT);
        $stmt->bindValue(5, $bucket_id, SQLITE3_INTEGER);
        $stmt->bindValue(6, $_SESSION['user_id'], SQLITE3_INTEGER);
        $stmt->execute();

        $insertedTransactions[] = [
          'date' => $date,
          'description' => $description,
          'credit' => $credit,
          'debit' => $debit,
          'bucket_id' => $bucket_id
        ];
      }
      fclose($handle);
    }

    return $insertedTransactions;
  }

  public static function update($transactionId, $date, $credit, $debit, $description, $bucket_id)
  {
    $db = Database::getConnection();
    $bucket_id = self::getBucketIdforKeyword($description);
    $stmt = $db->prepare('UPDATE transactions SET date = ?, debit = ?, credit = ?, description = ?, bucket_id = ?  WHERE transaction_id = ?');
    $stmt->bindValue(1, $date, SQLITE3_TEXT);
    $stmt->bindValue(2, $debit, SQLITE3_FLOAT);
    $stmt->bindValue(3, $credit, SQLITE3_FLOAT);
    $stmt->bindValue(4, $description, SQLITE3_TEXT);
    $stmt->bindValue(5, $bucket_id, SQLITE3_INTEGER);
    $stmt->bindValue(6, $transactionId, SQLITE3_INTEGER);
    return $stmt->execute() ? true : false;
  }

  public static function findById($transactionId)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('SELECT * FROM transactions WHERE transaction_id = ?');
    $stmt->bindValue(1, $transactionId, SQLITE3_INTEGER);
    $result = $stmt->execute();
    return $result->fetchArray(SQLITE3_ASSOC);
  }

  public static function delete($transactionId)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare("DELETE FROM transactions WHERE transaction_id = ?");
    $stmt->bindValue(1, $transactionId, SQLITE3_INTEGER);
    return $stmt->execute() ? true : false;
  }

  public static function create($date, $credit, $debit, $description)
  {
    $db = Database::getConnection();
    $bucket_id = self::getBucketIdforKeyword($description);
    $user_id = $_SESSION['user_id'];
    $stmt = $db->prepare('INSERT INTO transactions (date, credit, debit, description, bucket_id, user_id) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bindValue(1, $date, SQLITE3_TEXT);
    $stmt->bindValue(2, $credit, SQLITE3_FLOAT);
    $stmt->bindValue(3, $debit, SQLITE3_FLOAT);
    $stmt->bindValue(4, $description, SQLITE3_TEXT);
    $stmt->bindValue(5, $bucket_id, SQLITE3_INTEGER);
    $stmt->bindValue(6, $user_id, SQLITE3_INTEGER);
    return $stmt->execute() ? true : false;
  }

  public static function recategorize()
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('SELECT * FROM transactions');
    $result = $stmt->execute();

    $recategorizedTransactions = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $bucket_id = self::getBucketIdForKeyword($row['description']);
      $stmt = $db->prepare('UPDATE transactions SET bucket_id = ? WHERE transaction_id = ?');
      $stmt->bindValue(1, $bucket_id, SQLITE3_INTEGER);
      $stmt->bindValue(2, $row['transaction_id'], SQLITE3_INTEGER);
      $stmt->execute();

      $recategorizedTransactions[] = $row;
    }

    return $recategorizedTransactions;
  }
}
