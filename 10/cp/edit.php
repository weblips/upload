<?php
session_start();
error_reporting(0);
$c=$_SERVER['HTTP_REFERER'];
$s=$_SERVER['HTTP_HOST'];
if(strstr($c,$s)==false)
{die('Page not found!');}
if ($c=='')
{die('Page not found!');}

require('../sys/config.php');
if($_SESSION['ok']!=$word){die('Access denied!');}

function rus2translit($string) {
$converter = array(
' ' => '_', '+' => '_', '@' => '_', '&' => '_',
'�' => 'a',   '�' => 'b',   '�' => 'v',
'�' => 'g',   '�' => 'd',   '�' => 'e',
'�' => 'e',   '�' => 'zh',  '�' => 'z',
'�' => 'i',   '�' => 'y',   '�' => 'k',
'�' => 'l',   '�' => 'm',   '�' => 'n',
'�' => 'o',   '�' => 'p',   '�' => 'r',
'�' => 's',   '�' => 't',   '�' => 'u',
'�' => 'f',   '�' => 'h',   '�' => 'c',
'�' => 'ch',  '�' => 'sh',  '�' => 'sch',
'�' => '_',  '�' => 'y',   '�' => '_',
'�' => 'e',   '�' => 'yu',  '�' => 'ya',
'�' => 'A',   '�' => 'B',   '�' => 'V',
'�' => 'G',   '�' => 'D',   '�' => 'E',
'�' => 'E',   '�' => 'Zh',  '�' => 'Z',
'�' => 'I',   '�' => 'Y',   '�' => 'K',
'�' => 'L',   '�' => 'M',   '�' => 'N',
'�' => 'O',   '�' => 'P',   '�' => 'R',
'�' => 'S',   '�' => 'T',   '�' => 'U',
'�' => 'F',   '�' => 'H',   '�' => 'C',
'�' => 'Ch',  '�' => 'Sh',  '�' => 'Sch',
'�' => '_',  '�' => 'Y',   '�' => '_',
'�' => 'E',   '�' => 'Yu',  '�' => 'Ya',);
return strtr($string, $converter);
}

function delTree($dir) { 
$files = glob($dir . '*',GLOB_MARK); 
foreach($files as $file){ 
if( substr($file, -1) == '/' ) 
delTree($file); 
else 
unlink( $file );} 
if (is_dir($dir)) rmdir($dir);} 

include_once('body.inc');

//-------�������� ��������---start
if(isset($_GET['picfolder']) and isset($_GET['del_img'])){echo '<a href="edit.php?erasepic='.$_GET['del_img'].'&erase_from='.$_GET['picfolder'].'" OnClick="return confirm(\'����������� ����� �������,����������?\');"> ������� �����������<font color="red"><b> '.$_GET['del_img'].'</b></font></a>';
echo '<br><br><br><a href="index.php?action=enter">������������</a>';}
if(isset($_GET['erase_from']) and isset($_GET['erasepic'])){$delpath='../albums/'.$_GET['erase_from'].'/'.$_GET['erasepic'];
$url='../albums/'.$_GET['erase_from'];
if(unlink($delpath))
{echo '����������� <font color="red"><b>'.$_GET['erasepic'].'</b></font> �������!';
echo '<script>window.location.href = "'.$url.'"</script>';}
else
{echo '<font color="red"><b>������: �� ������� ������� �����������!</b></font>';
echo '<script>window.location.href = "'.$url.'"</script>';}}
//-------�������� ��������---end

//-------�������������� ��������--start
if(isset($_GET['picfolder']) and isset($_GET['ren_img'])){$ren_old=pathinfo($_GET['ren_img'],PATHINFO_FILENAME);
$ext=pathinfo($_GET['ren_img'], PATHINFO_EXTENSION);
echo '������� ����� ��� ��� ����� <font color="red"><b>'.$_GET['ren_img'].'</b></font><br>';
echo '<form name="f4" method="get" action="edit.php">
<input type="text" name="ren_to" value="'.$ren_old.'">
<input type="hidden" name="old_img_name" value="'.$_GET['ren_img'].'">
<input type="hidden" name="ext" value=".'.$ext.'">
<input type="hidden" name="in_folder" value="'.$_GET['picfolder'].'">
<a href="javascript: document.f4.submit ()">�������������</a>
</form>';
echo '<br><br><br><a href="index.php?action=enter">������������</a>';}
if(isset($_GET['in_folder']) and isset($_GET['old_img_name']) and isset($_GET['ren_to']) and isset($_GET['ext'])){$oldpic='../albums/'.$_GET['in_folder'].'/'.$_GET['old_img_name'];$_GET['ren_to']=trim($_GET['ren_to']);
$_GET['ren_to']=rus2translit($_GET['ren_to']);
$newpic='../albums/'.$_GET['in_folder'].'/'.$_GET['ren_to'].$_GET['ext'];
$url='../albums/'.$_GET['in_folder'];
if(rename($oldpic,$newpic))
{echo '����������� �������������!';
echo '<script>window.location.href = "'.$url.'"</script>';}
else
{echo '������: �� ������� ������������� �����������!';
echo '<script>window.location.href = "'.$url.'"</script>';}}

//-------�������������� ��������--end


