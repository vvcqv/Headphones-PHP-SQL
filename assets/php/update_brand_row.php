<?php
require_once('connection.php');
foreach ($_POST as &$key) {
    if ($key === '') {
        $key = NULL;
    }
}

$bname = $_POST['bname'];
$description = $_POST['description'];
$id = $_POST['id'];

$data = [
    'bname' => $bname,
    'bdescription' => $description,
    'id' => $id
];
try {
    $query = $pdo->prepare('UPDATE `brand` SET `name`=:bname, `description`=:bdescription WHERE `id`=:id');
    $query->execute($data);
} catch (PDOException $e) {
    echo $e->getMessage();
}

header('Location: /brands.php');
