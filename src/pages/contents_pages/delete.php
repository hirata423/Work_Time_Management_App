<?php

require_once '../../../db_connect.php';//connect()

try {
    $sql_delete = 'DELETE FROM times WHERE id = :id';
    $stmt = connect()->prepare($sql_delete);
    $stmt->bindValue(':id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->rowCount();
    $message = "作業記録を{$count}件削除しました。";
    header("Location:read.php?message={$message}");
} catch (PDOException $e) {
    exit($e->getMessage());
}
