<?php

session_start();

require_once '../../../user_logic.php';//checkLogin()

$result = UserLogic::checkLogin();
if ($result) {
    header('Location:../contents_pages/mypage.php');
    return;
}

$err = $_SESSION;

//リロード時にセッション、セッションファイルを削除
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
    <link rel="stylesheet" href="../../../styles/sign_login.css">
    <title>作業時間管理アプリ-ログインフォーム</title>
</head>

<body>
    <h2>ログインホーム</h2>

    <?php if (isset($err['msg'])): ?>
    <p class="session_message">
        <?php echo $err['msg'];?>
    </p>
    <?php endif; ?>

    <form action="login.php" method="post">

        <P>
        <P>E-mail</P>
        <input class="user_input" name="email" type="email" placeholder="emailを入力">
        <?php if (isset($err['email'])): ?>
        <p class="session_message">
            <?php echo $err['email'];?>
        </p>
        <?php endif; ?>
        </P>

        <P>
        <p>Password</p>
        <input class="user_input" type="password" name="password" placeholder="passwordを入力">
        <?php if (isset($err['password'])): ?>
        <p class="session_message">
            <?php echo $err['password'];?>
        </p>
        <?php endif; ?>
        </P>

        <p>
            <button class="submit_input" type="submit" name="submit">ログイン</button>
        </p>

    </form>
    <P>
        <a href="signup_form.php" type="button">新規登録はコチラ</a>
    </P>

</body>

</html>