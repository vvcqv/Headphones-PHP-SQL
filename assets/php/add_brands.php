<?php
require_once('connection.php');
foreach ($_POST as &$key) {
    if ($key === '') {
        $key = NULL;
    }
}
$bname = $_POST['name'];
$description = $_POST['description'];

$query = $pdo->prepare("INSERT INTO `brand` (`name`, `description`) VALUES (:bname,:bdescription)");
$query->execute(array(
    'bname' => $bname,
    'bdescription' => $description,
));
header('Location: /brands.php');
