<?php
session_start();
require_once('../connection.php');
$login = $_POST['login'];
$password = md5($_POST['password']);
$query = $pdo->prepare("SELECT * FROM `users` WHERE `login`=:login AND `passw`=:passw");
$query->execute(array(
    'login' => $login,
    'passw' => $password,
));
$query->setFetchMode(PDO::FETCH_ASSOC);
$row = $query->fetch();
if ($row['user_id'] > 0) {
    $_SESSION['message'] = 'Авторизация прошла успешно';
    $_SESSION['user'] = $row['login'];
} else {
    $_SESSION['message'] = 'Неверный логин или пароль';
}

header('Location: /auth.php');
