<div class="sidebar">
  <div class="category_box">
    <h3 class="sidebar_h3">カテゴリーから探す</h3>
    <ul>
      <?php require("php/category_name_array.php"); ?>
      <?php foreach($category_name as $key=> $value): ?>
      <li>
        <a href='<?php echo "category.php?category=".htmlspecialchars($key,ENT_QUOTES, 'UTF-8'). ""; ?>'>
          <?php echo $value ; ?>
        </a>
      </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="budget_box">
    <h3 class="sidebar_h3">予算から探す</h3>
    <form class="" action="budget.php" method="get">
      <div class="range">
        <input type="range" name="min" min="0" max="9999" value="1"><br>
        <div class="meter">予算が<span>1</span>円～</div>
      </div>
      <div class="range">
        <input type="range" name="max" min="0" max="9999" value="9999">
        <div class="meter"><span>9999</span>円の</div>
      </div>
      <div class="search_button">
        <input type="submit" class="search_submit" value="レシピを検索">
      </div>
    </form>
  </div>

  <div class="difficulty_box">
    <h3 class="sidebar_h3">難易度から探す</h3>
    <form class="" action="difficulty.php" method="get">
      <div class="range">
        <input type="range" name="min" min="0" max="99" value="1">
        <div class="meter">難易度Lv<span>1</span>～</div>
      </div>
      <div class="range">
        <input type="range" name="max" min="0" max="99" value="99">
        <div class="meter">Lv<span>99</span>の</div>
      </div>
      <div class="search_button">
        <input type="submit" class="search_submit" value="レシピを検索">
      </div>
    </form>
  </div>

</div>
