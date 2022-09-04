<?php

session_start();
date_default_timezone_set('Asia/Tokyo');
$week = ['日','月','火','水','木','金','土',];
$date_w= date('w');
$date=date('n/j');
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
        <div class="display">
            <?php echo h($login_user['name']); ?>さん、お疲れ様です！
        </div>
        <div class="display">
            今日は<?php echo "$date($week[$date_w])"?>です。
        </div>
        <div>
            <button type="button" title="作業を開始できます" onclick="location.href='create.php'">作業開始</button>
        </div>
        <div>
            <button type="button" title="作業の終了・更新ができます" onclick="location.href='read.php'">作業一覧</button>
        </div>
        <div>
            <button type="button" title="トップページに戻ります" onclick="location.href='../../../index.php'">トップへ</button>
        </div>
        <form action="../auth_pages/logout.php" method="post">
            <input type="submit" name="logout" title="ログアウトします" value="ログアウト">
        </form>
        </p>
    </main>
</body>

</html>