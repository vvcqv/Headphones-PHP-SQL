<?php session_start();
if ($_SESSION['user']) {
    header('Location: /');
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Регистрация</title>
</head>

<body>
    <?php include 'header.php';
    require_once('assets/php/connection.php');
    ?>
    <form action="/assets/php/user/reguser.php" method="post" style="text-align: center;">
        <input type="email" name="email" placeholder="E-mail@email.ru" class="auth" required><br><br>
        <input type="text" name="login" placeholder="Логин" class="auth" required><br><br>
        <input type="password" name="password" placeholder="Пароль" class="auth" required><br><br>
        <input type="submit" value="Зарегистрироваться">
        <?php
        if ($_SESSION['message']) {
            echo ('
            <p style="color:green;">
            ' . $_SESSION['message'] . '
            </p>
            ');
            unset($_SESSION['message']);
        }
        ?>
    </form>
</body>

</html>