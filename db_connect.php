<?php

//テスト完了後コメントアウト(ローカル用)
// require_once 'env.php';


function connect()
{
    //テスト完了後コメントアウト(ローカル用)
    // $host = DB_HOST;
    // $db = DB_NAME;
    // $user = DB_USER;
    // $pass = DB_PASS;

    //デプロイ用
    $host = getenv('DB_HOST');
    $db =getenv('DB_NAME');
    $user =getenv('DB_USER');
    $pass =getenv('DB_PASS');

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
