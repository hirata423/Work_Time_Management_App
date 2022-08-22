<?php
session_start();
require_once 'functions.php';
require_once 'user_logic.php';
$result = UserLogic::checkLogin();
if ($result) {
    header('Location:mypage.php');
    return;
}
$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);

$err = $_SESSION;
$_SESSION = array();
//session_destroy();置くと’不正なアクセスで探知’される

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/sign_login.css">
    <title>新規ユーザー作成</title>
</head>

<body>
    <h2>新規作成ホーム</h2>
    <!-- 未登録でmypagemへ遷移してしまったとき -->
    <?php if (isset($login_err)): ?>
    <p class="session_message">
        <?php echo $login_err;?>
    </p>
    <?php endif; ?>
    <!-- ユーザー登録に失敗したとき -->
    <?php if (isset($err['signup_err'])): ?>
    <p class="session_message">
        <?php echo $err['signup_err'];?>
    </p>
    <?php endif; ?>
    <form action="register.php" method="post">

        <P>
        <p>Name</p>
        <input class="user_input" name="username" type="name" placeholder="nameを入力">
        <?php if (isset($err['username'])): ?>
        <p class="session_message">
            <?php echo $err['username'];?>
        </p>

        <?php endif; ?>
        </P>


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
        <p>Passwordの確認</p>
        <input class="user_input" type="password" name="password_conf" placeholder="passwordを再入力">
        <?php if (isset($err['password_conf'])): ?>
        <p class="session_message">
            <?php echo $err['password_conf'];?>
        </p>
        <?php endif; ?>
        </p>

        <input type="hidden" name="csrf_token"
            value="<?php echo h(setToken()); ?>">
        <P>
            <button class="submit_input" type="submit" name="submit">登録</button>
        </P>
    </form>
    <P>
        <a href="login_form.php" type="button">登録済の方はコチラ</a>
    </P>
</body>

</html>