//-------�������� �����---start
if(isset($_GET['deldir'])){echo '<center><a href="edit.php?erasedir='.$_GET['deldir'].'" OnClick="return confirm(\'����� ����� �������,����������?\');">������� ����� '.$_GET['deldir'].'</a><br><br><br><a href="index.php?action=enter">������������</a></center>';}
if(isset($_GET['erasedir'])){$ftd='../albums/'.$_GET['erasedir'].'/';
delTree($ftd);
echo'<center><font color="red">����� '.$_GET['erasedir'].' �������!</font></center>';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}
//-------�������� �����---end

//-------�������������� �����--start
if(isset($_GET['rendir'])){echo '������� ����� ��� ��� ����� <font color="red"><b>'.$_GET['rendir'].'</b></font><br>';
echo '<form name="f3" method="get" action="edit.php">
<input type="text" name="newname" value="'.$_GET['rendir'].'">
<input type="hidden" name="oldname" value="'.$_GET['rendir'].'">
<a href="javascript: document.f3.submit ()">�������������</a>
</form>';
echo '<br><br><br><a href="index.php?action=enter">������������</a>';}
if(isset($_GET['oldname']) and isset($_GET['newname'])){$old='../albums/'.$_GET['oldname'];
$_GET['newname']=trim($_GET['newname']);
$_GET['newname']=rus2translit($_GET['newname']);
$new='../albums/'.$_GET['newname'];
if(rename($old,$new))
{echo '����� <font color="red"><b>'.$_GET['oldname'].'</b></font> �������������!';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}
else
{echo '<font color="red"><b>������: �� ������� ������������� �����!</b></font>';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}}
//-------�������������� �����--end

//-------��������� ������ �� �����---start
if(isset($_GET['lockdir'])){echo '�� ����������� ������ ������ ��� ����� <font color="red"><b>'.$_GET['lockdir'].'</b></font><br>';
echo '<form name="f4" method="get" action="edit.php">
<input type="text" name="pwd">
<input type="hidden" name="foldername" value="'.$_GET['lockdir'].'">
<a href="javascript: document.f4.submit ()">������ ������</a>
</form>';
echo '<br><br><br><a href="index.php?action=enter">������������</a>';}

//--------------���� ������ ����������, ���������� ������ ��� ��������--start
$foundpwp='../albums/'.$_GET['lockdir'].'/pass.php';
;@include($foundpwp);
if(file_exists($foundpwp)){echo '<br>����� <font color="red"><b>'.$_GET['lockdir'].'</b></font> ������� �������: [ <i><b><font color="red">'.$key.' </font></b></i>] ����� ������?<br>';
echo '<a href="edit.php?unlock='.$_GET['lockdir'].'">������� ������</a>';
echo '<p><font color="red">��������: </font>������ ����� ����� ��� �������������, � ������ �������������� 
���������,<br>����� ��������� �������� � ����!</p>';
echo '<a href="index.php?action=enter">������������</a>';}

//--------------���� ������ ����������, ���������� ������ ��� ��������--end


//-------������ ������ �� � ����---start
if(isset($_GET['foldername']) and isset($_GET['pwd'])){$_GET['pwd']=trim($_GET['pwd']);
$newpass=fopen('../albums/'.$_GET['foldername'].'/pass.php',"w");
$text='<?php $key="'.$_GET['pwd'].'"; ?>';
fwrite($newpass,$text);
fclose($newpass);
echo '��� ����� <font color="red"><b>'.$_GET['foldername'].'</b></font> ��� ���������� ������ <font color="red"><b>'.$_GET['pwd'].'</b></font>';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}
//-------������ ������ �� � ����---end

//-------�������� ������---start
if(isset($_GET['unlock'])){$delpass='../albums/'.$_GET['unlock'].'/pass.php';
@unlink($delpass);
echo '����� <font color="red"><b>'.$_GET['unlock'].'</b></font> - ��������������, ������ �����!';
echo '<script>window.location.href = "reset.php"</script>'; exit();
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}
//-------�������� ������---end

//---��������� ���. �����--start
if(isset($_GET['options'])){echo '<font color="blue"><h2>������� ����� ������</h2></font><fieldset><legend align="center">������� ��������</legend><form name="f4" method="get" action="edit.php">
<input type="text" name="makedir"><br>
<a href="javascript: document.f4.submit ()">�������</a>
</form></fieldset>';
echo '<br><font color="blue"><h2><u>������������</u></h2></font><a href="setup.php">������� ������ ��������</a>';}
//---��������� ���. �����--end

//--�������� ������ �������----start
if(isset($_GET['makedir'])){$_GET['makedir']=rus2translit($_GET['makedir']);
$newdir='../albums/'.$_GET['makedir'];
if(mkdir($newdir))
{echo '����� <font color="red"><b>'.$_GET['makedir'].'</b></font> - �������!';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}
else{echo '������! �� ������� ������� �����';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}}
//--�������� ������ �������----end

/*//--������ ��������� ��������--start
if(isset($_GET['setup'])){echo '<font color="blue"><h2><u>������������</u></h2></font><fieldset><legend>��������� �������</legend>
</fieldset>';}
//--������ ��������� ��������--end*/

//---���������� ������ ��������������--start
if(isset($_GET['logout']))
{unset($_SESSION['ok']);
echo "<html><head><meta http-equiv=\"refresh\" content=\"0;url=../\"></meta></head></html>";}
//---���������� ������ ��������������--end

include_once('footer.inc');

?>