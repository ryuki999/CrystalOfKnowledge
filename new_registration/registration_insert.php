<?php
session_start();

//データベース接続
require_once "../db_connect.php";
//db_connect.php内の関数pdo()
$pdo = pdo();

//エラーメッセージの初期化
$errors = array();
 
if(empty($_POST["registration"])) {
	header("Location: registration_mail_form.php");
	exit();
}
 
$mail = $_SESSION['mail'];
$user_name = $_SESSION['user_name'];
 
//パスワードのハッシュ化
$password_hash =  password_hash($_SESSION['password'], PASSWORD_DEFAULT);
 
//ここでデータベースに登録する
try{
	//トランザクション開始
	$pdo->beginTransaction();
	
	//userテーブルに本登録する
	$stmt = $pdo->prepare("INSERT INTO user (user_id,user_name,mail,password) VALUES (:user_id,:user_name,:mail,:password_hash)");
	
	//プレースホルダへ実際の値を設定する
	$stmt->bindParam(':user_id', $row_count, PDO::PARAM_INT);
	$stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
	$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
	$stmt->bindParam(':password_hash', $password_hash, PDO::PARAM_STR);
	$stmt->execute();
		
	//pre_memberのflagを1にする
	$stmt = $pdo->prepare("UPDATE pre_user SET flag=1 WHERE mail=:mail");
	//プレースホルダへ実際の値を設定する
	$stmt->bindParam(':mail', $mail, PDO::PARAM_STR);
	$stmt->execute();
	
	// トランザクション完了（コミット）
	$pdo->commit();
		
	//データベース接続切断
	$pdo = null;
	
	//セッション変数を全て解除
	$_SESSION = array();
	
	//セッションクッキーの削除・sessionidとの関係を探れ。つまりはじめのsesssionidを名前でやる
	if (isset($_COOKIE["PHPSESSID"])) {
    		setcookie("PHPSESSID", '', time() - 1800, '/');
	}
	
 	//セッションを破棄する
 	session_destroy();
 	
}catch (PDOException $e){
	//トランザクション取り消し（ロールバック）
	$pdo->rollBack();
	$errors['error'] = "もう一度やりなおして下さい。";
	print('Error:'.$e->getMessage());
}
 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>会員登録完了画面</title>

    <!--CSSリンク-->
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちら会員登録完了画面registration_insert.phpです</p>
        <p class="logo"><a href="">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->

      <?php if (count($errors) == 0): ?>
      <h1>会員登録完了画面</h1>
      
      <p>登録完了いたしました。ログイン画面からどうぞ。</p>
      <p><a href="http://web-app.ryuki999.com/core_system/login.php">ログイン画面</a></p>
      
      <?php elseif(count($errors) > 0): ?>
      
      <?php
      foreach($errors as $value){
        echo "<p>".$value."</p>";
      }
      ?>
      
      <?php endif; ?>

      <!-- ↓削除不可 -->
      <p id="cds">Designed by <a href="http://www.css-designsample.com/">CSS.Design Sample</a></p>
      <div id="footer">
        <!-- コピーライト / 著作権表示 -->
        <p>Copyright &copy; Crystal Of Knowledge . All Rights Reserved.</p>
      </div>
    </div>