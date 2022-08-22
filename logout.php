<?php

session_start();
require_once 'user_logic.php';

if (!$logout=filter_input(INPUT_POST, 'logout')) {
    exit("不正なリクエスト");
}

//ログインしているか=セッションが有効化判定
//phpのセッションのデフォルト時間は24分らしい
$result = UserLogic::checkLogin();
if (!$result) {
    exit("セッション切れです。再度ログインをしてください");
}

//ログアウトする
UserLogic::Logout();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/register_login_logout.css">
    <title>ログアウト</title>
</head>

<body>
    <h2>ログアウト完了</h2>
    <P>ログアウトしました</P>
    <p>
        <a href="index.php">ログイン画面へ</a>
    </p>

</body>

</html>