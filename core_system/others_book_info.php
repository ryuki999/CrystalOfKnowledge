<?php
  session_start();
  $userid = $_SESSION["ID"];
  $username = $_SESSION["NAME"];
  
  //他ユーザ本IDのPOSTデータがあればSESSIONに登録
  if(!empty($_POST["others_book_id"])){
    $_SESSION["others_book_id"] = $_POST["others_book_id"];
  }
  $book_others_id = $_SESSION["others_book_id"];
?>

<!DOCTYPE html >
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>他ユーザ登録本詳細</title>
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
    <!-- base layout css.design sample -->
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちらは他ユーザ登録本詳細book_others_info.phpです</p>
        <p class="logo"><a href="">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->

      <div id="contents">

      <?php
      //DBへ接続
      require_once "../db_connect.php";
      $pdo = pdo();

      //本IDからユーザが登録している本情報を抽出
      $sql = $pdo->prepare("SELECT * FROM user_book WHERE book_id=:book_id");
      $sql->bindParam(':book_id', $book_others_id, PDO::PARAM_INT);
      $sql->execute();
      $book = $sql->fetch();
      ?>

      <h3>ユーザ名:<?=$username?>の「<?=$book["book_title"]?>」登録本詳細<h3>
    
        <?php
          //GoogleBooksApiより本データを取得 
          $data = "https://www.googleapis.com/books/v1/volumes?q=".$book["book_identifer_id"];
          
          //jsonデータを取得してphpへ
          require_once "../get_json.php";
          $json_decode = get_json($data);
  
          $json_item = $json_decode['items'][0];
        ?>
        <!--他ユーザが登録している本情報を表示-->
        <table class="table" border="0">
          <thead>
            <tr>
              <th>本表紙</th>
              <th>基本情報</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <!--1列目ここから-->
              <td rowspan="9"><img src="<?=$json_item["volumeInfo"]["imageLinks"]["smallThumbnail"]?>" alt="" border="0" /></td>
              <!--1列目ここまで-->
              <!--2列目ここから-->
              <!--1行目-->
              <tr>
                <th>本タイトル</th>
              </tr>
              <!--1行目end-->
              <!--2行目-->
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
              <!--2行目end-->
              <!--3行目-->
              <tr>
                <th>著者名</th>
              </tr>
              <!--3行目end-->
              <!--4行目-->
              <tr>
                <td><?php
                    if(array_key_exists("authors",$json_item["volumeInfo"])){
                        foreach($json_item["volumeInfo"]["authors"] as $row){
                        echo $row;
                        }
                        echo "著";
                    } ?></td>
              </tr>
              <!--4行目end-->
              <tr>
                <th>登録年月日</th>
              </tr>
              <tr>
                <td><?php echo $book["book_date"]; ?></td>
              </tr>
              <tr>
                  <th>本の感想・コメント</th>
              </tr>
              <!--6行目-->
              <tr>
                <td><?php echo $book["book_comment"];?></td>
              </tr>
              <!--6行目end-->
              <!--2列目ここまで-->
            </tr>
          </tbody>
        </table>

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
