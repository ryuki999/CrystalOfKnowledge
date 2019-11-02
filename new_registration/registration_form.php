<?php
session_start();

//データベース接続
require_once "../db_connect.php";
//db_connect.php内の関数pdo()
$pdo = pdo();

//urltokenがあるときとないときで条件分岐
if(empty($_GET["urltoken"])) {
	header("Location: registration_mail_form.php");
	exit();
}else{
  //GETデータを変数に入れる
	$urltoken = $_GET["urltoken"];
  try{
    //flagが0の未登録者・仮登録日から24時間以内
    $stmt = $pdo->prepare("SELECT mail FROM pre_user WHERE urltoken=:urltoken AND flag =0 AND date > now() - interval 24 hour");
    $stmt->bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
    $stmt->execute();
    
    //レコード件数取得
    $row_count = $stmt->rowCount();
    
    //24時間以内に仮登録され、本登録されていないトークンの場合
    if($row_count ==1){
      $mail_array = $stmt->fetch();
      $mail = $mail_array["mail"];
      $_SESSION['mail'] = $mail;
    }else{
      $error = "このURLはご利用できません。有効期限が過ぎた等の問題があります。もう一度登録をやりなおして下さい。";
    }
    
    //データベース接続切断
    $pdo = null;
    
  }catch (PDOException $e){
    print('Error:'.$e->getMessage());
    die();
  }
}
 
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>会員登録画面</title>

    <!--CSSリンク-->
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
    <!-- base layout css.design sample -->
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちら会員登録画面registration_form.phpです</p>
        <p class="logo"><a href="../index.php">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->
      
      <!--$errorが空のとき、フォームの表示-->
      <?php if (empty($error)): ?>
      
      <form action="registration_check.php" method="post">
      <p>メールアドレス：<label><?php echo htmlspecialchars($mail)?></label></p>
      <p>ユーザ名：<input type="text" name="user_name"></p>
      <p>パスワード：<input type="texr" name="password"></p>
        
      <input type="submit" value="確認する">
      </form>

      <!--$errorが空でないとき、エラーの表示-->  
      <?php elseif(!empty($error)): ?>
        
      <?php 
      echo "<p>".$error."</p>";
      ?>
        
      <?php endif; ?>

      
      <!-- ↓削除不可 -->
      <p id="cds">Designed by <a href="http://www.css-designsample.com/">CSS.Design Sample</a></p>
      <div id="footer">
        <!-- コピーライト / 著作権表示 -->
        <p>Copyright &copy; Crystal Of Knowledge . All Rights Reserved.</p>
      </div>
    </div>

  </body>
</html>
