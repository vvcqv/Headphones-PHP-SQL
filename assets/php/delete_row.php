<?php
require_once('connection.php');
$id = $_GET['id'];
$table = $_GET['table'];
$query = $pdo->prepare('DELETE FROM ' . $table . ' WHERE id=' . $id);
$query->execute();
if ($table == 'headphones') {
    header('Location: /');
} else {
    header('Location: /' . $table . 's.php');
}
