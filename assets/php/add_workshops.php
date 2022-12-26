<?php
require_once('connection.php');
foreach ($_POST as &$key) {
    if ($key === '') {
        $key = NULL;
    }
}
$wname = $_POST['name'];
$adress = $_POST['adress'];
$phone = $_POST['phone'];

$query = $pdo->prepare("INSERT INTO `workshop` (`name`, `adress`, `contacts`) VALUES (:wname,:adress,:contacts)");
$query->execute(array(
    'wname' => $wname,
    'adress' => $adress,
    'contacts' => $contacts
));
header('Location: /workshops.php');
