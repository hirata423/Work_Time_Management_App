<?php
session_start();
require_once '../../../user_logic.php';//checkLogin()
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

//検索文字の判定
try {
    if (isset($_GET['keyword'])) {
        $keyword = $_GET['keyword'];
    } else {
        $keyword = null;
    }

    //変数と認識させるためには{"全体文= '　".$変数."　'　"}
    $sql_select =
    "SELECT * FROM times WHERE category LIKE :keyword
    AND email = '".$post_email."'";
    $stmt = connect()->prepare($sql_select);
    $partial_match = "%{$keyword}%";
    $stmt->bindValue(':keyword', $partial_match, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit($e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0">
    <linK rel="stylesheet" href="../../../styles/read.css">
    <link rel="stylesheet" href="../../../styles/header.css">
    <title>作業時間管理アプリ-作業内容一覧</title>
</head>

<?php require_once "../../../templates/header.php" ?>

<body>

    <main>

        <h2>記録一覧</h2>

        <!-- ページング処理をする -->

        <?php
             if (isset($_GET['message'])) {
                 echo "<p>{$_GET['message']}</p>";
             } ?>
        <div>
            <form action="read.php" method="get" class="search-form">
                <input type="text" class="search-box" placeholder="内容で検索" name="keyword"
                    value="<?= $keyword ?>">
            </form>
            <a href="create.php" class="category_button" title="作業を開始できます">開始</a>
            <a href="mypage.php" class="mypage_button" title="マイページに戻ります">戻る</a>
        </div>
        <table>
            <tr>
                <th>内容</th>
                <th>日にち</th>
                <th>開始時間</th>
                <th>終了時間</th>
                <th>経過時間</th>
            </tr>
            <?php
    foreach ($results as $result) {
        $table = "
            <tr>
            <td>{$result['category']}</td>
            <td>{$result['today']}</td>
            <td>{$result['sta']}</td>
            <td>{$result['fin']}</td>
            <td>{$result['diff']}</td>
            <td><a href='update.php?id={$result['id']}' title='作業の終了、内容の更新ができます'>更新</a></td>    
            <td><a href='delete.php?id={$result['id']}' title='作業内容の削除ができます' >削除</a></td>   
            </tr>
        ";
        echo $table;
    }
?>

        </table>
    </main>

</body>

</html>