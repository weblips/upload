<?php
session_start();
$c=$_SERVER['HTTP_REFERER'];
$s=$_SERVER['HTTP_HOST'];
if(strstr($c,$s)==false)
{die('Page not found!');}
if ($c=='')
{die('Page not found!');}
require('../sys/config.php');
if($_SESSION['ok']!=$word){die('Access denied!');}
include('body.inc');

//--�������� �� ������������� ����
if(isset($_POST['button']) and empty($_POST['setpass'])){echo '<font color="red">������: �� ����� ������!</font>';include('footer.inc'); exit();}
if(isset($_POST['button']) and empty($_POST['setsess'])){echo '<font color="red">������: �� ������ ��� ������!</font>';include('footer.inc'); exit();}
if(isset($_POST['button']) and empty($_POST['albs'])){echo '<font color="red">������: �� ������ ���-�� �������� �� ����� ��������!</font>';include('footer.inc'); exit();}
if(isset($_POST['button']) and empty($_POST['tlength'])){echo '<font color="red">������: �� ������ ������������ ����� �������� ��������!</font>';include('footer.inc'); exit();}
if(isset($_POST['button']) and empty($_POST['pics'])){echo '<font color="red">������: �� ������ ���-�� �������� �� ����� ��������!</font>';include('footer.inc'); exit();}
if(isset($_POST['button']) and empty($_POST['upmsz'])){echo '<font color="red">������: �� ����� ������������ ������ ��� ����������� ����������!</font>';include('footer.inc'); exit();}

//--������ � config.php
if(isset($_POST['button'])and !empty($_POST['setpass'])){$_POST['setpass']=trim($_POST['setpass']);
$s_setpass1="\$login="."'".$_POST['setpass']."'"; $s_setpass2="\$login="."'".$_POST['h1']."'";
$contents=file_get_contents('../sys/config.php');
$string=str_replace($s_setpass2,$s_setpass1,$contents);
$f=fopen('../sys/config.php',"w");
fwrite($f,$string);
fclose($f);}

if(isset($_POST['button'])and !empty($_POST['setsess'])){$_POST['setsess']=trim($_POST['setsess']);
$s_setsess1="\$word="."'".$_POST['setsess']."'"; $s_setsess2="\$word="."'".$_POST['h2']."'";
$contents=file_get_contents('../sys/config.php');
$string=str_replace($s_setsess2,$s_setsess1,$contents);
$f=fopen('../sys/config.php',"w");
fwrite($f,$string);
fclose($f);}

if(isset($_POST['button'])and !empty($_POST['albs'])){$_POST['albs']=trim($_POST['albs']);
$s_albs1="\$thumbs_pr_page="."'".$_POST['albs']."'"; $s_albs2="\$thumbs_pr_page="."'".$_POST['h3']."'";
$contents=file_get_contents('../sys/config.php');
$string=str_replace($s_albs2,$s_albs1,$contents);
$f=fopen('../sys/config.php',"w");
fwrite($f,$string);
fclose($f);}

if(isset($_POST['button'])){$_POST['gtitle']=trim($_POST['gtitle']);
$s_gtitle1="\$title="."'".$_POST['gtitle']."'"; $s_gtitle2="\$title="."'".$_POST['h4']."'";
$contents=file_get_contents('../sys/config.php');
$string=str_replace($s_gtitle2,$s_gtitle1,$contents);
$f=fopen('../sys/config.php',"w");
fwrite($f,$string);
fclose($f);}

if(isset($_POST['button'])and !empty($_POST['tlength'])){$_POST['tlength']=trim($_POST['tlength']);
$s_tlength1="\$label_max_length="."'".$_POST['tlength']."'"; $s_tlength2="\$label_max_length="."'".$_POST['h6']."'";
$contents=file_get_contents('../sys/config.php');
$string=str_replace($s_tlength2,$s_tlength1,$contents);
$f=fopen('../sys/config.php',"w");
fwrite($f,$string);
fclose($f);}

