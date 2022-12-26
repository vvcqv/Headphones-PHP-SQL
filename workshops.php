<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Мастерские</title>
</head>

<body>
    <?php include 'header.php';
    require_once('assets/php/connection.php');
    $query = $pdo->query('SELECT * FROM `workshop` ORDER BY `workshop`.`id`');
    $query->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <h3>Список мастерских</h3>
    <table>
        <tr class="tr_header">
            <td>Номер</td>
            <td>Название</td>
            <td>Адрес</td>
            <td>Телефон</td>
            <?php if (isset($u) && $u->hasPrivilege("delete_workshop")) : ?>
                <td>Удалить</td>
            <?php endif; ?>
            <?php if (isset($u) && $u->hasPrivilege("update_workshop")) : ?>
                <td>Изменить</td>
            <?php endif; ?>
        </tr>
        <?php
        while ($row = $query->fetch()) {
            echo ('<tr>');
            echo ('<td>' .
                $row['id']
                . '</td>');
            echo ('<td>' .
                $row['name']
                . '</td>');
            echo ('<td>' .
                $row['adress']
                . '</td>');
            echo ('<td>' .
                $row['contacts']
                . '</td>');
            if (isset($u) && $u->hasPrivilege("delete_workshop")) {
                echo ('<td class="delete_row"><a href="/assets/php/delete_row.php?table=workshop&id=' . $row['id'] . '">&#10060</a></td>');
            }
            if (isset($u) && $u->hasPrivilege("update_workshop")) {
                echo ('<td class="delete_row"><a href="update_workshops.php?id=' . $row['id'] . '">&#9998</a></td>');
            }
            echo ('</tr>');
        }
        ?>
    </table>
    <?php if (isset($u) && $u->hasPrivilege("add_workshop")) : ?>
        <hr>
        <form action="/assets/php/add_workshops.php" method="post">
            <table>
                <tr class="tr_header">
                    <td>Номер</td>
                    <td>Название</td>
                    <td>Адрес</td>
                    <td>Телефон</td>
                </tr>
                <tr>
                    <td><input type="text" name="id" value="Auto" readonly></td>
                    <td><input type="text" name="name"></td>
                    <td><textarea name="adress"></textarea></td>
                    <td><input type="text" name="phone"></td>
                </tr>
            </table>
            <input type="submit" value="Добавить запись" style="margin-top:10px">
        </form>
    <?php endif; ?>
</body>

</html>