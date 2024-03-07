<?php
spl_autoload_register(function ($class_name) {
  include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});

class Admin extends User
{

  private static function getAdmins()
  {
    return [
      ['email' => 'mika@bcit.com', 'password' => password_hash('mika', PASSWORD_DEFAULT), 'role' => 'admin', 'is_approved' => 1],
      ['email' => 'cheryl@bcit.com', 'password' => password_hash('cheryl', PASSWORD_DEFAULT), 'role' => 'admin', 'is_approved' => 1],
      ['email' => 'cheryl@user.com', 'password' => password_hash('cheryl', PASSWORD_DEFAULT), 'role' => 'user', 'is_approved' => 1],
      ['email' => 'mika@user.com', 'password' => password_hash('mika', PASSWORD_DEFAULT), 'role' => 'user', 'is_approved' => 1],
      ['email' => 'aa@aa.aa', 'password' => password_hash('P@$$w0rd', PASSWORD_DEFAULT), 'role' => 'admin', 'is_approved' => 1],

    ];
  }

  public static function initalizeAdminUsers()
  {
    $db = Database::getConnection();
    $checkAdminsExist = "SELECT COUNT(*) FROM users WHERE role = 'admin'";
    $adminCount = $db->querySingle($checkAdminsExist);
    if ($adminCount == 0) {
      $admins = self::getAdmins();
      $insertAdminSQL = "INSERT INTO users (email, password, role, is_approved) VALUES (:email, :password, :role, :is_approved)";
      $stmt = $db->prepare($insertAdminSQL);

      foreach ($admins as $admin) {
        $stmt->bindValue(':email', $admin['email'], SQLITE3_TEXT);
        $stmt->bindValue(':password', $admin['password'], SQLITE3_TEXT);
        $stmt->bindValue(':role', $admin['role'], SQLITE3_TEXT);
        $stmt->bindValue(':is_approved', $admin['is_approved'], SQLITE3_INTEGER);
        $stmt->execute();
      }
    }
  }

  public static function createAdmin($email, $password)
  {
    return parent::register($email, $password, 'admin', 1);
  }

  public static function approveUser($userId)
  {
    $db = Database::getConnection();
    $stmt = $db->prepare('UPDATE users SET is_approved = 1 WHERE id = :id');
    $stmt->bindValue(':id', $userId, SQLITE3_INTEGER);
    return $stmt->execute();
  }
}
