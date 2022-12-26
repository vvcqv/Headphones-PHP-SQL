<?php
$host = 'localhost';  //  имя  хоста
$db   = 'std_1532_prbd'; // имя бд
$user = 'root'; //имя пользователя
$pass = 'root'; //пароль к бд
$charset = 'utf8'; //кодировка юникод (поддерживает кирилицу)
// формируем данные для одключения
// где mysql – название СУБД
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
//Формируем переменную со служебными характеристиками //подключения
$opt = [
    //правила обработки ошибок
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    //вид формируемых списков по умолчанию
    // PDO::FETCH_ASSOC - ассоциативные
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    //отключаем эмуляцию
    PDO::ATTR_EMULATE_PREPARES   => false,
];
//формируем подключение к БД

try {
    $pdo = new PDO($dsn, $user, $pass, $opt);
} catch (PDOException $e) {
    echo $e->getMessage();
}
