<?php
session_start();
require('sys/config.php');
$get = $_SERVER['QUERY_STRING'];
$url='albums/'.$get;
$dest=('albums/'.$get.'/index.php');
$source='sys/index.php';
if(! file_exists($dest)){copy($source,$dest);}
//--����� ��������, ���� ����� �����������, �� ������ �� �����, ���� ����������, �� �������������--start
if(file_exists('albums/'.$get.'/pass.php')){include('albums/'.$get.'/pass.php'); $_SESSION[$get]=$key;}
if(! empty($_SESSION[$get])){$select3='3';}
if($_POST['accs']==$_SESSION[$get]){$select2='2';}
if(file_exists('albums/'.$get.'/pass.php') and $_SESSION['ok']==$word){$select1='1';}
$_SESSION['checkup']=$select3.$select2.$select1;
//--����� ��������, ���� ����� �����������, �� ������ �� �����, ���� ����������, �� �������������--end
if($_SESSION['checkup']=='3'){
echo
'<!DOCTYPE html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1251"/>
<title>����</title>
</head><body>
<center><h2>��� ��������� ������� ���������� �����������</h2>
<div style="width: 30%"><fieldset><form name="form9" method="post" action="view.php?'.$get.'">
<b>������� ������:</b><br/>
<input type="password" name="accs"><br/>
<input type="submit" name="btn" value="���������">
</form></fieldset></div><br><a href="index.php">� �������</a>
</center>
</body></html>';
exit();}
echo '<script>window.location.href = "'.$url.'"</script>';
?>