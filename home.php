<?php
try{
	require("php/pdo_mysql.php");
	session_start();
	$errors = array();
	//セッションなければ以下実行
	if (!isset($_SESSION['user_name']) && !isset($_SESSION['id'])) {
		  if($_SERVER['REQUEST_METHOD'] === 'POST'){
	      $stmt = $dbh->query("SELECT * FROM user_data");
			while($post = $stmt -> fetch(PDO::FETCH_ASSOC)){
				if($_POST['mail']===$post['mail'] && $_POST['pass']===$post['pass']){
    			$_SESSION['user_name']=$post['user_name'];
    			$_SESSION['id']= $post['id'];
          $sql = "SELECT * FROM recipes";
          $stmt = $dbh->query($sql);
          $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
          break;
				}elseif(!$_POST['mail']===$post['mail'] || !$_POST['pass']===$post['pass']){
				  $errors['pass']='入力情報が異なります。';
					break;
				}
			}
		}else{
			require("php/redirect_nologin.php");
			exit;
		$errors['nopost']="ログイン情報を入力してください";
		}
	}else{
	  $sql = "SELECT DISTINCT * FROM recipes";
	  $stmt = $dbh->query($sql);
	  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	require("php/category_name_array.php");
}catch (Expeption $e){
  echo "エラー発生:<br>";//.htmlspecialchars($e->getMessage(),  ENT_QUOTES,'UTF-8')."
    die();
}
 ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>レシピの一覧</title>
    <link rel="stylesheet" href="css/home.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
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
  	<input type="button" value="トップページに移動する"onclick="location.href='index.php'">
  <?php else: ?>
        <?php include("header.php"); ?>
				<main>
					<div class="main_side">
				<h2>レシピの一覧</h2>
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
            </div>
          </div>
        <?php endforeach; ?>
        </div>
				<h3>特集！：お金も料理スキルも無い人向けのレシピ</h3>
				<p>予算も難易度も低いレシピを集めました()</p>
				<div class="recipes-container">
				<?php foreach ($result as $row):?>
					<?php if($row['budget']<200 && $row['difficulty']<10):?>
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
						</div>
					</div>
				<?php endif; ?>
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
