
<?php

require_once 'Database.php';
class User {
    public static function register($email, $password, $role = 'user', $is_approved = 0) {
        $db = Database::getConnection();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare('INSERT INTO users (email, password, role, is_approved) VALUES (:email, :password, :role, :is_approved)');
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':password', $hashedPassword, SQLITE3_TEXT);
        $stmt->bindValue(':role', $role, SQLITE3_TEXT);
        $stmt->bindValue(':is_approved', $is_approved, SQLITE3_INTEGER);
        return $stmt->execute();
    }

    public static function findByEmail($email) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
        return $result;
    }

    public static function isApproved($userId) {
        $db = Database::getConnection();
        $stmt = $db->prepare('SELECT is_approved FROM users WHERE id = :id');
        $stmt->bindValue(':id', $userId, SQLITE3_INTEGER);
        $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
        return $result && $result['is_approved'] == 1;
    }

    public static function fetchAllPendingApproval() {
        $db = Database::getConnection();
        $result = $db->query('SELECT * FROM users WHERE is_approved = 0');
        $users = [];
        while ($user = $result->fetchArray(SQLITE3_ASSOC)) {
            $users[] = $user;
        }
        return $users;
    }



    
}
