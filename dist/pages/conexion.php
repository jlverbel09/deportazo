<?php
/* LOCAL */
/* $host = 'localhost';
$user = 'root';
$pass = '';
$db = 'deportazo2';
$port = 3306; */



/* CONEXION NUBE */
$host = 'localhost';
$user = 'u295124209_deportazo';
$pass = 'Jlvd-7069';
$db = 'u295124209_deportazo';
$port = 3306;

try {
    $conexion = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
} catch (PDOException $e) {

    //conexion local-nube
    $host = '193.203.168.80';
    $user = 'u295124209_deportazo';
    $pass = 'Jlvd-7069';
    $db = 'u295124209_deportazo';
    $port = 3306;

    try {
        $conexion = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }
}
