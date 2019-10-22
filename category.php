<?php
try {
  session_start();
  $errors = array();
  if (!isset($_SESSION['user_name']) && !isset($_SESSION['id'])) {
    require("php/redirect_nologin.php");
    exit;
    $errors['nosession']="ログインもしくは会員登録をしてください";
  }else{
    if(empty($_GET['category'])) {
      throw new Exception('category不正');
    }else{
      $category = (int) $_GET['category'];
      require("php/pdo_mysql.php");
      $sql = "SELECT * FROM recipes WHERE category = ".$category."";
      $stmt = $dbh->prepare($sql);
      $stmt->execute();
      $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
      require("php/category_name_array.php");
      $dbh = null;
    }
  }
} catch (Exception $e) {
  echo "エラー発生" ;
  die();
}
 ?>
 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <title>
       <?php foreach ($category_name as $key => $value): ?>
        <?php if ($category==$key)echo $value; ?>
      <?php endforeach; ?>
       のレシピページ
     </title>
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
         <h2>
           <?php foreach ($category_name as $key => $value): ?>
            <?php if ($category==$key)echo $value; ?>
          <?php endforeach; ?>
          のレシピ一覧
         </h2>
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
