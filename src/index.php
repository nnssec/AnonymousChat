<?php
?>

<html>
  <head>
    <title>Anonymous Forum</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,user-scalable=no">
    <link rel="stylesheet" type="text/css" href="stylesheet/style.css">
    <link rel="shortcut icon" href="img/Anonymous Laughing Man.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </head>
  <body>
    <nav class="navbar navbar-dark bg-dark">
      <a class="navbar-brand" href="./index.php">
        <img src="img/Anonymous Laughing Man.png" width="30" height="30" style="margin-right:10px;">Anonymous Forum
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-item nav-link active" href="./index.php">ホーム <span class="sr-only">(current)</span></a>
          <a class="nav-item nav-link" href="#">チャットルーム</a>
          <a class="nav-item nav-link" href="#">記事一覧</a>
          <a class="nav-item nav-link" href="#">お問い合わせ</a>
          <?php if (isset($_SESSION["NAME"])) { echo '<a class="nav-item nav-link" href="setting.php">アカウントメニュー</a>';}?>
          <a class="nav-item nav-link" href="<?php session_start(); if (!isset($_SESSION["NAME"])) { echo "login.php";} else { echo "logout.php";} ?>"><?php if (!isset($_SESSION["NAME"])) { echo "ログイン";} else { echo "ログアウト";} ?></a>
        </div>
      </div>
    </nav>
    <div class="container mt-3">
      <div class="row">
        <div class="col-lg-4">
          <div class="border rounded-lg bg-light mb-3">
            <h5 class="text-center m-3 font-weight-bold">チャットルーム</h5>
            <ul>
              <li><a href="room/chat.php?room=1">【誰でも参加可能】匿名ルームⅠ</a></li>
              <li>【誰でも参加可能】匿名ルームⅡ</li>
              <li>【誰でも参加可能】匿名ルームⅢ</li>
              <li>【レート1000over】ルームⅠ</li>
              <li>【レート1000over】ルームⅡ</li>
              <li>【レート1500over】ルームⅠ</li>
              <li>【レート1500over】ルームⅡ</li>
              <li>【レート2000over】ルームⅠ</li>
            </ul>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="border rounded-lg bg-light">
            <h5 class="text-center m-3 font-weight-bold">読まれている記事</h5>
          <div>
        </div>
      </div>
    </div>
  </body>
</html>
