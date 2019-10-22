<?php
try {
  if (empty($_GET['id'])){
    throw new Exception('ID不正');
  }else{
  $id = (int) $_GET['id'];
  require("php/pdo_mysql.php");
  $sql = "SELECT * FROM recipes WHERE id= $id";
  $stmt = $dbh->query($sql);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  if($result['image']==null){
    $sql = "DELETE FROM recipes WHERE id =$id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
  }else{
    unlink($result['image']);
    $sql = "DELETE FROM recipes WHERE id =$id";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
  }
  $dbh = null;
}
} catch (Exception $e) {
  echo "エラー発生";
  echo "<a href='index.php'>トップページに戻る</a>";
  die();
}
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 <meta charset="utf-8">
 <meta http-equiv="refresh" content=" 2; url=http://nanitabe.kita-samu.com/mypage.php">
 <title>レシピの削除完了</title>
 </head>
 <body>
   <p>レシピの削除しました。</p>
   <p><a href="mypage.php">マイページ</a>に戻ります。</p>
 </body>
 </html>
