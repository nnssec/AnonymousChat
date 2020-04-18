<!DOCTYPE html>
<html>
  <head>
    <title>【誰でも参加可能】匿名ルームⅠ - Anonymous Forum</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="stylesheet/style.css">
    <link rel="shortcut icon" href="../img/Anonymous Laughing Man.png">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </head>
  <body>
    <script>
    </script>
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
          <a class="nav-item nav-link" href="#">お問い合わせ</a>
          <?php if (isset($_SESSION["NAME"])) { echo '<a class="nav-item nav-link" href="setting.php">アカウントメニュー</a>';}?>
          <a class="nav-item nav-link" href="<?php session_start(); if (!isset($_SESSION["NAME"])) { echo "login.php";} else { echo "logout.php";} ?>"><?php if (!isset($_SESSION["NAME"])) { echo "ログイン";} else { echo "ログアウト";} ?></a>
        </div>
      </div>
    </nav>
    <h4 class="mt-3 text-center">【誰でも参加可能】匿名ルームⅠ</h4>
    <div class="container mt-3">
      <div class="card">
        <div class="card-header">
          チャット履歴
          <a href="./chat.php"><img src="img/reload.svg" class="float-right"></a>
        </div>
        <div class="card-body overflow-auto js-auto-scroll" style="height:400px;">
          <?php
          // DBからデータ(投稿内容)を取得
          $stmt = select();
          foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
          // 投稿内容を表示
          echo $message['name'],"：",$message['message']," (",$message['time'],")";
          echo nl2br("\n");
          }

          // 投稿内容を登録
          if(isset($_POST["send"])) {
            insert();
            // 投稿した内容を表示
            $stmt = select_new();
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $message) {
              echo $message['name'],"：",$message['message']," (",$message['time'],")";
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
        </div>
      </div>
    </div>
    <div class="container mt-3">
      <?php
      if(isset($_GET["sent"])) {
        if($_GET["sent"] == true) {
          echo '
          <div class="alert alert-primary" role="alert">
            メッセージが送信されました
          </div>';
        }
      }
      ?>
      <div class="alert alert-danger" role="alert">
        <span class="font-weight-bold">注意</span><br>
        公序良俗に反する書き込みをしないよう注意してください！
      </div>
      <form method="post" action="chat.php?room=<?php if(!empty($_GET["room"])) {echo $_GET["room"];}?>&sent=true">
        <div class="form-group form-name">
          <label for="exampleFormControlInput1">名前</label>
          <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Anonymous">
        </div>
        <div class="form-group">
          <label for="exampleFormControlTextarea1">本文</label>
          <textarea tyep="text" name="message" class="form-control" id="exampleFormControlTextarea1" rows="4"></textarea>
        </div>
        <button name="send" type="submit" class="btn btn-primary float-right mb-5" onclick="window.location.reload();">送信</button>
      </form>
    </div>
  </body>
</html>
