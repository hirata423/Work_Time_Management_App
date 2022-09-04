<?php
session_start();
date_default_timezone_set('Asia/Tokyo');
require_once '../../../user_logic.php';//checkLogin()
require_once '../../../time_logic.php';//createTime()
require_once '../../../db_connect.php';//connect()

$result = UserLogic::checkLogin();
if (!$result) {
    $_SESSION['login_err']='ユーザーを登録してログインしてください';
    header('Location:../auth_pages/signup_form.php');
    return;
}

//更新する作業のIDを判定
//課題：URLから誰でも変更できてしまう
//if(ログインユーザーならみたいな){}
if (isset($_GET['id'])) {
    try {
        $sql_select = 'SELECT * FROM times WHERE id = :id';
        $stmt=connect()->prepare($sql_select);
        $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($product === false) {
            exit('idパラメータの値が不正です。');
        }
    } catch (PDOException $e) {
        exit($e->getMessage());
    }
} else {
    exit('idパラメータの値が存在しません。');
}

//更新,作業の終了
if (isset($_POST['submit'])) {
    TimeLogic::updateTime($_POST, $_GET);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
    <link rel="stylesheet" href="../../../styles/update.css">
    <link rel="stylesheet" href="../../../styles/header.css">
    <meta charset="UTF-8">
    <title>作業時間管理アプリ-作業終了・更新</title>
</head>

<?php require_once "../../../templates/header.php" ?>

<body>
    <main>
        <h2>終了時間</h2>
        <form
            action="update.php?id=<?= $_GET['id'] ?>"
            method="post">
            <table>
                <tr>
                    <th>内容</th>
                    <td name="category"><input name="category" class="category_input"
                            value="<?php echo $product['category'] ?>">
                    </td>
                </tr>
                <tr>
                    <th>日にち</th>
                    <td>
                        <input name="today"
                            value="<?php echo $product['today'] ?>">
                    </td>
                </tr>
                <tr>
                    <th>開始時間</th>
                    <td><input name="sta"
                            value="<?php echo $product['sta'] ?>">
                    </td>
                </tr>
                <tr>
                    <th>終了時間</th>
                    <td>
                        <input name="fin"
                            value="<?php echo date('H:i'); ?>">
                    </td>
                </tr>
                <tr>
                    <th>経過時間</th>
                    <td>
                        <input name="diff" value="<?php $now= new DateTime();
$sta = new DateTime($product['sta']);
$interval=$now->diff($sta);
echo $interval->format('%H:%i');?>">
                    </td>
                </tr>
            </table>
            <button type="submit" name="submit" title="作業の終了、内容の更新を決定します">登録</button>
            <button type="button" title="一覧に戻ります" onclick="location.href='read.php'">戻る</button>
        </form>

    </main>



</body>

</html>