if(isset($_POST['button'])){$_POST['cp']=trim($_POST['cp']);
$s_cp1="\$show_admin_link="."'".$_POST['cp']."'"; $s_cp2="\$show_admin_link="."'".$_POST['h7']."'";
$contents=file_get_contents('../sys/config.php');
$string=str_replace($s_cp2,$s_cp1,$contents);
$f=fopen('../sys/config.php',"w");
fwrite($f,$string);
fclose($f);}

if(isset($_POST['button']) and !empty($_POST['pics'])){$_POST['pics']=trim($_POST['pics']);
$s_pics1="\$pp="."'".$_POST['pics']."'"; $s_pics2="\$pp="."'".$_POST['h8']."'";
$contents=file_get_contents('../sys/config.php');
$string=str_replace($s_pics2,$s_pics1,$contents);
$f=fopen('../sys/config.php',"w");
fwrite($f,$string);
fclose($f);}

if(isset($_POST['button'])and !empty($_POST['upmsz'])){$_POST['upmsz']=trim($_POST['upmsz']);
$s_upmsz1="\$up_max="."'".$_POST['upmsz']."'"; $s_upmsz2="\$up_max="."'".$_POST['h10']."'";
$contents=file_get_contents('../sys/config.php');
$string=str_replace($s_upmsz2,$s_upmsz1,$contents);
$f=fopen('../sys/config.php',"w");
fwrite($f,$string);
fclose($f);}

if(isset($_POST['button']))
{$dir  = '../albums';
$files = scandir($dir);
foreach ($files as $file):
if($file=='..' or $file=='.'){}
else
{$index=$dir.'/'.$file.'/index.php';
@unlink($index);} 
endforeach;
echo "<script>alert('��������� ���������!');</script>";}
 

//--������ config.php
$string=file_get_contents('../sys/config.php');

//--�������� ������
$login_step1=strpos($string,'$login=');
$login_step2=substr($string,$login_step1,100);
$login_end=strpos($login_step2,"';");
$login_med=substr($login_step2,0,$login_end);
$login_start=strpos($login_med,"'");
$login_val=substr($login_med,$login_start+1);

//--�������� �������� ������ ������
$word_step1=strpos($string,'$word=');
$word_step2=substr($string,$word_step1,100);
$word_end=strpos($word_step2,"';");
$word_med=substr($word_step2,0,$word_end);
$word_start=strpos($word_med,"'");
$word_val=substr($word_med,$word_start+1);

//--�������� ���������� ����������� � ������� �� ����� ��������
$pp_step1=strpos($string,'$pp=');
$pp_step2=substr($string,$pp_step1,100);
$pp_end=strpos($pp_step2,"';");
$pp_med=substr($pp_step2,0,$pp_end);
$pp_start=strpos($pp_med,"'");
$pp_val=substr($pp_med,$pp_start+1);

//--�������� ���������� ����������� �� ������� ��������
$tpp_step1=strpos($string,'$thumbs_pr_page=');
$tpp_step2=substr($string,$tpp_step1,100);
$tpp_end=strpos($tpp_step2,"';");
$tpp_med=substr($tpp_step2,0,$tpp_end);
$tpp_start=strpos($tpp_med,"'");
$tpp_val=substr($tpp_med,$tpp_start+1);

//--�������� �������� ����������, ����������, ��� ��� ������ �� �����-������
$link_step1=strpos($string,'$show_admin_link=');
$link_step2=substr($string,$link_step1,100);
$link_end=strpos($link_step2,"';");
$link_med=substr($link_step2,0,$link_end);
$link_start=strpos($link_med,"'");
$link_val=substr($link_med,$link_start+1);

//--�������� �������� title
$title_step1=strpos($string,'$title=');
$title_step2=substr($string,$title_step1,100);
$title_end=strpos($title_step2,"';");
$title_med=substr($title_step2,0,$title_end);
$title_start=strpos($title_med,"'");
$title_val=substr($title_med,$title_start+1);

