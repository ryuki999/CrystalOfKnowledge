<?php
require 'phpmailer/phpmailer/src/Exception.php';
require 'phpmailer/phpmailer/src/PHPMailer.php';
require 'phpmailer/phpmailer/src/SMTP.php';
require 'phpmailer/phpmailer/setting.php';
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>メール確認・送信画面</title>

    <!--CSSリンク-->
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
    <!-- base layout css.design sample -->
  </head>
  
  <body>
    <div id="wrapper">
      <div id="header">
        <p class="description">こちらメール確認・送信画面registration_mail_form.phpです</p>
        <p class="logo"><a href="">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->

    <?php
	//エラーメッセージの初期化
	$errors = array();

	if(empty($_POST["mail"])) {
		header("Location: registration_mail_form.php");
		exit();
	}else{
		//POSTされたデータを変数に入れる
		$mail_address = htmlspecialchars($_POST['mail']);
	}

	//urlトークンの生成
	$urltoken = hash('sha256',uniqid(rand(),1));
	//$url = "https://tb-210319.tech-base.net/CrystalOfKnowledge/new_registration/registration_form.php"."?urltoken=".$urltoken;
	//$url = "http://localhost/php/CrystalOfKnowledge/new_registration/registration_form.php"."?urltoken=".$urltoken;
	$url = "http://web-app.ryuki999.com/new_registration/registration_form.php"."?urltoken=".$urltoken;
	
	// PHPMailerのインスタンス生成
	$mail = new PHPMailer\PHPMailer\PHPMailer();

	$mail->isSMTP(); // SMTPを使うようにメーラーを設定する
	$mail->SMTPAuth = true;
	$mail->Host = MAIL_HOST; // メインのSMTPサーバー（メールホスト名）を指定
	$mail->Username = MAIL_USERNAME; // SMTPユーザー名（メールユーザー名）
	$mail->Password = MAIL_PASSWORD; // SMTPパスワード（メールパスワード）
	$mail->SMTPSecure = MAIL_ENCRPT; // TLS暗号化を有効にし、「SSL」も受け入れます
	$mail->Port = SMTP_PORT; // 接続するTCPポート

	// メール内容設定
	$mail->CharSet = "UTF-8";
	$mail->Encoding = "base64";
	$mail->setFrom(MAIL_FROM,MAIL_FROM_NAME);
	$mail->addAddress($mail_address, '受信者さん'); //受信者（送信先）を追加する

	$mail->Subject = 'CrystalOfKnowledge'; // メールタイトル
	$mail->isHTML(true);    // HTMLフォーマットの場合はコチラを設定します

	$body = "登録確認メールの送信を受け付けました。"."24時間以内に下記のURLからご登録下さい。"."<br>"."{$url}";

	$mail->Body  = $body; // メール本文
	//$mail->SMTPDebug   = 2;

	//ここでデータベースに登録する
	try{
		require_once "../db_connect.php";
		//db_connect.php内の関数pdo()
		$pdo = pdo();
		
		$stmt = $pdo->prepare("INSERT INTO pre_user (urltoken,mail,date) VALUES (:urltoken,:mail,now() )");
		
		//プレースホルダへ実際の値を設定する
		$stmt->bindParam(':urltoken', $urltoken, PDO::PARAM_STR);
		$stmt->bindParam(':mail', $mail_address, PDO::PARAM_STR);
		$stmt->execute();
			
		//データベース接続切断
		$pdo = null;	
		
	}catch (PDOException $e){
		print('Error:'.$e->getMessage());
		die();
	}

	// メール送信の実行
	if(!$mail->send()) {
		echo 'メッセージは送られませんでした！';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	} else {
		echo '送信完了!送信されたメールに基づいて登録を続けて下さい';
	}
    ?>

      <!-- ↓削除不可 -->
      <p id="cds">Designed by <a href="http://www.css-designsample.com/">CSS.Design Sample</a></p>
      <div id="footer">
        <!-- コピーライト / 著作権表示 -->
        <p>Copyright &copy; Crystal Of Knowledge . All Rights Reserved.</p>
      </div>
    </div>

  </body>
</html>