<!--ここからカテゴリー予算、難易度の個別ページで使用しているbox-->
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
<!--ここまで-->
