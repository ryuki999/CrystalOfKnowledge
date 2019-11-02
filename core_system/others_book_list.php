<?php
  session_start();
  $userid = $_SESSION["ID"];
  $username = $_SESSION["NAME"];
  $others_id = $_GET["user_id"];
?>
<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>他ユーザ登録本リスト</title>
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちらは他ユーザ登録本リストbook_other_list.phpです</p>
        <p class="logo"><a href="">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->

      <div id="contents">

      <?php
      //DB接続
      require_once "../db_connect.php";
      $pdo = pdo();

      //受け渡された他ユーザIDを元に、他ユーザの情報を抽出
      $sql = $pdo->prepare("SELECT * FROM user WHERE user_id=:user_id");
      $sql->bindParam(':user_id', $others_id, PDO::PARAM_INT);
      $sql->execute();
      $user = $sql->fetch();
      ?>

      <h3>ユーザ名:<?=$user["user_name"]?>の登録本リスト<h3>
      
      <?php
      //他ユーザIDを元に、登録されている本の情報を抽出
      $sql = $pdo->prepare("SELECT * FROM user_book WHERE user_id=:user_id");
      $sql->bindParam(':user_id', $others_id, PDO::PARAM_INT);
      $sql->execute();
      $book = $sql->fetchAll();
      ?>

      <!--他のユーザが登録している本のリストを表示-->
      <?php if($book):?>
        <?php foreach ($book as $item):?>
        <?php 
          //GoogleBooksApiより本データを取得
          $data = "https://www.googleapis.com/books/v1/volumes?q=".$item["book_identifer_id"];

          //jsonデータを取得してphpへ
          require_once "../get_json.php";
          $json_decode = get_json($data);
  
          $json_item = $json_decode['items'][0];
        ?>
        <!--本情報を表示-->
        <table class="table" border="0">
          <thead>
            <tr>
              <th>本表紙</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td rowspan="7"><img src="<?=$json_item["volumeInfo"]["imageLinks"]["smallThumbnail"]?>" alt="" border="0" /></td>
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
              <!--3列目ここから-->
              <td><form method="POST" action="others_book_info.php">
                <input type="submit" value="登録情報">
                <input type="hidden" name="others_book_id" value="<?=$item["book_id"]?>">
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
