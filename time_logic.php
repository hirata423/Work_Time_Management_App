<?php

require_once 'db_connect.php';

class TimeLogic
{
    //Docの書き方復習
    /**
     * 時間を登録する
     * @param string $userDate ?
     */
    public static function createTime($timeData)
    {
        $sql_insert =
        "INSERT INTO times(category,today,sta,email)
        VALUES(:category,:today,:sta,:email)";

        try {
            $stmt = connect()->prepare($sql_insert);
            $stmt->bindValue(':category', $timeData['category'], PDO::PARAM_STR);
            $stmt->bindValue(':today', $timeData['today'], PDO::PARAM_STR);
            $stmt->bindValue(':sta', $timeData['sta'], PDO::PARAM_STR);
            $stmt->bindValue(':email', $timeData['email'], PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->rowCount();
            $message = "新規作業を{$count}件開始しました！";
            header("Location:read.php?message={$message}");
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    //Docの書き方復習
    /**
     * 時間を登録する
     * @param string $dateid ?
     */

    //考え中　＄productの中に追加済情報が含まれている
    public static function get_updateTime_id($dataId)
    {
        $sql_select = 'SELECT * FROM times WHERE id = :id';
        try {
            $stmt=connect()->prepare($sql_select);
            $stmt->bindValue(':id', $dataId['id'], PDO::PARAM_STR);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($product === false) {
                exit('idパラメータの値が不正です。');
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    //Docの書き方復習
    /**
     * 時間を登録する
     * @param string $timeData ?
     */
    public static function updateTime($timeData, $dataId)
    {
        $sql_update = 'UPDATE times SET diff = :diff , fin = :fin , sta=:sta , today=:today , category=:category WHERE id = :id';
        try {
            $stmt = connect()->prepare($sql_update);
            $stmt->bindValue(':diff', $timeData['diff'], PDO::PARAM_STR);
            $stmt->bindValue(':fin', $timeData['fin'], PDO::PARAM_STR);
            $stmt->bindValue(':sta', $timeData['sta'], PDO::PARAM_STR);
            $stmt->bindValue(':today', $timeData['today'], PDO::PARAM_STR);
            $stmt->bindValue(':category', $timeData['category'], PDO::PARAM_STR);
            $stmt->bindValue(':id', $dataId['id'], PDO::PARAM_INT);
            $stmt->execute();
            $count = $stmt->rowCount();
            $message = "作業を{$count}件終了しました！";
            header("Location: read.php?message={$message}");
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}
