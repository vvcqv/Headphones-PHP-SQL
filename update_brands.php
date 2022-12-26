<?php
if (!isset($_GET['id'])) {
    header('Location: /brands.php');
}
session_start();
require_once('./assets/php/user/role.php');
require_once('./assets/php/user/privilegeduser.php');

if (isset($_SESSION['user'])) {
    $u = PrivilegedUser::getByUsername($_SESSION['user']);
}
if (!isset($u) || !$u->hasPrivilege("update_brand")) {
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
    $query = $pdo->query('SELECT * FROM `brand` WHERE `id`=' . $id);
    $query->setFetchMode(PDO::FETCH_ASSOC);
    ?>
    <h3>Изменение строки в таблице "brand" под номером <?= $id ?></h3>
    <form action="/assets/php/update_brand_row.php" method="post">
        <table>
            <tr class="tr_header">
                <td>Номер</td>
                <td>Название</td>
                <td>Описание</td>
            </tr>
            <?php
            $row = $query->fetch();
            echo ('<tr>');
            echo ('<td><input type="text" readonly value="' . $row['id'] . '" required name="id"></td>');
            echo ('<td><input type="text" value="' . $row['name'] . '"  name="bname"></td>');
            echo ('<td><textarea name="description">' . $row['description'] . '</textarea></td>');
            echo ('</tr>');
            ?>
        </table>
        <input type="submit" value="Изменить" style="margin-top:10px">
    </form>
</body>

</html>