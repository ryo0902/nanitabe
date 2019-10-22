<?php
  session_start();
  $errors = array();
  require("php/category_name_array.php");
  //セッションなければ以下実行
  if (!isset($_SESSION['user_name']) && !isset($_SESSION['id'])) {
    require("php/redirect_nologin.php");
    exit;
    $errors['nosession']="ログインもしくは会員登録をしてください";
  }else{
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      //画像ファイルを削除
      unlink($_POST['image']);
    }
  }
 ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>入力フォーム</title>
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
    <h2>レシピを登録する</h2>
    <div id="recipe_box">

    <form action="recipe_touroku.php" method="post" enctype="multipart/form-data">
    <div class="recipe_form_item"><p>料理名</p><p class="hissu">必須</p></div>
      <input type="text" name="recipe_name" required><br>
    <div class="recipe_form_item"><p>カテゴリ</p><p class="hissu">必須</p></div>
      <select name="category">
                <option value="">選択してください</option>
                <?php foreach ($category_name as $key => $value): ?>
               <option value="<?php echo $key ; ?>"><?php echo $value; ?></option>
                <?php endforeach; ?>
      </select><br>
      <div class="recipe_form_item"><p>難易度(LEVEL)</p><p class="hissu">必須</p></div>
      <input type="number" min="1" max="99" name="difficulty" ><br>
      <div class="recipe_form_item"><p>予算</p><p class="hissu">必須</p></div>
      <input type="number" min="1" max="9999" name="budget" >円<br>
      <div class="recipe_form_item"><p>作り方</p><p class="hissu">必須</p></div>
      <textarea name="howto" rows="4" cols="40" maxlength="500"></textarea><br>
      <div class="recipe_form_item"><p>写真</p><p class="ninni">任意</p></div>
      <input type="file" accept="image/jpeg, image/gif, image/png" name="image"><br>
      <div id="form_button">
        <input id="submit_button" type="submit" value="レシピを登録">
      </div>
    </form>
  </div>
  <?php include("footer.php"); ?>
</div>
  <?php endif; ?>
  </body>
</html>
