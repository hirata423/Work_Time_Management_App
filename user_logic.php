<?php

require_once 'db_connect.php';

class UserLogic
{
    /**
     * ユーザーを登録する
     * @param array $userDate
     * @return bool $result
     */
    public static function createUser($userDate)
    {
        $result = false;
        $sql_insert = 'INSERT INTO users(name,email,password)VALUES(?,?,?)';

        //ユーザーデータを配列に入れる
        $arr = [];
        $arr [] = $userDate['username'];
        $arr[] = $userDate['email'];
        $arr[] = password_hash($userDate['password'], PASSWORD_DEFAULT);

        try {
            $stmt=connect()->prepare($sql_insert);
            $result=$stmt->execute($arr);
            return $result;
        } catch (\Exception $e) {
            return $result;
        }
    }
    /**
     * ログイン処理
     * @param string $email
     * @param string $password
     * @return bool $result
     */
    public static function login($email, $password)
    {
        //結果
        $result = false;
        //ユーザーemailから検索して取得
        $user = self::getUserbyEmail($email);

        if (!$user) {
            $_SESSION['msg'] = '!emailが一致しません';
            return $result;
        }
        //パスワードの照会
        if (password_verify($password, $user['password'])) {
            //ログイン成功
            session_regenerate_id(true);
            $_SESSION['login_user'] = $user;
            $result = true;
            return $result;
        }
        $_SESSION['msg'] = '!passwordが一致しません';
        return $result;
    }
    /**
     * emailからユーザーを取得
     * @param string $email
     * @return array|bool $user|false
     */
    public static function getUserbyEmail($email)
    {
        //SQLの準備
        $sql_select = 'SELECT * FROM users WHERE email = ?';

        //emailを配列に入れる
        $arr = [];
        $arr[] = $email;

        try {
            //SQLの実行
            $stmt=connect()->prepare($sql_select);
            $result=$stmt->execute($arr);
            //SQLの結果を返す
            $user = $stmt->fetch();
            return $user;
        } catch (\Exception $e) {
            return $result;
        }
    }

    /**
     * ログインチェック
     * @param void
     * @return bool $result
     */
    public static function checkLogin()
    {
        $result = false;
        //セッションにログインユーザーが入ってなかったらfalse
        if (isset($_SESSION['login_user'])&& $_SESSION['login_user']['id'] >0) {
            return $result = true;
        }
    }
    /**
     * ログアウト処
     */
    public static function Logout()
    {
        $_SESSION = array();
        session_destroy();
    }
}
