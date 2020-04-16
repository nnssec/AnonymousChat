<!DOCTYPE html>
<html>
  <head>
    <title>Anonymous Forum</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="stylesheet/style.css">
    <link rel="shortcut icon" href="../img/Anonymous Laughing Man.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="../index.php">
        <img src="../img/Anonymous Laughing Man.png" width="30" height="30" style="margin-right:10px;">Anonymous Forum
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link active" href="../index.php">ホーム <span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="#">チャットルーム</a>
          <a class="nav-item nav-link" href="#">記事一覧</a>
          <?php if (isset($_SESSION["NAME"])) { echo '<a class="nav-item nav-link" href="setting.php">アカウントメニュー</a>';}?>
          <a class="nav-item nav-link" href="<?php session_start(); if (!isset($_SESSION["NAME"])) { echo "login.php";} else { echo "logout.php";} ?>"><?php if (!isset($_SESSION["NAME"])) { echo "ログイン";} else { echo "ログアウト";} ?></a>
        </div>
      </div>
    </nav>
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
