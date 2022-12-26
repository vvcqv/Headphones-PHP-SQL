<?php
session_start();
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
    $query = $pdo->query('SELECT headphones.touch_control,type_design.name AS typedesign_name
    ,headphones.detachable_cable,headphones.mic_id,headphones.bluetooth_id,headphones.id,brand.name AS 
    brname, headphones.model,headphones.impedance,headphones.min_freq,headphones.max_freq,headphones.sensitivity,design.name AS 
    dname,headphones.weight FROM `headphones` LEFT JOIN `brand` ON headphones.brand_id = brand.id LEFT JOIN `design` ON 
    headphones.design_id=design.id LEFT JOIN `type_design` ON type_design.id=headphones.type_design_id ORDER BY `headphones`.`id`');
    $query->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <h3>Список наушников</h3>
    <table style="margin-bottom:20px">
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
            <?php
            if (isset($u) && $u->hasPrivilege("delete_hp")) : ?>
                <td>Удалить</td>
            <?php endif; ?>
            <?php if (isset($u) && $u->hasPrivilege("update_hp")) : ?>
                <td>Изменить</td>
            <?php endif; ?>
        </tr>
        <?php
        while ($row = $query->fetch()) {
            foreach ($row as &$key) {
                if ($key === '' || $key === NULL) {
                    $key = 'Неизвестно';
                }
            }
            echo ('<tr>');
            echo ('<td>' .
                $row['id']
                . '</td>');
            echo ('<td>' .
                $row['brname']
                . '</td>');
            echo ('<td>' .
                $row['model']
                . '</td>');
            echo ('<td>' .
                $row['impedance']
                . '</td>');
            echo ('<td>' .
                $row['min_freq']
                . '</td>');
            echo ('<td>' .
                $row['max_freq']
                . '</td>');
            echo ('<td>' .
                $row['sensitivity']
                . '</td>');
            echo ('<td>' .
                $row['dname']
                . '</td>');
            if ($row['bluetooth_id'] > 0) {
                echo ('<td>Есть</td>');
            } elseif ($row['bluetooth_id'] === 0) {
                echo ('<td>Нет</td>');
            } else {
                echo ('<td>Неизвестно</td>');
            }
            if ($row['mic_id'] > 0) {
                echo ('<td>Есть</td>');
            } elseif ($row['mic_id'] === 0) {
                echo ('<td>Нет</td>');
            } else {
                echo ('<td>Неизвестно</td>');
            }
            if ($row['detachable_cable'] === 1) {
                echo ('<td>Да</td>');
            } elseif ($row['detachable_cable'] === 0) {
                echo ('<td>Нет</td>');
            } else {
                echo ('<td>Неизвестно</td>');
            }
            echo ('<td>' .
                $row['typedesign_name']
                . '</td>');
            echo ('<td>');
            if ($row['touch_control'] === 1) {
                echo ('Есть');
            } elseif ($row['touch_control'] === 0) {
                echo ('Нет');
            } else {
                echo ('Неизвестно');
            }
            echo ('</td>');
            echo ('<td>' .
                $row['weight']
                . '</td>');
            if (isset($u) && $u->hasPrivilege("delete_hp")) {
                echo ('<td class="delete_row"><a href="/assets/php/delete_row.php?table=headphones&id=' . $row['id'] . '">&#10060</a></td>');
            }
            if (isset($u) && $u->hasPrivilege("update_hp")) {
                echo ('<td class="delete_row"><a href="update_headphones.php?id=' . $row['id'] . '">&#9998</a></td>');
            }
            echo ('</tr>');
        }
        ?>
    </table>
    <?php
    if (isset($u) && $u->hasPrivilege("add_hp")) :
    ?>
        <hr>
        <form action="/assets/php/add_headphones.php" method="post">
            <table style="margin-top:20px">
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
                <tr>
                    <td><input type="text" name="id" value="Auto" readonly></td>
                    <?php
                    $brands = $pdo->query('SELECT brand.id, brand.name AS brname FROM `brand`');
                    $brands->setFetchMode(PDO::FETCH_ASSOC);
                    echo ('<td><select name="brand">');
                    while ($brands_rows = $brands->fetch()) {
                        echo ('<option value="' . $brands_rows['id'] . '">');
                        echo ($brands_rows['brname']);
                        echo ('</option>');
                    }
                    echo ('<option value="0" selected>Неизвестно</option>');
                    echo ('</select></td>');
                    ?>
                    <td><input type="text" name="model"></td>
                    <td><input type="text" name="impedance"></td>
                    <td><input type="text" name="min_freq"></td>
                    <td><input type="text" name="max_freq"></td>
                    <td><input type="text" name="sensitivity"></td>

                    <?php
                    $design = $pdo->query('SELECT design.id, design.name AS dname FROM `design`');
                    $design->setFetchMode(PDO::FETCH_ASSOC);
                    echo ('<td><select name="design">');
                    while ($design_rows = $design->fetch()) {
                        echo ('<option value="' . $design_rows['id'] . '">');
                        echo ($design_rows['dname']);
                        echo ('</option>');
                    }
                    echo ('<option value="0" selected>Неизвестно</option>');
                    echo ('</select></td>');

                    $bluetooth = $pdo->query('SELECT bluetooth.id, bluetooth.version AS bversion FROM `bluetooth`');
                    $bluetooth->setFetchMode(PDO::FETCH_ASSOC);
                    echo ('<td><select name="bluetooth">');
                    while ($bluetooth_rows = $bluetooth->fetch()) {
                        echo ('<option value="' . $bluetooth_rows['id'] . '">');
                        echo ($bluetooth_rows['bversion']);
                        echo ('</option>');
                    }
                    echo ('<option value="0" selected>Нет</option>');
                    echo ('</select></td>');

                    $mic = $pdo->query('SELECT mic.name AS mname, mic.id FROM `mic`');
                    $mic->setFetchMode(PDO::FETCH_ASSOC);
                    echo ('<td><select name="mic">');
                    while ($mic_rows = $mic->fetch()) {
                        echo ('<option value="' . $mic_rows['id'] . '">');
                        echo ($mic_rows['mname']);
                        echo ('</option>');
                    }
                    echo ('<option value="0" selected>Нет</option>');
                    echo ('</select></td>');
                    ?>
                    <td><select name="cable">
                            <option value="0">Нет</option>
                            <option value="1">Да</option>
                            <option value="NULL" selected>Неизвестно</option>
                        </select>
                    </td>
                    <?php
                    $type_design = $pdo->query('SELECT type_design.id, type_design.name AS tdname FROM `type_design`');
                    $type_design->setFetchMode(PDO::FETCH_ASSOC);
                    echo ('<td><select name="type_design">');
                    while ($type_design_rows = $type_design->fetch()) {
                        echo ('<option value="' . $type_design_rows['id'] . '">');
                        echo ($type_design_rows['tdname']);
                        echo ('</option>');
                    }
                    echo ('<option value="0" selected>Неизвестно</option>');
                    echo ('</select></td>');
                    ?>
                    <td><select name="touch_control">
                            <option value="0">Нет</option>
                            <option value="1">Да</option>
                            <option value="NULL" selected>Неизвестно</option>
                        </select>
                    </td>
                    <td><input type="text" name="weight"></td>
                </tr>
            </table>
            <input type="submit" value="Добавить запись" style="margin-top:10px">
        </form>
    <?php endif; ?>
</body>

</html>