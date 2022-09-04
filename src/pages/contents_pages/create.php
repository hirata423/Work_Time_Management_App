<?php

session_start();
date_default_timezone_set('Asia/Tokyo');
require_once '../../../user_logic.php';//checkLogin()
require_once '../../../time_logic.php';//createTime()
require_once '../../../db_connect.php';//connect()

//ログインの可否判定、否なら新規登録画面に返す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err']='ユーザーを登録してログインしてください';
    header('Location:../auth_pages/signup_form.php');
    return;
}

//グローバル変数の$_SESSIONはログイン注のユーザ情報を連想配列で保持
$login_user = $_SESSION['login_user'];
$post_email = $login_user['email'];

if (isset($_POST['submit'])) {
    TimeLogic::createTime($_POST);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
    <link rel="stylesheet" href="../../../styles/create.css">
    <link rel="stylesheet" href="../../../styles/header.css">
    <meta charset="UTF-8">
    <title>作業時間管理アプリ-作業開始</title>
</head>

<?php require_once "../../../templates/header.php" ?>

<body>
    <main>
        <h2>開始時間</h2>
        <form action="create.php" method="post">
            <label for="category">
                作業内容
                <input name="category" required>
            </label>
            <label for="today">
                日 に ち
                <input name="today" required
                    value="<?php echo date('n/j'); ?>">
            </label>
            <label for="sta">
                開始時間
                <input name="sta" required
                    value="<?php echo date('H:i'); ?>">
            </label>
            <!-- //登録の仕方を考える -->
            <label for="email">
                <input name="email" type="hidden"
                    value="<?php echo $post_email ?>">
            </label>
            <div>
                <button type="submit" name="submit" title="作業内容を登録します">登録</button>
            </div>
        </form>
        <div>
            <button type="button" title="作業内容を登録します" onclick="location.href='read.php'">戻る</button>
        </div>

    </main>
</body>

</html>