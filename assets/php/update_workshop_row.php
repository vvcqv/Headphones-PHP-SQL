<?php
require_once('connection.php');
foreach ($_POST as &$key) {
    if ($key === '') {
        $key = NULL;
    }
}

$wname = $_POST['wname'];
$adress = $_POST['adress'];
$contacts = $_POST['contacts'];
$id = $_POST['id'];

$data = [
    'wname' => $wname,
    'adress' => $adress,
    'contacts' => $contacts,
    'id' => $id
];
try {
    $query = $pdo->prepare('UPDATE workshop SET name=:wname, adress=:adress, `contacts`=:contacts WHERE `id`=:id');
    $query->execute($data);
} catch (PDOException $e) {
    echo $e->getMessage();
}

header('Location: /workshops.php');
