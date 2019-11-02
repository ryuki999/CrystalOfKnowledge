<?php
session_start();

//エラーメッセージの初期化
$errors = array();
 
if(empty($_POST)) {
	header("Location: registration_mail_form.php");
	exit();
}else{
	//POSTされたデータを各変数に入れる
	$user_name = $_POST['user_name'];
  $password = $_POST['password'];
  
  //ユーザ名入力判定
	if ($user_name == ''){
		$errors['user_name'] = "ユーザ名が入力されていません。";
  }elseif(mb_strlen($user_name)>10){
		$errors['user_name_length'] = "ユーザ名は10文字以内で入力して下さい。";
  };
	
	//パスワード入力判定
	if ($password == ''){
		$errors['password'] = "パスワードが入力されていません。";
  }elseif(!preg_match('/^[0-9a-zA-Z]{3,30}$/', $_POST["password"])){
		$errors['password_length'] = "パスワードは半角英数字の3文字以上30文字以下で入力して下さい。";
	}else{
    $password_hide = str_repeat('*', strlen($password));
  }
}
 
//エラーが無ければセッションに登録
if(count($errors) == 0){
	$_SESSION['user_name'] = $user_name;
	$_SESSION['password'] = $password;
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>会員登録確認画面</title>

    <!--CSSリンク-->
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
    <!-- base layout css.design sample -->
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちら会員登録確認画面registration_check.phpです</p>
        <p class="logo"><a href="">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->

      <?php if (count($errors) == 0): ?>
      
      <form action="registration_insert.php" method="post">
      <p>メールアドレス：<label><?php echo htmlspecialchars($_SESSION['mail'])?></label></p>
      <p>ユーザ名：<label><?php echo htmlspecialchars($user_name)?></label></p>
      <p>パスワード：<?=$password_hide?></p>
      <input type="hidden" value="">
      <input type="button" value="戻る" onClick="history.back()">
      <input type="submit" name="registration" value="登録する">
      </form>
        
      <?php elseif(count($errors) > 0): ?>
        
      <?php
      foreach($errors as $value){
        echo "<p>".$value."</p>";
      }
      ?> 
      <input type="button" value="戻る" onClick="history.back()">
        
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
