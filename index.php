<?php
session_start();
require_once 'user_logic.php';//checkLogin()
$result = UserLogic::checkLogin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/index.css">
    <title>作業時間管理アプリー誰でも簡単に時間を管理-無料</title>
</head>

<?php require_once "templates/header.php" ?>


<body>
    <main>
        <h2>作業時間管理アプリ</h2>
        <tl>
            <tb>仕事</tb>
            <tb>勉強</tb>
            <tb>娯楽</tb>
        </tl>
        <p>などの時間を<span>視える化</span>する</p>

        <p>
            <?php echo $result ?
                "<a href='/src/pages/contents_pages/mypage.php'>マイページ</a>" :
                "<a href='/src/pages/auth_pages/login_form.php'>ログイン</a>"?>
        </p>

    </main>
    <?php require_once "templates/footer.php" ?>
</body>


</html>