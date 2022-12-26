<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Магазины</title>
</head>

<body>
    <?php include 'header.php';
    require_once('assets/php/connection.php');
    $query = $pdo->query('SELECT * FROM `shop` ORDER BY `shop`.`id`');
    $query->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <h3>Список магазинов</h3>
    <table style="margin-bottom:20px">
        <tr class="tr_header">
            <td>Номер</td>
            <td>Город</td>
            <td>Адрес</td>
            <td>Телефон</td>
            <td>Рабочее время</td>
            <td>Наушники</td>
            <?php if (isset($u) && $u->hasPrivilege("delete_shop")) : ?>
                <td>Удалить</td>
            <?php endif; ?>
            <?php if (isset($u) && $u->hasPrivilege("update_shop")) : ?>
                <td>Изменить</td>
            <?php endif; ?>

        </tr>
        <?php
        while ($row = $query->fetch()) {
            $last_id = $row['id'];
            echo ('<tr>');
            echo ('<td>' .
                $row['id']
                . '</td>');
            echo ('<td>' .
                $row['city']
                . '</td>');
            echo ('<td>' .
                $row['adress']
                . '</td>');
            echo ('<td>' .
                $row['phone']
                . '</td>');
            echo ('<td><textarea readonly>' .
                $row['work_time']
                . '</textarea></td>');

            $headphones = $pdo->prepare('SELECT headphones.id AS hp_id, headphones.model AS hp_model FROM `headphones` LEFT JOIN `headphones_shop` ON headphones_shop.headphones_id=headphones.id LEFT JOIN `shop` ON shop.id=headphones_shop.shop_id WHERE shop.id=:shop_id');
            $headphones->execute([$row['id']]);
            $headphones->setFetchMode(PDO::FETCH_ASSOC);

            echo ('<td><select name="headphones[]" multiple="multiple">');
            while ($row2 = $headphones->fetch()) {
                echo ('<option value="' . $row2['hp_id'] . '">' . $row2['hp_model'] . '</option>');
            }
            echo ('</select></td>');
            if (isset($u) && $u->hasPrivilege("delete_shop")) {
                echo ('<td class="delete_row"><a href="/assets/php/delete_row.php?table=shop&id=' . $row['id'] . '">&#10060</a></td>');
            }
            if (isset($u) && $u->hasPrivilege("update_shop")) {
                echo ('<td class="delete_row"><a href="update_shops.php?id=' . $row['id'] . '">&#9998</a></td>');
            }
            echo ('</tr>');
        }
        ?>
    </table>
    <?php if (isset($u) && $u->hasPrivilege("add_shop")) : ?>
        <hr>
        <form action="/assets/php/add_shops.php" method="post">
            <table style="margin-top:20px">
                <tr class="tr_header">
                    <td>Номер</td>
                    <td>Город</td>
                    <td>Адрес</td>
                    <td>Телефон</td>
                    <td>Рабочее время</td>
                    <td>Наушники</td>
                </tr>
                <tr>
                    <td><input type="text" name="id" value="<?= $last_id + 1 ?>" readonly></td>
                    <td><input type="text" name="city"></td>
                    <td><textarea name="adress"></textarea></td>
                    <td><input type="text" name="phone"></td>
                    <td><textarea name="work_time"></textarea></td>
                    <?php
                    $query = $pdo->query('SELECT * FROM `headphones` ORDER BY `headphones`.`id`');
                    $query->setFetchMode(PDO::FETCH_ASSOC);

                    echo ('<td><select name="headphones[]" multiple="multiple">');
                    while ($row = $query->fetch()) {
                        echo ('<option value="' . $row['id'] . '">' . $row['model'] . '</option>');
                    }
                    echo ('</select></td>');
                    ?>
                </tr>
            </table>
            <input type="submit" value="Добавить запись" style="margin-top:10px">
        </form>
    <?php endif; ?>
</body>

</html>