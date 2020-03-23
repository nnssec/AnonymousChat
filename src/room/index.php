<!DOCTYPE html>
<html>
  <head>
    <title>Anonymous Forum</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="stylesheet/style.css">
    <link rel="shortcut icon" href="../img/favicon.jpg">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Noto+Serif+JP&display=swap" rel="stylesheet">
  </head>
  <body>
    <h1>チャット</h1>
    <form method="post" action="index.php">
      名前 <input type="text" name="name"><br>
      メッセージ <input tyep="text" name="message"><br>
      <button name="send" type="submit">送信</button><br>
      チャット履歴
    </form>
    <section>
      <?php
      // DBからデータ(投稿内容)を取得
      $stmt = select();
      foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
      // 投稿内容を表示
        echo $message['time'],"：　",$message['name'],"：",$message['message'];
        echo nl2br("\n");
      }

      // 投稿内容を登録
      if(isset($_POST["send"])) {
        insert();
        // 投稿した内容を表示
        $stmt = select_new();
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
          echo $message['time'],"：　",$message['name'],"：",$message['message'];
          echo nl2br("\n");
        }
      }

      // DB接続
      function connectDB() {
        $dbh = new PDO('mysql:host=localhost;dbname=chat','root','');
        return $dbh;
      }

      // DBから投稿内容を取得
      function select() {
        $dbh = connectDB();
        $sql = "SELECT * FROM message ORDER BY time";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        return $stmt;
      }

      // DBから投稿内容を取得(最新の1件)
      function select_new() {
        $dbh = connectDB();
        $sql = "SELECT * FROM message ORDER BY time desc limit 1";
        $stmt = $dbh->prepare($sql);
        $stmt->execute();
        return $stmt;
      }

      // DBから投稿内容を登録
      function insert() {
        $dbh = connectDB();
        $sql = "INSERT INTO message (name, message, time) VALUES (:name, :message, now())";
        $stmt = $dbh->prepare($sql);
        $params = array(':name'=>$_POST['name'], ':message'=>$_POST['message']);
        $stmt->execute($params);
      }
      ?>
    </section>
  </body>
</html>
