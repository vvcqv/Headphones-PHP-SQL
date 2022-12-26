<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Бренды</title>
</head>

<body>
    <?php include 'header.php';
    require_once('assets/php/connection.php');
    $query = $pdo->query('SELECT brand.id, brand.name AS bname, brand.description FROM `brand` ORDER BY `brand`.`id`');
    $query->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <h3>Список брендов</h3>
    <table>
        <tr class="tr_header">
            <td>Номер</td>
            <td>Название</td>
            <td>Описание</td>
            <?php if (isset($u) && $u->hasPrivilege("delete_brand")) : ?>
                <td>Удалить</td>
            <? endif; ?>
            <?php if (isset($u) && $u->hasPrivilege("update_brand")) : ?>
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
                $row['bname']
                . '</td>');
            echo ('<td><textarea>' .
                $row['description']
                . '</textarea></td>');
            if (isset($u) && $u->hasPrivilege("delete_brand")) {
                echo ('<td class="delete_row"><a href="/assets/php/delete_row.php?table=brand&id=' . $row['id'] . '">&#10060</a></td>');
            }
            if (isset($u) && $u->hasPrivilege("update_brand")) {
                echo ('<td class="delete_row"><a href="update_brands.php?id=' . $row['id'] . '">&#9998</a></td>');
            }
            echo ('</tr>');
        }
        ?>
    </table>
    <?php if (isset($u) && $u->hasPrivilege("add_brand")) : ?>
        <hr>
        <form action="/assets/php/add_brands.php" method="post">
            <table>
                <tr class="tr_header">
                    <td>Номер</td>
                    <td>Название</td>
                    <td>Описание</td>
                </tr>
                <tr>
                    <td><input type="text" name="id" value="Auto" readonly></td>
                    <td><input type="text" name="name"></td>
                    <td><textarea name="description"></textarea></td>
                </tr>
            </table>
            <input type="submit" value="Добавить запись" style="margin-top:10px">
        </form>
    <?php endif; ?>
</body>

</html>