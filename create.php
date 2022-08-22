<?php

session_start();
date_default_timezone_set('Asia/Tokyo');
require_once 'user_logic.php';//checkLogin()
require_once 'db_connect.php';//connect()

//ログインの可否判定、否なら新規登録画面に返す
$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err']='ユーザーを登録してログインしてください';
    header('Location:signup_form.php');
    return;
}

//グローバル変数の$_SESSIONはログイン注のユーザ情報を連想配列で保持
$login_user = $_SESSION['login_user'];
$post_email = $login_user['email'];

if (isset($_POST['submit'])) {
    try {
        $sql_insert =
        "INSERT INTO times(category,today,sta,email)
        VALUES(:category,:today,:sta,:email)";
        $stmt = connect()->prepare($sql_insert);
        $stmt->bindValue(':category', $_POST['category'], PDO::PARAM_STR);
        $stmt->bindValue(':today', $_POST['today'], PDO::PARAM_STR);
        $stmt->bindValue(':sta', $_POST['sta'], PDO::PARAM_STR);
        $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->execute();
        $count = $stmt->rowCount();
        $message = "新規作業を{$count}件開始しました！";
        header("Location: read.php?message={$message}");
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/create.css">
    <meta charset="UTF-8">
    <title>開始時間</title>
</head>

<?php require_once "templates/header.php" ?>

<body>
    <main>
        <h2>開始時間</h2>
        <form action="create.php" method="post">
            <label for="category">
                作業内容
                <input name="category" required>
            </label>
            <label for="today">
                日にち
                <input name="today" required
                    value="<?php echo date('n/j'); ?>">
            </label>
            <label for="sta">
                開始時間
                <input name="sta" required
                    value="<?php echo date('H:i'); ?>">
            </label>
            <label for="email">
                <input name="email" type="hidden"
                    value="<?php echo $post_email ?>">
            </label>
            <button type="submit" name="submit">登録</button>
        </form>
        <a href="mypage.php">戻る</a>
    </main>
</body>

</html>