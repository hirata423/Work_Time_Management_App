<?php

session_start();

require_once 'user_logic.php';

$result = UserLogic::checkLogin();
if ($result) {
    header('Location:mypage.php');
    return;
}

//エラーメッセージの回収ボックス
$err = [];

$token = filter_input(INPUT_POST, 'csrf_token');
//トークンがない場合。もしくは一致しない場合は処理を中止
if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
    exit('!不正なリクエスト');
}
//二重送信、不正なアクセスを防止
unset($_SESSION['csrf_token']);

//バリデーション
if (!$username = filter_input(INPUT_POST, 'username')) {
    $err['username'] = '!ユーザーネームを入力してください';
}
if (!$email = filter_input(INPUT_POST, 'email')) {
    $err['email'] = '!メールアドレスを入力してください';
}
$password = filter_input(INPUT_POST, 'password');
if (!preg_match("/\A(?=.*?[a-z])(?=.*?[A-Z])(?=.*?\d)[a-zA-Z\d]{8,100}+\z/", $password)) {
    $err['password'] = "!半角英数小・大文字を含む8文字以上で入力してください";
    // "!半角英数小・大文字をそれぞれ1種類以上含む8文字以上100文字以下で設定してください";
}
if (!$password_conf = filter_input(INPUT_POST, 'password_conf')) {
    $err['password_conf'] = '!パスワードの不一致または未入力です';
}
if ($password !== $password_conf) {
    $err['password_conf'] = "!確認用パスワードと一致しません";
}
if (count($err) === 0) {
    //全てのチェックでエラーがなかったらユーザー登録される
    $hasCreated = UserLogic::createUser($_POST);
    if (!$hasCreated) {
        $err['signup_err'] = "!登録に失敗しました</br>既に登録された内容が含まれています。";
        $_SESSION = $err;
        header('Location:signup_form.php');
        return;
    }
}
if (count($err) > 0) {
    // エラーがあった場合ばあいは戻す
    $_SESSION = $err;
    header('Location:signup_form.php');
    return;
}







?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/register_login_logout.css">
    <title>ユーザー登録完了</title>
</head>

<body>
    <h2>ユーザー登録完了</h2>
    <P>ユーザー登録が完了しました</P>
    <p>
        <a href="login_form.php">ログインホームへ</a>
    </p>


</body>

</html>