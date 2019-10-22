<footer>
      <ul class="footer_nav">
           <li><a href="home.php">HOME</a></li>
           <li><a href="recipe_form.php">レシピ登録</a></li>
           <li><a href="mypage.php">マイページ</a></li>
           <li><a href="logout.php">ログアウト</a></li>
        </ul>
  <p>&copy;2019 今日何食べる？</p>
</footer>
<script>
<!--サイドバーのメモリ-->
　var elem = document.getElementsByClassName('range');
　 var rangeValue = function (elem, target) {
　 　　return function(evt){
　　　 　　target.innerHTML = elem.value;
　　　}
　 }
　 for(var i = 0, max = elem.length; i < max; i++){
　　　bar = elem[i].getElementsByTagName('input')[0];
　　　target = elem[i].getElementsByTagName('span')[0];
　　　 bar.addEventListener('input', rangeValue(bar, target));
　 }
</script>