//--�������� �������� uploader max_file_size
$up_step1=strpos($string,'$up_max=');
$up_step2=substr($string,$up_step1,100);
$up_end=strpos($up_step2,"';");
$up_med=substr($up_step2,0,$up_end);
$up_start=strpos($up_med,"'");
$up_val=substr($up_med,$up_start+1);

//--�������� �������� $label_max_length
$label_step1=strpos($string,'$label_max_length=');
$label_step2=substr($string,$label_step1,100);
$label_end=strpos($label_step2,"';");
$label_med=substr($label_step2,0,$label_end);
$label_start=strpos($label_med,"'");
$label_val=substr($label_med,$label_start+1);

//����� ������ ��������
echo '<div style="width: 50%"><fieldset><legend align="center">��������� ���������</legend><form method="post" action="setup.php">
<br>������ ��������������<br>
<input type="text" name="setpass" value="'.$login_val.'">
<input type="hidden" name="h1" value="'.$login_val.'">
<br>��� ������ ������ (����� ��������� ����� ��������)<br>
<input type="text" name="setsess" value="'.$word_val.'">
<input type="hidden" name="h2" value="'.$word_val.'">
<br>���������� ��������, �������������� �� ����� ��������<br>
<input type="text" name="albs" maxlength="2" value="'.$tpp_val.'">
<input type="hidden" name="h3" value="'.$tpp_val.'">
<br>��������� ������� (� ���� &lt;title&gt;)<br>
<input type="text" name="gtitle" value="'.$title_val.'">
<input type="hidden" name="h4" value="'.$title_val.'">
<br>������������ ����� �������� �������<br>(���� �������� ����� �������, ��� ����������, ����., ������ Wallpapers ����� Wallp..)<br>
<input type="text" name="tlength" maxlength="2" value="'.$label_val.'">
<input type="hidden" name="h6" value="'.$label_val.'">
<br>���������� ������ �� �����-������ �� �������(1 - ��/ 0 - ���)<br>
<input type="text" name="cp" maxlength="1" value="'.$link_val.'">
<input type="hidden" name="h7" value="'.$link_val.'">
<br>���-�� �������� � �������, ��������� �� ���� ��������<br>
<input type="text" name="pics" maxlength="2" value="'.$pp_val.'">
<input type="hidden" name="h8" value="'.$pp_val.'">
<br>������������ ������ ����� ����� ���������� ���������<br>
(����., <b>10M</b> - <i>10 ��������</i>, ��� <b>300Kb</b> - <i>300 ��������</i>)<br>
<input type="text" name="upmsz" value="'.$up_val.'"><br>
<input type="hidden" name="h10" value="'.$up_val.'">
<input type="submit" name="button" value="���������">
</form></fieldset></div><br><div style="width: 80%">
���� �� ��������� ������ �� ������ ���������� �� ������� ��������, �� ������� � ������� ����� ����� �� ������
http://your_site/gallery_name/cp<p>
��������� ������� ����� ����� ��������, �������������� ������� ���� <i>sys/config.php</i>, �� � �� �� ������������ ����� ������ ��� ������� �������������, ������ ���, ��������, ������ ������ � ������� ����������� ����������(<i>$login=&nbsp; \'pass\'</i>; ������ <b>$login=\'pass\';</b>) ������� � ����, ��� ��������� ����� ����� ����������� ����������� ����� ������ ���������� �  ����� ��������� � �������� � ���������������� ����, ��� �������� � ��������� ������ �������.<br>
����� ��������, ���� �� �������� ���� ���� ������� ��������,(�� ��� �������� ���������� <b>$backgroundcolor</b>), �� ������ ����� �������� �������� � ���� ������, ���� ����� ��������� � <i>template.html</i>, ����� ������� ������� ������������� ��� � ���� ����.<br><font color="blue">������ �� ������������ ��������� � ��������� ������, ������� ����� ��������� �� ��� �������� ��������� � <font color="red"><b><i>�������</i></b></font> ��������� ���������� ��������, ����� ������������ �����.
��� �������� ����� � �������� ����������� ����� ������ ����������, �������������� �������������� �������������.</font></p></div>';

include('footer.inc');
?>