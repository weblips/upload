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

//--проверка на незаполненные поля
if(isset($_POST['button']) and empty($_POST['setpass'])){echo '<font color="red">Ошибка: не задан пароль!</font>';include('footer.inc'); exit();}
if(isset($_POST['button']) and empty($_POST['setsess'])){echo '<font color="red">Ошибка: не задано имя сессии!</font>';include('footer.inc'); exit();}
if(isset($_POST['button']) and empty($_POST['albs'])){echo '<font color="red">Ошибка: Не задано кол-во альбомов на одной странице!</font>';include('footer.inc'); exit();}
if(isset($_POST['button']) and empty($_POST['tlength'])){echo '<font color="red">Ошибка: не задана максимальная длина названий альбомов!</font>';include('footer.inc'); exit();}
if(isset($_POST['button']) and empty($_POST['pics'])){echo '<font color="red">Ошибка: Не задано кол-во картинок на одной странице!</font>';include('footer.inc'); exit();}
if(isset($_POST['button']) and empty($_POST['upmsz'])){echo '<font color="red">Ошибка: Не задан максимальный размер для встроенного загрузчика!</font>';include('footer.inc'); exit();}

//--Запись в config.php
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
echo "<script>alert('Настройки сохранены!');</script>";}
 

//--Чтение config.php
$string=file_get_contents('../sys/config.php');

//--получаем пароль
$login_step1=strpos($string,'$login=');
$login_step2=substr($string,$login_step1,100);
$login_end=strpos($login_step2,"';");
$login_med=substr($login_step2,0,$login_end);
$login_start=strpos($login_med,"'");
$login_val=substr($login_med,$login_start+1);

//--получаем название сессии админа
$word_step1=strpos($string,'$word=');
$word_step2=substr($string,$word_step1,100);
$word_end=strpos($word_step2,"';");
$word_med=substr($word_step2,0,$word_end);
$word_start=strpos($word_med,"'");
$word_val=substr($word_med,$word_start+1);

//--получаем Количество изображений в альбоме на одной странице
$pp_step1=strpos($string,'$pp=');
$pp_step2=substr($string,$pp_step1,100);
$pp_end=strpos($pp_step2,"';");
$pp_med=substr($pp_step2,0,$pp_end);
$pp_start=strpos($pp_med,"'");
$pp_val=substr($pp_med,$pp_start+1);

//--получаем Количество изображений на главной странице
$tpp_step1=strpos($string,'$thumbs_pr_page=');
$tpp_step2=substr($string,$tpp_step1,100);
$tpp_end=strpos($tpp_step2,"';");
$tpp_med=substr($tpp_step2,0,$tpp_end);
$tpp_start=strpos($tpp_med,"'");
$tpp_val=substr($tpp_med,$tpp_start+1);

//--получаем значение переменной, отображать, или нет ссылку на админ-панель
$link_step1=strpos($string,'$show_admin_link=');
$link_step2=substr($string,$link_step1,100);
$link_end=strpos($link_step2,"';");
$link_med=substr($link_step2,0,$link_end);
$link_start=strpos($link_med,"'");
$link_val=substr($link_med,$link_start+1);

//--получаем значение title
$title_step1=strpos($string,'$title=');
$title_step2=substr($string,$title_step1,100);
$title_end=strpos($title_step2,"';");
$title_med=substr($title_step2,0,$title_end);
$title_start=strpos($title_med,"'");
$title_val=substr($title_med,$title_start+1);

//--получаем значение uploader max_file_size
$up_step1=strpos($string,'$up_max=');
$up_step2=substr($string,$up_step1,100);
$up_end=strpos($up_step2,"';");
$up_med=substr($up_step2,0,$up_end);
$up_start=strpos($up_med,"'");
$up_val=substr($up_med,$up_start+1);

//--получаем значение $label_max_length
$label_step1=strpos($string,'$label_max_length=');
$label_step2=substr($string,$label_step1,100);
$label_end=strpos($label_step2,"';");
$label_med=substr($label_step2,0,$label_end);
$label_start=strpos($label_med,"'");
$label_val=substr($label_med,$label_start+1);

//вывод панели настроек
echo '<div style="width: 50%"><fieldset><legend align="center">системные настройки</legend><form method="post" action="setup.php">
<br>Пароль администратора<br>
<input type="text" name="setpass" value="'.$login_val.'">
<input type="hidden" name="h1" value="'.$login_val.'">
<br>Имя сессии админа (любой случайный набор символов)<br>
<input type="text" name="setsess" value="'.$word_val.'">
<input type="hidden" name="h2" value="'.$word_val.'">
<br>Количество альбомов, отображающихся на одной странице<br>
<input type="text" name="albs" maxlength="2" value="'.$tpp_val.'">
<input type="hidden" name="h3" value="'.$tpp_val.'">
<br>Заголовок галереи (в теге &lt;title&gt;)<br>
<input type="text" name="gtitle" value="'.$title_val.'">
<input type="hidden" name="h4" value="'.$title_val.'">
<br>Максимальная длина названия альбома<br>(если название папки длиннее, оно обрезается, напр., вместо Wallpapers будет Wallp..)<br>
<input type="text" name="tlength" maxlength="2" value="'.$label_val.'">
<input type="hidden" name="h6" value="'.$label_val.'">
<br>Отображать ссылку на админ-панель на главной(1 - да/ 0 - нет)<br>
<input type="text" name="cp" maxlength="1" value="'.$link_val.'">
<input type="hidden" name="h7" value="'.$link_val.'">
<br>Кол-во картинок в альбоме, выводимых на одну страницу<br>
<input type="text" name="pics" maxlength="2" value="'.$pp_val.'">
<input type="hidden" name="h8" value="'.$pp_val.'">
<br>Максимальный размер файла через встроенный загрузчик<br>
(напр., <b>10M</b> - <i>10 мегабайт</i>, или <b>300Kb</b> - <i>300 килобайт</i>)<br>
<input type="text" name="upmsz" value="'.$up_val.'"><br>
<input type="hidden" name="h10" value="'.$up_val.'">
<input type="submit" name="button" value="применить">
</form></fieldset></div><br><div style="width: 80%">
Если вы отключили ссылку на панель управления на главной странице, то попасть в админку можно будет по адресу
http://your_site/gallery_name/cp<p>
Настройки скрипта также можно изменить, отредактировав вручную файл <i>sys/config.php</i>, но я бы не рекомендовал этого делать без крайней необходимости, потому что, например, лишний пробел в разделе определения переменных(<i>$login=&nbsp; \'pass\'</i>; вместо <b>$login=\'pass\';</b>) приведёт к тому, что настройки потом будут неправильно загружаться через панель управлении и  затем запишутся с ошибками в конфигурационный файл, что приведет к нарушению работы скрипта.<br>
Также например, если вы измените цвет фона главной страницы,(за это отвечает переменная <b>$backgroundcolor</b>), то скорее всего придется изменять и цвет текста, ведь стили прописаны в <i>template.html</i>, тогда придётся вручную редактировать ещё и этот файл.<br><font color="blue">Скрипт не поддерживает кириллицу в названиях файлов, поэтому перед загрузкой по фтп замените кириллицу и <font color="red"><b><i>пробелы</i></b></font> символами латинского алфавита, можно использовать цифры.
При создании папок и загрузке изображений через панель управления, транслитерация осуществляется автоматически.</font></p></div>';

include('footer.inc');
?>