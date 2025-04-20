<?php

$message_array = [];

// DB接続
$user = "root";
$pass = "*****";

try{
$dbh = new PDO('mysql:host=localhost;dbname=php_chatt', $user, $pass);
} catch(PDOException $e){
  echo $e->getMessage();
}


// DBへ保存 
if(!empty($_POST["button"])){

  // SQL文の発行
  $stmt = $dbh->prepare("INSERT INTO phpchat (username , message) VALUES (:username, :message)");
  // 値のバインド
  $stmt->bindParam(':username',$_POST["username"]);
  $stmt->bindParam(':message',$_POST["message"]);
  // 実行
  $stmt->execute();

  header("Location: " . $_SERVER['PHP_SELF']);
  exit;

}

// DBからデータの取得
  // SQL文
  $sql = "SELECT id, username, message FROM phpchat"; 
  // SQL文を実行し$message_array代入
  $message_array = $dbh->query($sql);

// DBを閉じる
$dbh = null;

?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP チャット</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="chat-box">
    <h2>PHPチャット</h2>

    <!-- メッセージ投稿フォーム -->
    <form class="form" method="POST">
      <input type="text" name="username" placeholder="名前" required>
      <input type="text" name="message" placeholder="メッセージを入力" required>
      <input type="submit" name="button" value="送信">
    </form>


    <!-- メッセージ表示エリア -->
    <?php foreach( $message_array as $message): ?>

      <div class="messages" id="chat-messages">
        <div class="message">
        <span><?php echo $message['username']; ?>:</span> 
        <?php echo $message['message']; ?>
        </div>
        <!-- ← ここに新しいメッセージが追加されていく -->
      </div>

    <?php endforeach; ?>
  </div>
</body>
</html>
