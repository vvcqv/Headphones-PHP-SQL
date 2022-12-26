<?php
session_start();
require_once('../connection.php');
$email = $_POST['email'];
$login = $_POST['login'];
$password = md5($_POST['password']);

$sql = "SELECT COUNT(*) FROM `users` WHERE `login`='$login' OR `email_addr`='$email'";
$query = $pdo->query($sql);
$count = $query->fetchColumn();

if ($count == 0) {
    $query = $pdo->prepare("INSERT INTO `users` (`login`, `passw`, `email_addr`) VALUES (:login, :passw, :email_addr)");
    $query->execute(array(
        'login' => $login,
        'passw' => $password,
        'email_addr' => $email
    ));
    $_SESSION['message'] = 'Регистрация прошла успешно';
    header('Location: ../../../reg.php');
} else {
    $_SESSION['message'] = 'E-mail или логин уже занят!';
    header('Location: ../../../reg.php');
}
