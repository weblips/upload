<?php
session_start();
require('sys/config.php');
$get = $_SERVER['QUERY_STRING'];
$url='albums/'.$get;
$dest=('albums/'.$get.'/index.php');
$source='sys/index.php';
if(! file_exists($dest)){copy($source,$dest);}
//--здесь проверка, если админ залогинился, то пароль на папки, если установлен, не запрашивается--start
if(file_exists('albums/'.$get.'/pass.php')){include('albums/'.$get.'/pass.php'); $_SESSION[$get]=$key;}
if(! empty($_SESSION[$get])){$select3='3';}
if($_POST['accs']==$_SESSION[$get]){$select2='2';}
if(file_exists('albums/'.$get.'/pass.php') and $_SESSION['ok']==$word){$select1='1';}
$_SESSION['checkup']=$select3.$select2.$select1;
//--здесь проверка, если админ залогинился, то пароль на папки, если установлен, не запрашивается--end
if($_SESSION['checkup']=='3'){
echo
'<!DOCTYPE html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1251"/>
<title>Вход</title>
</head><body>
<center><h2>Для просмотра альбома необходима авторизация</h2>
<div style="width: 30%"><fieldset><form name="form9" method="post" action="view.php?'.$get.'">
<b>введите пароль:</b><br/>
<input type="password" name="accs"><br/>
<input type="submit" name="btn" value="отправить">
</form></fieldset></div><br><a href="index.php">в галерею</a>
</center>
</body></html>';
exit();}
echo '<script>window.location.href = "'.$url.'"</script>';
?>