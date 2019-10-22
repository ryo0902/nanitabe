    <?php
    try{
      require("php/pdo_mysql.php");
      require("php/category_name_array.php");
      session_start();
      $errors = array();
      //セッションなければ以下実行
      if (!isset($_SESSION['user_name']) && !isset($_SESSION['id'])) {
        require("php/redirect_nologin.php");
        exit;
        $errors['nosession']="ログインもしくは会員登録をしてください";
      }else{
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $difficulty = (int) $_POST['difficulty'];
      //料理名をチェック
    if(!isset($_POST['recipe_name']) || !strlen($_POST['recipe_name'])){
      $errors['recipe_name']="名前を入力してください";
    }elseif(mb_strlen($_POST['recipe_name']) > 20){
      //mb_strlin文字数ではなく文字のバイト数でカウント
      $errors['recipe_name']="名前は20文字以内で入力してください";
    }else{
      $recipe_name = $_POST['recipe_name'];
    }
      //カテゴリーチェック
      if($_POST['category']== 0){
        $errors['category']= "カテゴリーを選択してください";
      }else{
        $category = (int) $_POST['category'];
      }
      //予算をチェック
      if(!isset($_POST['budget']) || !strlen($_POST['budget'])){
        $errors['budget']= "予算を入力してください";
      }else{
        $budget=$_POST['budget'];
      }
      //作り方をチェック
      if(!isset($_POST['howto']) || !strlen($_POST['howto'])){
        $errors['howto']= "作り方を入力してください";
      }elseif(strlen($_POST['howto']) > 500){
        $errors['howto']= "名前は500文字以内で入力してください";
      }else{
        $howto = $_POST['howto'];
      }
      //画像ファイルをチェック
      $image_path = "img/";
      $e_code=$_FILES['image']['error'];//エラー内容
      if($e_code == 4){
        $no_image = "ファイル未選択";
      }elseif($e_code!==0){
        $errors['image']="ファイル送信エラーです。";
      }else{
        if(file_exists($image_path.$_FILES['image']['name'])){
          $errors['image']= "同名のファイルがアップロードされています。";
        }else{
        $image=$_FILES['image']['name'];//ファイルの名前
        $image= $image_path.$image;
        $tmp_name=$_FILES["image"]["tmp_name"];//サーバーに保存されたファイル名
        $file_result = @move_uploaded_file( $tmp_name, $image);
        }
      }
    }
  }
  } catch(Exception $e){
    echo "エラー発生";
    die();
  }

    ?>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>登録レシピの確認</title>
    <link rel="stylesheet" href="css/recipe_touroku.css">
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
    <form class="" action="recipe_form.php" method="post">
    <div class="button_wrapper">
      <input type="hidden" name="image" value="<?php echo $image ; ?>">
      <input class="cancel_button" type="submit" value="戻って修正する" >
    </div>
  </form>
 <?php else: ?>
    <?php include("header.php"); ?>
  	<h2 class="h2_kakunin">以下のレシピ内容でよろしいですか？</h2>
    <div id="box">
  <h2><?php echo htmlspecialchars($recipe_name, ENT_QUOTES, 'UTF-8'); ?></h2>
          <?php if($e_code == 4): ?>
    <img src="img/noimage.PNG" >
  <?php else: ?>
        <img src="<?php echo $image;?>">
<?php endif; ?>
<table>
    <tr>
      <th>カテゴリ</th>
      <th>予算</th>
      <th>難易度</th>
    </tr>
    <tr>
      <td>
        <?php foreach ($category_name as $key => $value): ?>
         <?php if ($category==$key)echo $value; ?>
       <?php endforeach; ?>
      </td>
      <td><?php echo nl2br( htmlspecialchars($budget, ENT_QUOTES, 'UTF-8')); ?>円</td>
      <td>
          LEVEL<?php echo $difficulty; ?>
        </td>
    </tr>
    </table>
    <h3>作り方</h3>
    <div id="recipe">
      <p><?php echo nl2br( htmlspecialchars($howto, ENT_QUOTES, 'UTF-8')); ?></p>
    </div>
  </div>
  <form  action="recipe_touroku_kakunin.php" method="post">
  		<input type="hidden" name="recipe_name" value="<?php echo $recipe_name ;?>">
  		<input type="hidden" name="category" value="<?php echo  $category ; ?>">
  		<input type="hidden" name="difficulty" value="<?php echo $difficulty ; ?>">
  		<input type="hidden" name="budget" value="<?php echo $budget ; ?>">
  		<input type="hidden" name="howto" value="<?php echo $howto ; ?>">
      <?php if($e_code == 4): ?>
        <input type="hidden" name="image" value="">
      <?php else: ?>
        <input type="hidden" name="image" value="<?php echo $image ; ?>">
    <?php endif; ?>
    <div class="button_wrapper">
      <input id="ok_button" type="submit" value="登録する">
    </div>
  </form>
  <form class="" action="recipe_form.php" method="post">
  <div class="button_wrapper">
    <input type="hidden" name="image" value="<?php echo $image ; ?>">
    <input class="cancel_button" type="submit" value="戻って修正する" >
  </div>
</form>
  <?php include("footer.php"); ?>
</div>
  <?php endif; ?>
  </body>
</html>
