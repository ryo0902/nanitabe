<?php
try {
  session_start();
  $errors = array();
  if (!isset($_SESSION['user_name']) && !isset($_SESSION['id'])) {
    require("php/redirect_nologin.php");
    exit;
    $errors['nosession']="ログインもしくは会員登録をしてください";
  }else{
    if(empty($_GET['id'])) {
      throw new Exception('ID不正');
    }else{
      $id = (int) $_GET['id'];
      require("php/pdo_mysql.php");
      $sql = "SELECT * FROM recipes WHERE id = ?";
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(1, $id, PDO::PARAM_INT);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      $dbh = null;
    }
  }
  require("php/category_name_array.php");
} catch (Exception $e) {
  echo "エラー発生: ";
  die();
}
  ?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/detail.css">
  <title><?php echo  htmlspecialchars($result['recipe_name'],ENT_QUOTES,'UTF-8') ?>のレシピ</title>
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
  <div id="box">
  <h2><?php echo  htmlspecialchars($result['recipe_name'],ENT_QUOTES,'UTF-8') ?></h2>
  <?php if($result['image']==null): ?>
    <img src="img/noimage.PNG" >
  <?php else: ?>
    <img src="<?php echo $result['image']?>" >
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
          <?php if ($result['category']==$key)echo $value; ?>
        <?php endforeach; ?>
      </td>
      <td><?php echo htmlspecialchars($result['budget'],ENT_QUOTES,'UTF-8') ?>円</td>
      <td>
          Lv.<?php echo $result['difficulty']; ?>
        </td>
    </tr>
    </table>
    <h3>作り方</h3>
    <div id="recipe">
      <p><?php echo nl2br(htmlspecialchars($result['howto'],ENT_QUOTES,'UTF-8') ) ?></p>
    </div>
  </div>
</body>
<?php include("footer.php"); ?>
</div>
<?php endif; ?>
</html>
