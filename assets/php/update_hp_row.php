<?php
require_once('connection.php');
foreach ($_POST as &$key) {
    if ($key === '') {
        $key = NULL;
    }
}
$id = $_POST['id'];
$brand = $_POST['brand'];
if ($brand == '0') {
    $brand = NULL;
}
$model = $_POST['model'];
$impedance = $_POST['impedance'];
$min_freq = $_POST['min_freq'];
$max_freq = $_POST['max_freq'];
$sensitivity = $_POST['sensitivity'];
$design = $_POST['design'];
if ($design == '0') {
    $design = NULL;
}
$bluetooth = $_POST['bluetooth'];
if ($bluetooth == '0') {
    $bluetooth = NULL;
}
$mic = $_POST['mic'];
if ($mic == '0') {
    $mic = NULL;
}
$cable = $_POST['cable'];
if ($cable == 'NULL') {
    $cable = NULL;
}
$type_design = $_POST['type_design'];
if ($type_design == '0') {
    $type_design = NULL;
}
$touch_control = $_POST['touch_control'];
if ($touch_control == 'NULL') {
    $touch_control = NULL;
}
$weight = $_POST['weight'];

$query = $pdo->prepare('UPDATE `headphones` SET `brand_id`=:brand, `model`=:model, `impedance`=:impedance, `min_freq`=:min_freq, `max_freq`=:max_freq, `sensitivity`=:sensitivity, `design_id`=:design, `bluetooth_id`=:bluetooth, `mic_id`=:mic, `detachable_cable`=:cable, `type_design_id`=:type_design, `touch_control`=:touch_control, `weight`=:weightsize WHERE `id`=:id');
$query->execute(array(
    'brand' => $brand,
    'model' => $model,
    'impedance' => $impedance,
    'min_freq' => $min_freq,
    'max_freq' => $max_freq,
    'sensitivity' => $sensitivity,
    'design' => $design,
    'bluetooth' => $bluetooth,
    'mic' => $mic,
    'cable' => $cable,
    'type_design' => $type_design,
    'touch_control' => $touch_control,
    'weightsize' => $weight,
    'id' => $id
));
header('Location: /');
