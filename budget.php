<?php
try {
  session_start();
  $errors = array();
  if (!isset($_SESSION['user_name']) && !isset($_SESSION['id'])) {
    require("php/redirect_nologin.php");
    exit;
    $errors['nosession']="ログインもしくは会員登録をしてください";
  }else{
    if(empty($_GET['max'])&& empty($_GET['min'])) {
      throw new Exception('数値が正しく入力されていません');
    }elseif($_GET['max']<$_GET['min']){
      throw new Exception('上限額が下限額を上回っています。入力しなおしてください。');
    }else{
      $max = (int) $_GET['max'];
      $min = (int) $_GET['min'];
      require("php/pdo_mysql.php");
      $sql = "SELECT * FROM recipes WHERE budget >= $min AND budget <= $max ";
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      require("php/category_name_array.php");
      $dbh = null;
    }
  }
} catch (Exception $e) {
  echo "エラー発生: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "<br>";
  die();
}
 ?>
 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <title>予算：<?php echo $min.'～'.$max ; ?>円のレシピページ</title>
     <link rel="stylesheet" href="css/category.css">
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
   	<input type="button" value="トップページに移動する"onclick="location.href='top.php'">
   <?php else: ?>
         <?php include("header.php"); ?>
         <main>
           <div class="main_side">
         <h2>予算：<?php echo $min.'～'.$max ; ?>円のレシピ一覧</h2>
         <?php include("recipes_container.php"); ?>
       </div>
       <?php include("sidebar.php"); ?>
       </main>
       <?php $dbh = null; ?>
         <?php include("footer.php"); ?>
       </div>
       <?php endif ?>
   </body>
 </html>
