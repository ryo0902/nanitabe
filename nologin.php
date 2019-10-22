<?php
session_start();
if (isset($_SESSION['user_name']) && isset($_SESSION['id'])){
  header('Location:http://nanitabe.kita-samu.com/home.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>ログインもしくは会員登録が必要です</title>
    <link rel="stylesheet"  href="css/nologin.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  </head>
  <body>
    <div class="wrapper">
    <header>
      <div id="top-menu">
        <h1><img src="title.png" alt="ロゴ"></h1>
      </div>
    </header>
    <!--新規登録-->
    <div id="signup">
      <div class="modal">
        <div class="close">
          <i class="fa fa-2x fa-times"></i>
        </div>
        <div id="signup-form">
          <h2>新規登録</h2>
          <form action="touroku.php" method="post" enctype="multipart/form-data">
            <input class="form-control" name="user_name" type="text" placeholder="ユーザー名" required>
            <input class="form-control" name="mail"type="text" placeholder="メールアドレス" required>
            <input class="form-control" name="pass" type="password" placeholder="パスワード" required>
            <input type="submit" id="submit-btn"value="新規登録">
          </form>
        </div>
      </div>
    </div>
    <!--ログイン-->
    <div id="login">
      <div class="modal">
        <div class="close">
          <i class="fa fa-2x fa-times"></i>
        </div>
        <div id="signup-form">
          <h2>ログイン</h2>
          <form action="home.php" method="post" enctype="multipart/form-data">
            <input class="form-control" name="mail"type="text" placeholder="メールアドレス" required>
            <input class="form-control" name="pass" type="password" placeholder="パスワード" required>
            <input type="submit" id="submit-btn"value="ログイン">
          </form>
        </div>
      </div>
    </div>
    <div class="top-wrapper">
      <div class="container">
        <p>当サイトは会員制です。ログインもしくは会員登録を行ってください。</p>
        <p>登録したくない場合は画面下にある「卵かけご飯のフリー素材」をお楽しみください。</p>
        <div class="btn">新規登録はこちら</div>
        <p id="or">OR</p>
        <div class="btn-login">すでに登録済みの方はこちら</div>
      </div>　　　　　　　　　　　　　　　　　　　　　　　　　　
    </div>
  <div class="bg_tkg"><img src="css/tkg.jpg" alt=""></div>
  <footer>
    <p>&copy;2019 今日何食べる？</p>
  </footer>
</div>
  </body>
  <script src="js/top.js"></script>
</html>
