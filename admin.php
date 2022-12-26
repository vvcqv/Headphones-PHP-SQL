<?php
session_start();
require_once('./assets/php/user/role.php');
require_once('./assets/php/user/privilegeduser.php');
if (isset($_SESSION['user'])) {
    $u = PrivilegedUser::getByUsername($_SESSION['user']);
}
if (!isset($u) || !$u->hasPrivilege("superadmin")) {
    header('Location: /');
}
if (isset($_POST['role_name'])) {
    Role::insertRole($_POST['role_name']);
    $_SESSION['role_message'] = 'Роль успешно добавлена!';
}
if (isset($_POST['user_id']) && isset($_POST['roles'])) {
    Role::insertUserRoles($_POST['user_id'], $_POST['roles']);
    $_SESSION['rolemas_message'] = 'Роли успешно добавлены!';
}
if (isset($_POST['rolesdel'])) {
    Role::deleteRoles($_POST['rolesdel']);
    $_SESSION['rolemasdel_message'] = 'Роли успешно удалены!';
}
if (isset($_POST['user_id_del'])) {
    Role::deleteUserRoles($_POST['user_id_del']);
    $_SESSION['user_id_del_message'] = 'Роли успешно удалены!';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Панель администратора</title>
</head>

<body>
    <?php include 'header.php';
    require_once('assets/php/connection.php');
    ?>
    <table style="margin-top: 10px;">
        <tr>
            <td></td>
            <td>Список</td>
            <td>Вставить</td>
            <td>Вставить массив ролей</td>
            <td>Удалить массив ролей</td>
            <td>Удалить все роли у пользователя</td>
        </tr>
        <tr>
            <td>Роли</td>
            <td>
                <?php
                $query = $pdo->query('SELECT * FROM `roles` ORDER BY `role_id`');
                $query->setFetchMode(PDO::FETCH_ASSOC);
                while ($row = $query->fetch()) : ?>
                    <ul>
                        <li>
                            <?= $row['role_name']; ?>
                        </li>
                    </ul>

                <?php endwhile; ?>
            </td>
            <td>
                <form action="" method="post">
                    <input type="text" name="role_name" placeholder="Название роли" class="auth">
                    <input type="submit" value="Вставить">
                </form>
                <?php if ($_SESSION['role_message']) {
                    echo ('
        <p style="color:green;">
        ' . $_SESSION['role_message'] . '
        </p>
        ');
                    unset($_SESSION['role_message']);
                } ?>
            </td>
            <td>
                <form action="" method="post">
                    Пользователь
                    <select name="user_id">
                        <?php
                        $query = $pdo->query('SELECT * FROM `users` ORDER BY `user_id`');
                        $query->setFetchMode(PDO::FETCH_ASSOC);
                        while ($row = $query->fetch()) : ?>
                            <option value="<?= $row['user_id'] ?>"><?= $row['login'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    Роли
                    <select name="roles[]" multiple>
                        <?php
                        $query = $pdo->query('SELECT * FROM `roles` ORDER BY `role_id`');
                        $query->setFetchMode(PDO::FETCH_ASSOC);
                        while ($row = $query->fetch()) : ?>
                            <option value="<?= $row['role_id'] ?>"><?= $row['role_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input type="submit" value="Вставить">
                </form>
                <?php
                if ($_SESSION['rolemas_message']) {
                    echo ('
                <p style="color:green;">
                ' . $_SESSION['rolemas_message'] . '
                </p>
                ');
                    unset($_SESSION['rolemas_message']);
                } ?>
            </td>
            <td>
                <form action="" method="post">
                    <select name="rolesdel[]" multiple>
                        <?php
                        $query = $pdo->query('SELECT * FROM `roles` ORDER BY `role_id`');
                        $query->setFetchMode(PDO::FETCH_ASSOC);
                        while ($row = $query->fetch()) : ?>
                            <option value="<?= $row['role_id'] ?>"><?= $row['role_name'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input type="submit" value="Удалить">
                </form>
                <?php
                if ($_SESSION['rolemasdel_message']) {
                    echo ('
                <p style="color:green;">
                ' . $_SESSION['rolemasdel_message'] . '
                </p>
                ');
                    unset($_SESSION['rolemasdel_message']);
                } ?>
            </td>
            <td>
                <form action="" method="post">
                    <select name="user_id_del">
                        <?php
                        $query = $pdo->query('SELECT * FROM `users` ORDER BY `user_id`');
                        $query->setFetchMode(PDO::FETCH_ASSOC);
                        while ($row = $query->fetch()) : ?>
                            <option value="<?= $row['user_id'] ?>"><?= $row['login'] ?></option>
                        <?php endwhile; ?>
                    </select>
                    <input type="submit" value="Удалить">
                </form>
                <?php
                if ($_SESSION['user_id_del_message']) {
                    echo ('
                <p style="color:green;">
                ' . $_SESSION['user_id_del_message'] . '
                </p>
                ');
                    unset($_SESSION['user_id_del_message']);
                } ?>
            </td>
        </tr>
    </table>
</body>

</html>