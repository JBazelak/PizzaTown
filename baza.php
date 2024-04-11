<?php
$typ = 'mysql';         //typ bazy
$server = 'localhost';  // adres serwera www
$db = 'pizzeria';        //nazwa bazy
$port = '3306';         //port XAMP - domyślny 3306

$user = 'root';
$pass = '';

$dsn = "$typ:host=$server;dbname=$db;port=$port";


try{
    $pdo = new PDO($dsn, $user, $pass);
    //echo 'Połączenie nawiazane! </br>';
}
catch(PDOException $e){
    echo 'Połączenie niemogło zostać nawiazane ' . $e->getMessage();
}
