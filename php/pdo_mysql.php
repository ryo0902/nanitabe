<?php
$server_user = "データベースのユーザー名";
$server_pass = "データベースのパスワード";
$dbh = new PDO('mysql:host=ホスト名;charset=utf8',$server_user,$server_pass);
$dbh->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 ?>
