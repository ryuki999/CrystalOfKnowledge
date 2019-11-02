<?php
require_once "../db_connect.php";
//DBへ接続
$pdo = pdo();
// セッション開始
session_start();

// エラーメッセージの初期化
$errorMessage = "";

// ログインボタンが押された場合
if (isset($_POST["login"])) {
  // ユーザ名、パスワードの入力チェック
  if (empty($_POST["username"])) {
    $errorMessage = 'ユーザー名が未入力です。';
  } else if (empty($_POST["password"])) {
    $errorMessage = 'パスワードが未入力です。';
  }
  
  //ユーザ名、パスワードが空でないとき
  if (!empty($_POST["username"]) && !empty($_POST["password"])) {  
    // 入力されたユーザID,パスワードを格納
    $username = $_POST["username"];        
    $password = $_POST["password"];
    // 3. エラー処理
    try {
      //ユーザ名が一致する行を抜き出す
      $stmt = $pdo->prepare('SELECT * FROM user where user_name = ?');
      $stmt->execute(array($username));
      
      if ($row = $stmt->fetch()) {  //検索結果があるとき
        if (password_verify($password, $row['password'])) {  //入力されたパスワードとハッシュ化されたパスワードが一致するとき
          session_regenerate_id(true);
          $_SESSION["ID"] = $row['user_id'];    //ユーザID
          $_SESSION["NAME"] = $row['user_name'];  // ユーザー名

          header("Location: user_info.php");  // メイン画面へ遷移
          exit();  // 処理終了
        } else {
          // 認証失敗
          $errorMessage = 'ユーザー名あるいはパスワードに誤りがあります。';
        }
      } else {
        // 該当データなし
        $errorMessage = 'ユーザー名あるいはパスワードに誤りがあります。';
      }
    } catch (PDOException $e) {
      $errorMessage = 'データベースエラー';
    } 
  }  
}
?>

<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>ログイン or 新規登録</title>
    <!--CSSリンク-->
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
    <!-- base layout css.design sample -->
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちらはログイン or 新規登録login_register.phpです</p>
        <p class="logo"><a href="../index.php">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->

      <div id="contents">
      <h3>ご自身の持っているユーザIDとパスワードを入力しましょう！</h3>
          <form id="loginForm" name="loginForm" action="" method="POST">
              <!--<fieldset>-->
                  <legend>ログインフォーム</legend>
                  <div><font color="#ff0000"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES); ?></font></div>
                  <label for="userid">ユーザー名</label><input type="text" id="username" name="username" placeholder="ユーザー名を入力"
                  value="<?php if (!empty($_POST["username"])) {echo htmlspecialchars($_POST["username"], ENT_QUOTES);} ?>">
                  <br>
                  <label for="password">パスワード</label><input type="password" id="password" name="password" value="" placeholder="パスワードを入力">
                  <br>
        <div style="display:inline-flex">
                  <input type="submit" id="login" name="login" value="ログイン">
              <!--</fieldset>-->
          </form>

          <form action="../index.php">
            <input type="submit" value="戻る">
          </form>
        </div>
        <br>

      <!-- コンテンツここまで -->
      </div><!-- // contents end -->
      
      <!-- ↓削除不可 -->
      <p id="cds">Designed by <a href="http://www.css-designsample.com/">CSS.Design Sample</a></p>
      <div id="footer">
        <!-- コピーライト / 著作権表示 -->
        <p>Copyright &copy; Crystal Of Knowledge . All Rights Reserved.</p>
      </div>
    </div>

  </body>
</html>
