<?php

class Keyword
{
  public static function fetchAll()
  {
    $db = Database::getConnection();
    $result = $db->query('SELECT keywords.*, buckets.category FROM keywords LEFT JOIN buckets ON bucket_id = buckets.id');
    $keywords = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
      $keywords[] = $row;
    }
    return $keywords;
  }

  public static function update($keywordId, $keyword, $bucketId)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('UPDATE keywords SET keyword = ?, bucket_id = ? WHERE id = ?');
    $stmt->bindValue(1, $keyword, SQLITE3_TEXT);
    $stmt->bindValue(2, $bucketId, SQLITE3_TEXT);
    $stmt->bindValue(3, $keywordId, SQLITE3_INTEGER);
    return $stmt->execute() ? true : false;
  }

  public static function findById($keywordId)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('SELECT * FROM keywords WHERE id = ?');
    $stmt->bindValue(1, $keywordId, SQLITE3_INTEGER);
    $result = $stmt->execute();
    return $result->fetchArray(SQLITE3_ASSOC);
  }

  public static function delete($keywordId)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('DELETE FROM keywords WHERE id = ?');
    $stmt->bindValue(1, $keywordId, SQLITE3_INTEGER);
    return $stmt->execute() ? true : false;
  }

  public static function create($keyword, $bucketId)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('INSERT INTO keywords (keyword, bucket_id) VALUES (?, ?)');
    $stmt->bindValue(1, $keyword, SQLITE3_TEXT);
    $stmt->bindValue(2, $bucketId, SQLITE3_TEXT);
    return $stmt->execute() ? true : false;
  }
}
