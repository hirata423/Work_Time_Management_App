<?php

session_start();
date_default_timezone_set('Asia/Tokyo');
$week = ['日','月','火','水','木','金','土',];
$date_w= date('w');
$date=date('n/d');
require_once '../../../user_logic.php';//checkLogin()
require_once '../../../functions.php';//h()

//ログインしているか判定し、していなかったら新規登録画面に返す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err']='ユーザーを登録してログインしてください';
    header('Location:../auth_pages/signup_form.php');
    return;
}
$login_user = $_SESSION['login_user'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../styles/mypage.css">
    <link rel="stylesheet" href="../../../styles/header.css">
    <title>作業時間管理アプリ-マイページ</title>
</head>

<?php require_once "../../../templates/header.php" ?>

<body>
    <main>
        <P class="login_user">
            <?php echo h($login_user['name']); ?>さん、お疲れ様です！
        </P>
        <p class="date_display">
            今日は<?php echo "$date($week[$date_w])"?>です。
        </p>
        <p>
            <a href="create.php" title="作業を開始できます">作業開始</a>
        </p>
        <p>
            <a href="read.php" title="作業の終了・更新ができます">記録一覧</a>
        </p>
        <p>
            <a href="../../../index.php" title="トップページに戻ります">トップ</a>
        </p>
        <p>
        <form action="../auth_pages/logout.php" method="post">
            <input type="submit" name="logout" value="ログアウト" title="ログアウトします">
        </form>
        </p>
    </main>
</body>

</html>