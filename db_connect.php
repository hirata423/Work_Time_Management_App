<?php

require_once 'env.php';
require __DIR__ . 'vendor/autoload.php';

function connect()
{
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
    $dotenv->load();
    // $host = DB_HOST;
    // $db = DB_NAME;
    // $user = DB_USER;
    // $pass = DB_PASS;

    $host = $_ENV('DB_HOST');
    $db =$_ENV('DB_NAME');
    $user =$_ENV('DB_USER');
    $pass =$_ENV('DB_PASS');



    $dsn = "mysql:dbname=$db;host=$host;charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
        return $pdo;
    } catch (PDOExeption $e) {
        echo "接続失敗".$e->getMessage();
        exit();
    }
};
