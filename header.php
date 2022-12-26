<?php
require_once('./assets/php/user/role.php');
require_once('./assets/php/user/privilegeduser.php');

if (isset($_SESSION['user'])) {
    $u = PrivilegedUser::getByUsername($_SESSION['user']);
}
?>
<link rel="stylesheet" href="assets/css/style.css">
<div class="header">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    </style>
    <link rel="stylesheet" href="assets/css/style.css">
    <a href="/">Главная</a>
    <a href="/shops.php">Магазины</a>
    <a href="/workshops.php">Мастерские</a>
    <a href="/brands.php">Бренды</a>
    <?php if (!isset($_SESSION['user'])) : ?>
        <div style="display: inline-block; font-size:20px; margin-left:auto;">
            <form action="/auth.php" style="margin-left: 30px; display: inline-block;" method="post">
                <input type="submit" value="Войти" name="auth">
            </form>
            <form action="/reg.php" style="margin-left: 10px; display: inline-block;" method="post">
                <input type="submit" value="Регистрация" name="reg">
            </form>
        </div>
    <?php else : ?>
        <div style="display: inline-block; font-size:20px; margin-left:auto;">
            <form action="/logout.php" style="margin-left: 30px; display: inline-block;" method="post">
                <input type="submit" value="Выйти" name="auth">
            </form>
        </div>
    <?php endif; ?>
    <?php if (isset($u) && $u->hasPrivilege("superadmin")) : ?>
        <div style="display: inline-block; font-size:20px; margin-left:auto;">
            <form action="/admin.php" style="margin-left: 30px; display: inline-block;" method="post">
                <input type="submit" value="Панель администратора" name="auth">
            </form>
        </div>
    <?php endif; ?>
</div>