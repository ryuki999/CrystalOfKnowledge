<?php
  session_start();
  $userid = $_SESSION["ID"];
  $username = $_SESSION["NAME"];
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>本検索</title>
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちらは本検索book_search.php です</p>
        <p class="logo"><a href="">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->

      <div id="contents">
      <h2>本検索</h2>
      <h4>タイトル・著者名など入力してお求めの本を検索しましょう！</h4>
      <form method="POST">
      <!--<fieldset>-->
          <label for="book_search">本検索ボックス</label><br>
          <input type="text" id="book_search" name="book_search" placeholder="タイトルを入力"
           value="<?php if(empty($_POST["book_search"])){echo "";}else{ echo $_POST["book_search"];}?>">
          <br>
          <input type="submit" value="本検索">
      <!--</fieldset>-->
      </form><hr>
      <?php
      if(!empty($_POST["book_search"])):
        //googlebooksAPIへ本情報を要求
        $data = "https://www.googleapis.com/books/v1/volumes?q=".$_POST["book_search"];

        //jsonデータを取得してphpへ
        require_once "../get_json.php";
        $json_decode = get_json($data);
        
      ?>
      <!--検索結果の本を表示-->
      <?php foreach ($json_decode['items'] as $item):?>
      <table class="table" border="0">
        <thead>
          <tr>
            <th>本表紙</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td rowspan="7"><a href="my_book_detail.php?id=<?=$item["id"]?>">
              <img src="<?=$item["volumeInfo"]["imageLinks"]["smallThumbnail"]?>" alt="my_book_detail.php?id=<?=$item["id"]?>" border="0" />
            </a></td>
            <tr>
              <th>本タイトル</th>
            </tr>
            <tr>
              <td><a href="my_book_detail.php?id=<?=$item["id"]?>">
                <?php //40字以降のタイトルは"..."で表示
                if(strlen($item['volumeInfo']['title']) > 40){
                  echo mb_substr($item['volumeInfo']['title'],0,40,'utf-8').".....";
                }else{
                  echo $item['volumeInfo']['title'];
                }
                ?></a></td>
            </tr>
            <tr></tr>
            <tr>
              <th>著者名</th>
            </tr>
            <tr>
              <td><?php if(array_key_exists("authors",$item["volumeInfo"])):echo $item["volumeInfo"]["authors"][0]."著";endif; ?></td>
            </tr>
          </tr>

        <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>  
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
