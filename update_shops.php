<?php
if (!isset($_GET['id'])) {
    header('Location: /shops.php');
}
session_start();
require_once('./assets/php/user/role.php');
require_once('./assets/php/user/privilegeduser.php');

if (isset($_SESSION['user'])) {
    $u = PrivilegedUser::getByUsername($_SESSION['user']);
}
if (!isset($u) || !$u->hasPrivilege("update_shop")) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Магазины</title>
</head>

<body>
    <?php include 'header.php';
    require_once('assets/php/connection.php');
    $id = $_GET['id'];
    $query = $pdo->query('SELECT * FROM `shop` WHERE `id`=' . $id);
    $query->setFetchMode(PDO::FETCH_ASSOC);

    $headphones = $pdo->prepare('SELECT headphones.id AS hp_id, headphones.model AS hp_model FROM `headphones` LEFT JOIN `headphones_shop` ON headphones_shop.headphones_id=headphones.id LEFT JOIN `shop` ON shop.id=headphones_shop.shop_id WHERE shop.id=:shop_id');
    $headphones->execute([$id]);
    $headphones->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <h3>Изменение строки в таблице "shop" под номером <?= $id ?></h3>
    <form action="/assets/php/update_shop_row.php" method="post">
        <table>
            <tr class="tr_header">
                <td>Номер</td>
                <td>Город</td>
                <td>Адрес</td>
                <td>Телефон</td>
                <td>Рабочее время</td>
                <td>Наушники</td>
            </tr>
            <?php
            $row = $query->fetch();
            $hp_exist = array();
            while ($row2 = $headphones->fetch()) {
                array_push($hp_exist, $row2['hp_id']);
            }
            echo ('<tr>');
            echo ('<td><input type="text" readonly value="' . $row['id'] . '" required name="id"></td>');
            echo ('<td><input type="text" value="' . $row['city'] . '"  name="city"></td>');
            echo ('<td><textarea name="adress">' . $row['adress'] . '</textarea></td>');
            echo ('<td><input type="text" value="' . $row['phone'] . '"  name="phone"></td>');
            echo ('<td><textarea name="work_time">' . $row['work_time'] . '</textarea></td>');

            $query = $pdo->query('SELECT * FROM `headphones` ORDER BY `headphones`.`id`');
            $query->setFetchMode(PDO::FETCH_ASSOC);

            echo ('<td><select name="headphones[]" multiple="multiple">');
            while ($row = $query->fetch()) {
                if (in_array($row['id'], $hp_exist)) {
                    echo ('<option value="' . $row['id'] . '" selected>' . $row['model'] . '</option>');
                } else {
                    echo ('<option value="' . $row['id'] . '">' . $row['model'] . '</option>');
                }
            }
            echo ('</select></td>');

            echo ('</tr>');
            ?>
        </table>
        <input type="submit" value="Изменить" style="margin-top:10px">
    </form>
</body>

</html>