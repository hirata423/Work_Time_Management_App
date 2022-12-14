<?php

session_start();

require_once '../../../user_logic.php';//checkLogin()

$result = UserLogic::checkLogin();
if ($result) {
    header('Location:../contents_pages/mypage.php');
    return;
}

//エラーメッセージの回収ボックス
$err = [];

//バリデーション
if (!$email = filter_input(INPUT_POST, 'email')) {
    $err['email'] = '!メールアドレスを入力してください';
}

if (!$password = filter_input(INPUT_POST, 'password')) {
    $err['password'] = '!パスワードを入力してください';
}
if (count($err) > 0) {
    // エラーがあった場合ばあいは戻す
    $_SESSION = $err;
    header('Location:login_form.php');
    return;
}
//ログイン成功時の処理
$result = UserLogic::login($email, $password);
if (!$result) {
    //ログイン失敗時の処理
    header('Location:login_form.php');
    return;
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../styles/register_login_logout.css">
    <title>作業時間管理アプリ-ログイン完了</title>
</head>

<body>
    <h2>ログイン完了</h2>
    <p>ログインしました</p>
    <p>
        <a href="../contents_pages/mypage.php">マイページへ</a>
    </p>
    <p>
        <a href="../../../index.php">トップへ</a>
    </p>

</body>

</html>