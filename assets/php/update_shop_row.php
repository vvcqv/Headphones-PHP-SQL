<?php
require_once('connection.php');
foreach ($_POST as &$key) {
    if ($key === '') {
        $key = NULL;
    }
}
$hp_selected = $_POST['headphones'];
$city = $_POST['city'];
$adress = $_POST['adress'];
$phone = $_POST['phone'];
$work_time = $_POST['work_time'];
$id = $_POST['id'];

$data = [
    'city' => $city,
    'adress' => $adress,
    'phone' => $phone,
    'work_time' => $work_time,
    'id' => $id
];
$query = $pdo->prepare('UPDATE shop SET city=:city, adress=:adress, `phone`=:phone, `work_time`=:work_time WHERE `id`=:id');
$query->execute($data);

$current_hp = $pdo->prepare('SELECT headphones_shop.headphones_id FROM `headphones_shop` WHERE headphones_shop.shop_id=:id ORDER BY `headphones_id`');
$current_hp->execute([$id]);
$current_hp->setFetchMode(PDO::FETCH_ASSOC);
$current_hp_array = array();
while ($row = $current_hp->fetch()) {
    array_push($current_hp_array, $row['id']);
}
if (count(array_diff($hp_selected, $current_hp_array)) != 0 || count(array_diff($current_hp_array, $hp_selected)) != 0) {
    $delete = $pdo->prepare('DELETE FROM `headphones_shop` WHERE `shop_id`=:shop_id');
    $delete->execute([$id]);
    foreach ($hp_selected as $hp_key) {
        $query = $pdo->prepare("INSERT INTO `headphones_shop` (`headphones_id`, `shop_id`) VALUES (:hp_id,:shop_id)");
        $query->execute(array(
            'hp_id' => $hp_key,
            'shop_id' => $id,
        ));
    }
}

header('Location: /shops.php');
