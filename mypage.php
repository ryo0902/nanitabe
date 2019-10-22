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
  $sql = "SELECT * FROM recipes WHERE user_id= ".$_SESSION['id']."";
//↑参考ページ（https://teratail.com/questions/7884）
  $stmt = $dbh->query($sql);
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
  require("php/category_name_array.php");
}

  $dbh = null;
}catch (Expeption $e){
  echo "エラー発生:<br>";//.htmlspecialchars($e->getMessage(),  ENT_QUOTES,'UTF-8')."<br>";
    die();
}
 ?>
 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <title><?php echo $_SESSION['user_name']."さんのページ"  ?></title>
     <link rel="stylesheet" href="css/mypage.css">
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
         <h2><?php echo $_SESSION['user_name']."さんのレシピ一覧"  ?></h2>
         <div class="recipes-container">
         <?php foreach ($result as $row):?>
           <div class="box-container">
             <div class="recipes-box">
               <h3><?php echo htmlspecialchars($row['recipe_name'],ENT_QUOTES,'UTF-8');?></h3>
               <?php if($row['image']==null): ?>
                 <img src="img/noimage.PNG" >
               <?php else: ?>
                 <img src="<?php echo $row['image'];?>" >
             <?php endif; ?>
                 <p>
                  <?php foreach ($category_name as $key => $value): ?>
                    <?php if ($row['category']==$key)echo $value; ?>
                  <?php endforeach; ?>
                </p>
                 <div class="recipes-wrapper">
                   <p>
                     <?php echo htmlspecialchars($row['budget'],ENT_QUOTES,'UTF-8') ?>円
                   </p>
                   <p>
                     Lv.<?php echo $row['difficulty']; ?>
                   </p>
                 </div>
               <div class="recpis-botton">
                 <button type=“button” onclick="location.href='<?php echo "detail.php?id=".htmlspecialchars($row['id'],ENT_QUOTES, 'UTF-8'). ""; ?>'">レシピを見る</button>
               </div>
               <div class="edit">
                 <span> <a href="recipe_updata_form.php?id=<?php echo htmlspecialchars($row['id'],ENT_QUOTES, 'UTF-8') ?>">編集</a></span>
                 <span><a href="delete.php?id=<?php echo htmlspecialchars($row['id'],ENT_QUOTES, 'UTF-8') ?>">削除</a></span>
               </div>
             </div>
           </div>
         <?php endforeach; ?>
         </div>
       </div>
       <?php include("sidebar.php"); ?>
     </main>
     <?php $dbh = null; ?>
         <?php include("footer.php"); ?>
       </div>
       <?php endif ?>
   </body>
 </html>
