<?php
session_start();
require_once('../sys/config.php');
if(isset($_GET['action']) and $_SESSION['ok']==$word){header("location: edit.php?options");}
echo
'<!DOCTYPE html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1251"/>
<title>Вход</title>
</head><body>
<center><h2>Вход администратора</h2>
<div style="width: 30%"><fieldset><form name="form2" method="post" action="">
<b>введите пароль:</b><br/>
<input type="password" name="code"><br/>
<input type="submit" value="отправить">
</form></fieldset></div><br><a href="../">в галерею</a>
</center>
</body></html>';
if(($_POST['code'])==$login)
{$_SESSION['ok']=$word;
$url='../';
echo "<html><head><meta http-equiv=\"refresh\" content=\"0;url=$url\"></meta></head></html>"; exit();}
?>