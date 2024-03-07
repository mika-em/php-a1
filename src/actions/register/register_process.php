<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

spl_autoload_register(function ($class_name) {
    include $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $class_name . '.php';
});
require_once '../../utils.php';

if (isset($_POST['submit'])) {
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    $confirm_password = sanitize_input($_POST['confirm_password']);
    if ($password !== $confirm_password) {
        $message = urlencode("Passwords do not match.");
        header("Location: register.php?message={$message}");
        exit;
    }
    $existingUser = User::findByEmail($email);
    if ($existingUser) {
        $message = urlencode("A user with this email already exists.");
        header("Location: register.php?message={$message}");
        exit;
    }
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $registrationSuccess = User::register($email, $passwordHash);

    if ($registrationSuccess) {
        header("Location: register.php?success=1");
        exit;
    }
    header("Location: register.php?message={$message}");
    exit;
}
