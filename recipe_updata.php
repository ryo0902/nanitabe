<?php
try{
  require("php/pdo_mysql.php");
  session_start();
  $errors = array();
  //セッションなければ以下実行
  if (!isset($_SESSION['user_name']) && !isset($_SESSION['id'])) {
    require("php/redirect_nologin.php");
    exit;
    $errors['nosession']="ログインもしくは会員登録をしてください";
  }else{
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $recipe_name = $_POST['recipe_name'];
      $category = (int) $_POST['category'];
      $difficulty = (int) $_POST['difficulty'];
      $howto = $_POST['howto'];
      $budget = (int) $_POST['budget'];
      $image = $_POST['image'];
      $id = (int) $_POST['id'];
      $sql ="UPDATE recipes SET recipe_name = ?, category = ?, difficulty = ?, budget = ?, howto = ? , image = ? WHERE id = $id";
      $stmt = $dbh->prepare($sql);
       $stmt->bindValue(1, $recipe_name, PDO::PARAM_STR);
       $stmt->bindValue(2, $category, PDO::PARAM_INT);
       $stmt->bindValue(3, $difficulty, PDO::PARAM_INT);
       $stmt->bindValue(4, $budget, PDO::PARAM_INT);
       $stmt->bindValue(5, $howto, PDO::PARAM_STR);
       $stmt->bindValue(6, $image, PDO::PARAM_STR);
       $stmt->execute();
    //ここに格納された変更前の画像を削除する処理を書く
       $dbh = null;
     }
}

} catch(Exception $e){
  echo "エラー発生：";// . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') ."<br>";
  die();
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>レシピの変更が完了しました</title>
    <link rel="stylesheet" href="css/touroku.css">
  </head>
  <body>
    <div class="wrapper">
    <?php if(count($errors)): ?>
   <ul class="error_list">
   <?php foreach($errors as $error): ?>
   <li>
     <?php echo htmlspecialchars($error,ENT_QUOTES,"UTF-8"); ?>
   </li>
   <?php endforeach; ?>
   </ul>
 <?php else: ?>
   <?php include("header.php"); ?>
        <div id="touroku-box">
          <h2>レシピの変更が完了しました</h2>
          <p>レシピの変更ありがとうございます!</p>
          <a  class="button-wrapper" href="http://nanitabe.kita-samu.com/mypage.php">マイページに戻る</a>
        </div>
  <?php include("footer.php"); ?>
</div>
 <?php endif; ?>
  </body>
</html>
