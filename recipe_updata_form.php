<?php
try{
  if (empty($_GET['id'])) throw new Exception('ID不正');
    session_start();
    $errors = array();
    //セッションなければ以下実行
    if (!isset($_SESSION['user_name']) && !isset($_SESSION['id'])) {
      require("php/redirect_nologin.php");
      exit;
      $errors['nosession']="ログインもしくは会員登録をしてください";
    }else{
      if($_SERVER['REQUEST_METHOD'] === 'POST'){
        unlink($_POST['image']);
        $id = (int) $_GET['id'];
        require("php/pdo_mysql.php");
        $sql = "SELECT * FROM recipes WHERE id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbh = null;
      }else{
        $id = (int) $_GET['id'];
        require("php/pdo_mysql.php");
        $dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT * FROM recipes WHERE id = ?";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $dbh = null;
        }
      }
      require("php/category_name_array.php");
} catch(Exception $e){
  echo "エラー発生";
  die();
}
 ?>
 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <title>レシピ変更フォーム</title>
     <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
     <link rel="stylesheet" href="css/recipe_form.css">
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
     <h2>レシピの登録内容を変更する</h2>
     <div id="recipe_box">
     <form action="recipe_updata_kakunin.php" method="post" enctype="multipart/form-data">
     <div class="recipe_form_item"><p>料理名</p><p class="hissu">必須</p></div>
       <input type="text" name="recipe_name" value="<?php echo htmlspecialchars($result['recipe_name'], ENT_QUOTES,'UTF-8'); ?>"><br>
     <div class="recipe_form_item"><p>カテゴリ</p><p class="hissu">必須</p></div>
       <select name="category">
         <?php foreach ($category_name as $key => $value): ?>
          <?php if ($result['category']==$key): ?>
            <option value="<?php echo $key ;?>" selected><?php echo $value ; ?></option>
          <?php endif; ?>
        <?php endforeach; ?>
       </select><br>
       <div class="recipe_form_item"><p>難易度(LEVEL)</p><p class="hissu">必須</p></div>
       <input type="number" min="1" max="99" name="difficulty" value="<?php echo htmlspecialchars($result['difficulty'])?>"><br>
       <div class="recipe_form_item"><p>予算</p><p class="hissu">必須</p></div>
       <input type="number" min="1" max="9999" name="budget"  value="<?php echo htmlspecialchars($result['budget'])?>">円<br>
       <div class="recipe_form_item"><p>作り方</p><p class="hissu">必須</p></div>
       <textarea name="howto" rows="4" cols="40" maxlength="500"><?php echo htmlspecialchars($result['howto'], ENT_QUOTES, 'UTF-8'); ?></textarea><br>
       <div class="recipe_form_item"><p>写真</p><p class="ninni">任意</p></div>
       <input type="file" accept="image/jpeg, image/gif, image/png" name="image"><br>
       <input type="hidden" name="id" value="<?php echo $id ?>">
       <div id="form_button">
         <input id="submit_button" type="submit" value="レシピの変更内容を確認する">
       </div>
     </form>
   </div>
   <?php include("footer.php"); ?>
</div>
   <?php endif; ?>
   </body>
 </html>
