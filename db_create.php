<?php

require_once "db_connect.php";
$pdo = pdo();
//$stmt = $pdo->query("DROP TABLE pre_user,user");

$sql = "CREATE TABLE IF NOT EXISTS pre_user"  //pre_userが存在しなければ作成
     ." ("
     . "id INT NOT NULL AUTO_INCREMENT PRIMARY KEY," //主キー
     . "urltoken VARCHAR(128) NOT NULL,"
     . "mail VARCHAR(50) NOT NULL,"
     . "date DATETIME NOT NULL,"
     . 'flag TINYINT(1) NOT NULL DEFAULT 0'
     .");";

$stmt = $pdo->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS user"
     ." ("
     . "user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY," //主キー
     . "user_name VARCHAR(50) NOT NULL,"
     . "mail VARCHAR(50) NOT NULL,"
     . "password VARCHAR(128) NOT NULL,"
     . 'flag TINYINT(1) NOT NULL DEFAULT 1,'
     . "total_books INT NOT NULL DEFAULT 0,"
     . "total_pages INT NOT NULL DEFAULT 0"
     .");";



$stmt = $pdo->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS user_book"  //user_bookが存在しなければ作成
    ." ("
    . "book_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY," //主キー
    . "user_id INT NOT NULL,"
    . "book_identifer_id VARCHAR(50) NOT NULL,"
    . "book_title VARCHAR(50) NOT NULL,"
    . "page INT NOT NULL DEFAULT 0,"
    . 'book_date DATE NOT NULL,'
    . "book_comment TEXT"
    .");";

$stmt = $pdo->query($sql);
$pdo = null;

?>