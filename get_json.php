<?php
  //jsonファイルをphpに変換して返す関数

  function get_json($data){
    
    $cp = curl_init();
    /*オプション:リダイレクトされたらリダイレクト先のページを取得する*/
    curl_setopt($cp, CURLOPT_RETURNTRANSFER, 1);
    /*オプション:URLを指定する*/
    curl_setopt($cp, CURLOPT_URL, $data);
    /*オプション:タイムアウト時間を指定する*/
    curl_setopt($cp, CURLOPT_TIMEOUT, 30);
    /*オプション:ユーザーエージェントを指定する*/
    curl_setopt($cp, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    $json = curl_exec($cp);

    //jsonデータをphpへ変換
    $json_decode = json_decode($json,true);
    
    //サーバのセキュリティレベルによってはこっちでもOK
    /* 
    $json = file_get_contents($data);
    $json_decode = json_decode($json,true);
    //jsonデータ内の『entry』部分を複数取得して、postsに格納
    $posts = $json_decode->items;
    */
    return $json_decode;
}
?>