<?php
// セッション開始
session_start();
// セッション変数を全て削除
$_SESSION = array();
// セッションクッキーを削除
if (isset($_COOKIE["PHPSESSID"])) {
  setcookie("PHPSESSID", '', time() - 1800, '/');
}
// セッションの登録データを削除
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="refresh" content=" 2; url=http://nanitabe.kita-samu.com">
<title>ログアウト</title>
</head>
<body>
  <p>ログアウトが完了しました。</p>
  <p>トップページに移動します。</p>
</body>
</html>
