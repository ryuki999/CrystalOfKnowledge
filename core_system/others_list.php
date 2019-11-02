<?php
  session_start();
  $userid = $_SESSION["ID"];
  $username = $_SESSION["NAME"]
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>他ユーザリスト</title>
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちらは他ユーザリストother_llist.phpです</p>
        <p class="logo"><a href="">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->
      <div id="contents">
      <h3>他ユーザリスト</h3>
      <?php
        //DB接続
        require_once "../db_connect.php";
        $pdo = pdo();
        //全てのユーザを抜き出す
        $stmt = $pdo->query('SELECT * FROM user');
      ?>

      <!--システムに登録されているユーザ情報を一覧表示-->
      <table class="table">
        <thead>
          <tr>
            <th>ユーザID</th>
            <th>ユーザ名</th>
            <th>登録冊数</th>
            <th>総ページ数</th>
          </tr>
        </thead>
        <tbody>
        <?php if($stmt): $results = $stmt->fetchAll();?>
          <?php foreach ($results as $row):?>
            <?php if($row["user_id"] != $userid): //ログイン中のユーザIDが一致する行は表示させない?>
            <tr>
              <td><?=$row["user_id"]?></td>
              <td><a href="others_book_list.php?user_id=<?=$row["user_id"]?>"><?=$row["user_name"]?></a></td>
              <td><?=$row["total_books"]."冊"?></td>
              <td><?=$row["total_pages"]."ページ"?></td>

              <td><form name="others_book_list" method="GET" action="others_book_list.php">
                <input type="submit" value="本登録状況">
                <input id="user_id" name="user_id" type="hidden" value="<?=$row["user_id"]?>">
                </form></td>
            </tr>
            <?php endif;?>
          <?php endforeach; ?>
        <?php endif;?>
        </tbody>
      </table>

      <!-- コンテンツここまで -->
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
