<?php
  session_start();
  $userid = $_SESSION["ID"];
  $username = $_SESSION["NAME"];
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>登録本リスト</title>
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちらは登録本リストbook_my_list.phpです</p>
        <p class="logo"><a href="">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->

      <div id="contents">

      <h3>マイ登録本リスト</h3>

      <?php
      //DB接続
      require_once("../db_connect.php");
      $pdo = pdo();

      //ログイン中のユーザIDと一致するフィールドを持つ行をuser_bookから抽出
      $sql = $pdo->prepare("SELECT * FROM user_book WHERE user_id=:user_id");
      $sql->bindParam(':user_id', $userid, PDO::PARAM_INT);
      $sql->execute();
      $book = $sql->fetchAll();
      ?>
      
      <!--ログイン中のユーザが登録している本を表示-->
      <?php if($book):?>
        <?php foreach ($book as $item):?>
        <?php 
          $data = "https://www.googleapis.com/books/v1/volumes?q=".$item["book_identifer_id"];

          require_once "../get_json.php";
          $json_decode = get_json($data);
  
          $json_item = $json_decode['items'][0];
        ?>
        
        <table class="table" border="0">
          <thead>
            <tr>
              <!--1列目--->
              <th>本表紙</th>
              <!--2列目-->
              <th></th>
              <!--3列目-->
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <!--1列目-->
              <td rowspan="7"><img src="<?=$json_item["volumeInfo"]["imageLinks"]["smallThumbnail"]?>" alt="" border="0" /></td>
              <!--2列目-->
              <tr>
                <th>本タイトル</th>
              </tr>
              <tr>
                <td>
                  <?php
                  if(strlen($json_item['volumeInfo']['title']) > 40){
                    echo mb_substr($json_item['volumeInfo']['title'],0,40,'utf-8').".....";
                  }else{
                    echo $json_item['volumeInfo']['title'];
                  }
                  ?></a></td>
              </tr>
              <tr></tr>
              <tr>
                <th>著者名</th>
              </tr>
              <tr>
                <td><?php if(array_key_exists("authors",$json_item["volumeInfo"])):echo $json_item["volumeInfo"]["authors"][0]."著";endif; ?></td>
              </tr>
              <!--2列目ここまで-->
              <!--3列目ここから-->
              <td><form method="POST" action="my_book_info.php">
                  <input type="hidden" name="book_id" value="<?=$item["book_id"]?>">
                  <input type="submit" value="登録情報">
              </form></td>
              <!--3列目ここまで-->
            </tr>
          </tbody>
        </table>
        <?php endforeach; ?>
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
