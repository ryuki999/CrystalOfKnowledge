<?php
  //データベースに接続する関数

  function pdo(){
    
      $dsn = "mysql:dbname=crystal of knowledge;host=localhost";
      $user = "root";
      $password = "********";

      $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

      return $pdo;
}
?>
