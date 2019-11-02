<?php
  //データベースに接続する関数

  function pdo(){
    
      $dsn = "mysql:dbname=crystal of knowledge;host=localhost";
      $user = "root";
      $password = "wonder578";
    /*
      $dsn = "mysql:dbname=tb210319db;host=localhost";
      $user = "tb-210319";
      $password = "mttwXtjr5Y";
      
      
      $dsn = "mysql:dbname=LAA1070277-8d6jco;host=mysql138.phy.lolipop.lan";
      $user = "LAA1070277";
      $password = "EWmB5mIU";
      */
      $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

      return $pdo;
}
?>