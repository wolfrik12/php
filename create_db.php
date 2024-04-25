<?php

$host = 'localhost';
$dbname = 'inline_test';
$username = 'root'; 
$password = ''; 

try {

    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
    $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");
    echo "База данных '$dbname' успешно создана<br>";

   
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

   
    $pdo->exec("CREATE TABLE IF NOT EXISTS posts (
        id INT PRIMARY KEY,
        userId INT,
        title VARCHAR(255),
        body TEXT
    )");
    echo "Таблица 'posts' успешно создана<br>";

   
    $pdo->exec("CREATE TABLE IF NOT EXISTS comments (
        id INT PRIMARY KEY,
        postId INT,
        name VARCHAR(255),
        email VARCHAR(255),
        body TEXT
    )");
    echo "Таблица 'comments' успешно создана<br>";

} catch(PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
?>