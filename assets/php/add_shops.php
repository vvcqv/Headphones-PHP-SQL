<?php
require_once('connection.php');
foreach ($_POST as &$key) {
    if ($key === '') {
        $key = NULL;
    }
}
$id = $_POST['id'];
$city = $_POST['city'];
$adress = $_POST['adress'];
$phone = $_POST['phone'];
$work_time = $_POST['work_time'];
$hp = $_POST['headphones'];

$query = $pdo->prepare("INSERT INTO `shop` (`id`,`city`, `adress`, `phone`, `work_time`) VALUES (:id,:city,:adress,:phone,:work_time)");
$query->execute(array(
    'id' => $id,
    'city' => $city,
    'adress' => $adress,
    'phone' => $phone,
    'work_time' => $work_time
));

if (isset($_POST['headphones'])) {
    foreach ($_POST['headphones'] as $hpkey) {
        $query = $pdo->prepare("INSERT INTO `headphones_shop` (`headphones_id`, `shop_id`) VALUES (:hp_id,:shop_id)");
        $query->execute(array(
            'hp_id' => $hpkey,
            'shop_id' => $id,
        ));
    }
}
header('Location: /shops.php');
