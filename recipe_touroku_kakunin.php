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
    $recipe_name = $_POST['recipe_name'];
    $category = $_POST['category'];
    $difficulty = $_POST['difficulty'];
    $budget = $_POST['budget'];
    $howto = $_POST['howto'];
    $image = $_POST['image'];
    $user_id=$_SESSION['id'];
     $sql = "INSERT INTO recipes (recipe_name, category, difficulty,budget, howto, image,user_id) VALUES (?, ?, ?, ?, ?,?,?)";
     $stmt = $dbh->prepare($sql);
     $stmt->bindValue(1, $recipe_name, PDO::PARAM_STR);
     $stmt->bindValue(2, $category, PDO::PARAM_INT);
     $stmt->bindValue(3, $difficulty, PDO::PARAM_INT);
     $stmt->bindValue(4, $budget, PDO::PARAM_INT);
     $stmt->bindValue(5, $howto, PDO::PARAM_STR);
     $stmt->bindValue(6, $image, PDO::PARAM_STR);
     $stmt->bindValue(7, $user_id, PDO::PARAM_INT);
     $stmt->execute();
     $result = $stmt->fetch(PDO::FETCH_ASSOC);
     $dbh = null;
   }
} catch(Exception $e){
  echo "エラー発生：" ;//. htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') ."<br>";
  die();
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>レシピ登録完了！ありがとうございます！</title>
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
          <h2>レシピ登録が完了しました</h2>
          <p>レシピ登録ありがとうございます!</p>
          <a  class="button-wrapper" href="http://nanitabe.kita-samu.com/">トップページに移動</a>
          </div>
  <?php include("footer.php"); ?>
</div>
 <?php endif; ?>
  </body>
</html>
