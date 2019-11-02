<?php
  session_start();
  $userid = $_SESSION["ID"];
  $username = $_SESSION["NAME"];
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
  <head>
  <meta charset="utf-8">
    <title>本登録</title>
    <link rel="stylesheet" href="../base.css" type="text/css" media="screen" />
  </head>
  <body>

    <div id="wrapper">
      <div id="header">
        <p class="description">こちらは本登録book_registration.php です</p>
        <p class="logo"><a href="">Crystal Of Knowledge</a></p>
      </div><!-- // header end -->
      <div id="contents">
      <h3>読了本登録</h3>
      <?php
      if(!empty($_GET["my_book_registration"])){
        $data = "https://www.googleapis.com/books/v1/volumes?q=".$_GET["my_book_registration"];

        //jsonデータを取得してphpへ
        require_once "../get_json.php";
        $json_decode = get_json($data);

        $json_item = $json_decode['items'][0];

        //データベースに登録する
        try{
          //DB接続
          require_once "../db_connect.php";
          $pdo = pdo();

          //各変数に登録本の情報を格納
          $book_identifer_id = $json_item["id"];
          $book_title = $json_item["volumeInfo"]["title"];
          $page = $json_item["volumeInfo"]["pageCount"];
          $book_date = date('Y-m-d');
          $book_comment = "";
      
          //挿入処理
          $sql = $pdo -> prepare("INSERT INTO user_book (user_id, book_identifer_id, book_title, page, book_date, book_comment) 
          VALUES (:user_id, :book_identifer_id, :book_title, :page, :book_date, :book_comment)");
          //プレースホルダへ実際の値を設定する
          $sql -> bindParam(':user_id', $userid, PDO::PARAM_INT);               //ユーザID
          $sql -> bindParam(':book_identifer_id', $book_identifer_id, PDO::PARAM_STR);  //本の識別ID
          $sql -> bindParam(':book_title', $book_title, PDO::PARAM_STR);          //本のタイトル
          $sql -> bindParam(':page', $page, PDO::PARAM_INT);                   //本のページ数
          $sql -> bindParam(':book_date', $book_date, PDO::PARAM_STR);         //本の登録日
          $sql -> bindParam(':book_comment', $book_comment, PDO::PARAM_STR);  //本のコメント
          $sql -> execute();

          //ログインユーザの総ページ数と総冊数を抜き出し
          $sql = $pdo->prepare("SELECT total_pages,total_books FROM user WHERE user_id=:user_id");
          $sql->bindParam(':user_id', $userid, PDO::PARAM_STR);
          $sql->execute();
          $result = $sql->fetch();
          
          //総ページ数と総冊数を更新
          $total_books = $result["total_books"] + 1;
          $total_pages = $result["total_pages"] + $page;
          
          //userのtotal_pagesとtotal_booksを更新する
          $stmt = $pdo->prepare("UPDATE user SET total_pages=:total_pages,total_books=:total_books WHERE user_id=:user_id");
          //プレースホルダへ実際の値を設定する
          $stmt->bindParam(':user_id', $userid, PDO::PARAM_STR);
          $stmt->bindParam(':total_pages', $total_pages, PDO::PARAM_STR);
          $stmt->bindParam(':total_books', $total_books, PDO::PARAM_STR);
          $stmt->execute();
          
          //データベース接続切断
          $pdo = null;
          
        }catch (PDOException $e){
          print('Error:'.$e->getMessage());
        }
      }
      
      ?>

      <?php echo "「".$book_title."」の登録が完了しました。"."<br>";?></p>
      <a href="my_book_list.php"">登録本リスト</a>

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