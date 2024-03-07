<?php

class Bucket
{
  public static function fetchAll()
  {
    $db = Database::getConnection();
    $result = $db->query('SELECT * FROM buckets');
    $buckets = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $buckets[] = $row;
    }
    return $buckets;
  }

  public static function update($bucketId, $category, $description)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('UPDATE buckets SET category = ?, description = ? WHERE id = ?');
    $stmt->bindValue(1, $category, SQLITE3_TEXT);
    $stmt->bindValue(2, $description, SQLITE3_TEXT);
    $stmt->bindValue(3, $bucketId, SQLITE3_INTEGER);
    return $stmt->execute() ? true : false;
  }

  public static function findById($bucketId)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('SELECT * FROM buckets WHERE id = ?');
    $stmt->bindValue(1, $bucketId, SQLITE3_INTEGER);
    $result = $stmt->execute();
    return $result->fetchArray(SQLITE3_ASSOC);
  }

  public static function delete($bucketId)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('DELETE FROM keywords WHERE bucket_id = ?');
    $stmt->bindValue(1, $bucketId, SQLITE3_INTEGER);
    $stmt->execute();

    $stmt = $db->prepare('DELETE FROM buckets WHERE id = ?');
    $stmt->bindValue(1, $bucketId, SQLITE3_INTEGER);
    return $stmt->execute() ? true : false;
  }

  public static function create($category, $description)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('INSERT INTO buckets (category, description) VALUES (?, ?)');
    $stmt->bindValue(1, $category, SQLITE3_TEXT);
    $stmt->bindValue(2, $description, SQLITE3_TEXT);
    return $stmt->execute() ? true : false;
  }
}
