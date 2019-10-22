<?php
try{
  require("php/pdo_mysql.php");
  $errors = array();
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
      //名前をチェック
      $name = null;
       if(!isset($_POST['user_name']) || !strlen($_POST['user_name'])){
         $errors['user_name'] = '名前を入力してください';
       }elseif(strlen($_POST['user_name']) > 20){
         $errors['user_name'] = '名前は20文字以内で入力してください';
       }else {
         //重複されていない
         $stmt = $dbh->query("SELECT * FROM user_data");
         while($post = $stmt -> fetch(PDO::FETCH_ASSOC)){
           if($_POST['user_name']===$post['user_name']){
             $errors["user_name"]="同じ名前が既に存在します。";
             break;
           }
         }
         $user_name=$_POST['user_name'];
       }
    //メールアドレスをチェック
    if(!preg_match('/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/iD', $_POST['mail'])){
      $errors['mail'] = 'メールアドレスが正しくありません';
    }else{
      $mail=$_POST['mail'];
    }

   //パスワードをチェック
  	$pass=null;
  	if(!isset($_POST['pass'])|| !strlen($_POST['pass'])){
  		$errors['pass'] = 'パスワードを入力してください';
  	}elseif(strlen($_POST['pass']) > 12){
  		$errors['pass'] = 'パスワードは12文字以内で入力してください';
  	}else {
  		$pass = $_POST['pass'];
  	}

    if(count($errors) === 0){
      $sql = "INSERT INTO user_data (user_name,mail,pass) VALUES (?, ?, ?)";
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(1, $user_name, PDO::PARAM_STR);
      $stmt->bindValue(2, $mail, PDO::PARAM_STR);
      $stmt->bindValue(3, $pass, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    $dbh = null;
  }else{
    require("php/redirect_nologin.php");
		exit;
  }
} catch(Exception $e){
  echo "エラー発生：";//" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') ."<br>"
  die();
}
 ?>
 <!DOCTYPE html>
 <html lang="ja">
   <head>
     <meta charset="utf-8">
     <link rel="stylesheet" href="css/touroku.css">
     <title>会員登録完了！</title>
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
    <input type="button" value="戻って修正する"onclick="history.back() ">
  <?php else: ?>
     <?php include("header.php"); ?>
     <div id="touroku-box">
       <h2>会員登録が完了しました</h2>
       <p>会員登録ありがとうございます。さっそくトップページに移動して、みんなのレシピを見たり、あなたのレシピを投稿したりしましょう。</p>
       <form  action="home.php" method="post">
         <input name="mail"type="hidden"  value="<?php echo $mail ;?>">
         <input name="pass" type="hidden"  value="<?php echo $pass ;?>">
        <input type="submit" id="button-wrapper"value="トップページへ移動">
       </form>
       </div>
    </div>
     <?php include("footer.php"); ?>
   </div>
   <?php endif; ?>
   </body>
 </html>
