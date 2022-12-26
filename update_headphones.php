<?php
if (!isset($_GET['id'])) {
    header('Location: /');
}
session_start();
require_once('./assets/php/user/role.php');
require_once('./assets/php/user/privilegeduser.php');

if (isset($_SESSION['user'])) {
    $u = PrivilegedUser::getByUsername($_SESSION['user']);
}
if (!isset($u) || !$u->hasPrivilege("update_hp")) {
    header('Location: /');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Наушники</title>
</head>

<body>
    <?php include 'header.php';
    require_once('assets/php/connection.php');
    $id = $_GET['id'];
    $query = $pdo->query('SELECT type_design.id AS type_design_id,mic.id AS mic_id,bluetooth.id AS bluetooth_id,design.id AS design_id,headphones.brand_id,headphones.touch_control,type_design.name AS typedesign_name
    ,headphones.detachable_cable,headphones.mic_id,headphones.bluetooth_id,headphones.id,brand.name AS 
    brname, headphones.model,headphones.impedance,headphones.min_freq,headphones.max_freq,headphones.sensitivity,design.name AS 
    dname,headphones.weight FROM `headphones` LEFT JOIN `brand` ON headphones.brand_id = brand.id LEFT JOIN `design` ON 
    headphones.design_id=design.id LEFT JOIN `type_design` ON type_design.id=headphones.type_design_id LEFT JOIN `bluetooth` 
    ON bluetooth.id=headphones.bluetooth_id LEFT JOIN `mic` ON mic.id=headphones.mic_id WHERE headphones.id=' . $id);
    $query->setFetchMode(PDO::FETCH_ASSOC);


    $brands = $pdo->query('SELECT brand.id, brand.name AS brname FROM `brand`');
    $brands->setFetchMode(PDO::FETCH_ASSOC);

    $design = $pdo->query('SELECT design.id, design.name AS dname FROM `design`');
    $design->setFetchMode(PDO::FETCH_ASSOC);

    $bluetooth = $pdo->query('SELECT bluetooth.id, bluetooth.version AS bversion FROM `bluetooth`');
    $bluetooth->setFetchMode(PDO::FETCH_ASSOC);

    $mic = $pdo->query('SELECT mic.name AS mname, mic.id FROM `mic`');
    $mic->setFetchMode(PDO::FETCH_ASSOC);

    $type_design = $pdo->query('SELECT type_design.id, type_design.name AS tdname FROM `type_design`');
    $type_design->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <h3>Изменение строки в таблице "headphones" под номером <?= $id ?></h3>
    <form action="/assets/php/update_hp_row.php" method="post">
        <table>
            <tr class="tr_header">
                <td>Номер</td>
                <td>Бренд</td>
                <td>Модель</td>
                <td>Импеданс</td>
                <td>Мин. воспр. частота</td>
                <td>Макс. воспр. частота</td>
                <td>Чувствительность</td>
                <td>Конструкция</td>

                <td>Bluetooth</td>
                <td>Микрофон</td>
                <td>Съемный кабель</td>
                <td>Тип аккустического оформления</td>
                <td>Сенсорное управление</td>

                <td>Вес</td>
            </tr>
            <?php
            $row = $query->fetch();
            echo ('<tr>');
            #id
            echo ('<td><input type="text" readonly value="' . $row['id'] . '" required name="id"></td>');
            #brand
            echo ('<td><select name="brand">');
            while ($brands_rows = $brands->fetch()) {
                if ($brands_rows['id'] == $row['brand_id']) {
                    echo ('<option selected value="' . $brands_rows['id'] . '">');
                } else {
                    echo ('<option value="' . $brands_rows['id'] . '">');
                }
                echo ($brands_rows['brname']);
                echo ('</option>');
            }
            if ($row['brand_id'] == '') {
                echo ('<option value="0" selected>Неизвестно</option>');
            } else {
                echo ('<option value="0">Неизвестно</option>');
            };
            echo ('</select></td>');
            #model
            echo ('<td><input type="text" value="' . $row['model'] . '" name="model"></td>');
            #impedance
            echo ('<td><input type="text" value="' . $row['impedance'] . '" name="impedance"></td>');
            #min_freq
            echo ('<td><input type="text" value="' . $row['min_freq'] . '" name="min_freq"></td>');
            #max_freq
            echo ('<td><input type="text" value="' . $row['max_freq'] . '" name="max_freq"></td>');
            #sensitivity
            echo ('<td><input type="text" value="' . $row['sensitivity'] . '" name="sensitivity"></td>');
            #design
            echo ('<td><select name="design">');
            while ($design_rows = $design->fetch()) {
                if ($design_rows['id'] == $row['design_id']) {
                    echo ('<option selected value="' . $design_rows['id'] . '">');
                } else {
                    echo ('<option value="' . $design_rows['id'] . '">');
                }
                echo ($design_rows['dname']);
                echo ('</option>');
            }
            if ($row['design_id'] == '') {
                echo ('<option value="0" selected>Неизвестно</option>');
            } else {
                echo ('<option value="0">Неизвестно</option>');
            };
            echo ('</select></td>');
            #bluetooth
            echo ('<td><select name="bluetooth">');
            while ($bluetooth_rows = $bluetooth->fetch()) {
                if ($bluetooth_rows['id'] == $row['bluetooth_id']) {
                    echo ('<option selected value="' . $bluetooth_rows['id'] . '">');
                } else {
                    echo ('<option value="' . $bluetooth_rows['id'] . '">');
                }
                echo ($bluetooth_rows['bversion']);
                echo ('</option>');
            }
            if ($row['bluetooth_id'] == '') {
                echo ('<option value="0" selected>Нет</option>');
            } else {
                echo ('<option value="0">Нет</option>');
            };
            echo ('</select></td>');
            #mic
            echo ('<td><select name="mic">');
            while ($mic_rows = $mic->fetch()) {
                if ($mic_rows['id'] == $row['mic_id']) {
                    echo ('<option selected value="' . $mic_rows['id'] . '">');
                } else {
                    echo ('<option value="' . $mic_rows['id'] . '">');
                }
                echo ($mic_rows['mname']);
                echo ('</option>');
            }
            if ($row['mic_id'] == '') {
                echo ('<option value="0" selected>Нет</option>');
            } else {
                echo ('<option value="0">Нет</option>');
            };
            echo ('</select></td>');
            #cable
            echo ('<td><select name="cable">');
            if ($row['detachable_cable'] == 1) {
                echo ('
                <option value="0">Нет</option>
                <option value="1" selected>Да</option>
                <option value="NULL">Неизвестно</option>
                ');
            } elseif ($row['detachable_cable'] == 0) {
                echo ('
                <option value="0" selected>Нет</option>
                <option value="1">Да</option>
                <option value="NULL">Неизвестно</option>
                ');
            } else {
                echo ('
                <option value="0" selected>Нет</option>
                <option value="1">Да</option>
                <option value="NULL" selected>Неизвестно</option>
                ');
            }
            echo ('</select></td>');
            #type_design
            echo ('<td><select name="type_design">');
            while ($type_design_rows = $type_design->fetch()) {
                if ($type_design_rows['id'] == $row['type_design_id']) {
                    echo ('<option selected value="' . $type_design_rows['id'] . '">');
                } else {
                    echo ('<option value="' . $type_design_rows['id'] . '">');
                }
                echo ($type_design_rows['tdname']);
                echo ('</option>');
            }
            if ($row['type_design_id'] == '') {
                echo ('<option value="0" selected>Неизвестно</option>');
            } else {
                echo ('<option value="0">Неизвестно</option>');
            };
            echo ('</select></td>');
            #touch_control
            echo ('<td><select name="touch_control">');
            if ($row['touch_control'] === 1) {
                echo ('
                <option value="0">Нет</option>
                <option value="1" selected>Да</option>
                <option value="NULL">Неизвестно</option>
                ');
            } elseif ($row['touch_control'] === 0) {
                echo ('
                <option value="0" selected>Нет</option>
                <option value="1">Да</option>
                <option value="NULL">Неизвестно</option>
                ');
            } else {
                echo ('
                <option value="0" selected>Нет</option>
                <option value="1">Да</option>
                <option value="NULL" selected>Неизвестно</option>
                ');
            }
            echo ('</select></td>');
            #weight
            echo ('<td><input type="text" value="' . $row['weight'] . '" name="weight"></td>');
            echo ('</tr>');
            ?>
        </table>
        <input type="submit" value="Изменить" style="margin-top:10px">
    </form>
</body>

</html>