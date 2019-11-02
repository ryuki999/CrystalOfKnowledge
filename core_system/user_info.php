<?php
  session_start();
  $userid = $_SESSION["ID"];
  $username = $_SESSION["NAME"]
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>ユーザ情報画面</title>

    <!--CSSリンク-->
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちらユーザ情報画面user_info.phpです</p>
        <p class="logo"><a href="">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->

      <div id="contents">
      <h3>ユーザ情報</h3>
      <?php
        //DB接続
        require_once "../db_connect.php";
        $pdo = pdo();
        //ユーザIDが一致する行を抜き出す
        $sql = $pdo->prepare("SELECT * FROM user WHERE user_id=:user_id");
        $sql->bindParam(':user_id', $userid, PDO::PARAM_STR);
        $sql->execute();
        $user = $sql->fetch();
      ?>
      
      <!--ユーザの基本情報を表示-->
      <?php if($user):?>
      <table class="table">
        <thead>
          <tr>
            <th>ユーザ名</th>
            <th>登録冊数</th>
            <th>総ページ数</th>
          </tr>
        </thead>
        <tbody>
            <tr>
              <td><?=$user["user_name"]?></td>
              <td><?=$user["total_books"]."冊"?></td>
              <td><?=$user["total_pages"]."ページ"?></td>
            </tr>
        </tbody>
      </table>
      <?php endif;?>
      </div><!-- // contents end -->


      <div id="sidebar">
        <!-- サイドバーここから -->
        <p class="side-title">
        <?php echo "ユーザ名:".$username."でログイン中"."<br>";?></p>
        <ul class="localnavi">
          <li><a href="user_info.php">ユーザ情報</a></li>
          <li><a href="others_list.php">他ユーザリスト</a></li>
          <li><a href="my_book_list.php"">登録本リスト</a></li>
          <li><a href="book_search.php">本検索</a></li>
          <li><a href="login.php">ログアウト</a></li>
        </ul>
      </div>
      <!-- サイドバーここまで -->
      <!-- // sidebar end -->


      <!-- ↓削除不可 -->
      <p id="cds">Designed by <a href="http://www.css-designsample.com/">CSS.Design Sample</a></p>
      <div id="footer">
        <!-- コピーライト / 著作権表示 -->
        <p>Copyright &copy; Crystal Of Knowledge . All Rights Reserved.</p>
      </div>
    </div>

  </body>
</html>
