<?php
session_start();
require_once('../sys/config.php');
if(isset($_GET['action']) and $_SESSION['ok']==$word){header("location: edit.php?options");}
echo
'<!DOCTYPE html>
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1251"/>
<title>����</title>
</head><body>
<center><h2>���� ��������������</h2>
<div style="width: 30%"><fieldset><form name="form2" method="post" action="">
<b>������� ������:</b><br/>
<input type="password" name="code"><br/>
<input type="submit" value="���������">
</form></fieldset></div><br><a href="../">� �������</a>
</center>
</body></html>';
if(($_POST['code'])==$login)
{$_SESSION['ok']=$word;
$url='../';
echo "<html><head><meta http-equiv=\"refresh\" content=\"0;url=$url\"></meta></head></html>"; exit();}
?>