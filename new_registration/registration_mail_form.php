<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>メール登録フォーム画面</title>

    <!--CSSリンク-->
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
    <!-- base layout css.design sample -->
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちらメール登録フォーム画面registration_mail_form.phpです</p>
        <p class="logo"><a href="../index.php">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->
    
    <h1>メールアドレス登録フォーム</h1>
            
    <legend>メールアドレス登録フォーム</legend>
    <form action="registration_mail_check.php" method="post">
    <label for="mail_address"">メールアドレス</label>
    <input type="email" name="mail" size="50" value=""></p>
    <br>
    <input type="submit" value="メール送信">
    <input type="button" value="戻る" onClick="history.back()">
    </form>
    <br>

      <!-- ↓削除不可 -->
      <p id="cds">Designed by <a href="http://www.css-designsample.com/">CSS.Design Sample</a></p>
      <div id="footer">
        <!-- コピーライト / 著作権表示 -->
        <p>Copyright &copy; Crystal Of Knowledge . All Rights Reserved.</p>
      </div>
    </div>

  </body>
</html>
