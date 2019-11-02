<?php
  session_start();
  $userid = $_SESSION["ID"];
  $username = $_SESSION["NAME"];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>本詳細</title>
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちらは本詳細book_detail.php です</p>
        <p class="logo"><a href="">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->
      <div id="contents">

      <!--検索した結果の中から１つに選んだ本の詳細を表示-->
      <?php
      if(!empty($_GET["id"])):
        //GoogleBooksApiより本データを取得
        $data = "https://www.googleapis.com/books/v1/volumes?q=".$_GET["id"];

        //jsonデータを取得してphpへ
        require_once "../get_json.php";
        $json_decode = get_json($data);

        $json_item = $json_decode['items'][0];
      ?>
      <img src="<?=$json_item["volumeInfo"]["imageLinks"]["smallThumbnail"]?>" border="0" />
      <table class="table" border="1"> <!--　外側のテーブル border="0"にして枠が表示されないようにする-->
        <tbody>
        <tr>
          <th>本タイトル</th>
          <td><?php echo $json_item["volumeInfo"]["title"]?></td>
        </tr>
        <tr>
          <th>著者名</th>
          <td><?php
          if(array_key_exists("authors",$json_item["volumeInfo"])){
            foreach($json_item["volumeInfo"]["authors"] as $row){
              echo $row;
            }
            echo "著";
          } ?></td>
        </tr>
        <tr>
          <th>出版社</th>
          <td><?php
          if(array_key_exists("publisher",$json_item["volumeInfo"])){
            echo $json_item["volumeInfo"]["publisher"];
          } ?></td>
        </tr>
        <tr>
          <th>出版日</th>
          <td><?php
          if(array_key_exists("publishedDate",$json_item["volumeInfo"])){
            echo $json_item["volumeInfo"]["publishedDate"];
          } ?></td>
        </tr>
        <tr>
          <th>概要</th>
          <td><?php
          if(array_key_exists("description",$json_item["volumeInfo"])){
            echo $json_item["volumeInfo"]["description"];
          } ?></td>
        </tr>
        </tbody>
      </table>
      <?php endif;?>
      
      <table>
        <tr>
          <form method="GET" action="my_book_registration.php">
            <input type="hidden" name="my_book_registration" value="<?=$json_item["id"]?>">
            <input type="submit" value="登録">
          </form>
          <form method="GET" action="book_search.php">
            <input type="submit" value="戻る">
            <input type="hidden" value="">
          </form>
        </tr>
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

      <!-- ↓削除不可 -->
      <p id="cds">Designed by <a href="http://www.css-designsample.com/">CSS.Design Sample</a></p>
      <div id="footer">
        <!-- コピーライト / 著作権表示 -->
        <p>Copyright &copy; Crystal Of Knowledge . All Rights Reserved.</p>
      </div>
    </div>

  </body>
</html>
