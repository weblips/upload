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
'а' => 'a',   'б' => 'b',   'в' => 'v',
'г' => 'g',   'д' => 'd',   'е' => 'e',
'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
'и' => 'i',   'й' => 'y',   'к' => 'k',
'л' => 'l',   'м' => 'm',   'н' => 'n',
'о' => 'o',   'п' => 'p',   'р' => 'r',
'с' => 's',   'т' => 't',   'у' => 'u',
'ф' => 'f',   'х' => 'h',   'ц' => 'c',
'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
'ь' => '_',  'ы' => 'y',   'ъ' => '_',
'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
'А' => 'A',   'Б' => 'B',   'В' => 'V',
'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
'И' => 'I',   'Й' => 'Y',   'К' => 'K',
'Л' => 'L',   'М' => 'M',   'Н' => 'N',
'О' => 'O',   'П' => 'P',   'Р' => 'R',
'С' => 'S',   'Т' => 'T',   'У' => 'U',
'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
'Ь' => '_',  'Ы' => 'Y',   'Ъ' => '_',
'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',);
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

//-------Удаление картинки---start
if(isset($_GET['picfolder']) and isset($_GET['del_img'])){echo '<a href="edit.php?erasepic='.$_GET['del_img'].'&erase_from='.$_GET['picfolder'].'" OnClick="return confirm(\'Изображение будет удалено,продолжить?\');"> удалить изображение<font color="red"><b> '.$_GET['del_img'].'</b></font></a>';
echo '<br><br><br><a href="index.php?action=enter">Конфигурация</a>';}
if(isset($_GET['erase_from']) and isset($_GET['erasepic'])){$delpath='../albums/'.$_GET['erase_from'].'/'.$_GET['erasepic'];
$url='../albums/'.$_GET['erase_from'];
if(unlink($delpath))
{echo 'Изображение <font color="red"><b>'.$_GET['erasepic'].'</b></font> удалено!';
echo '<script>window.location.href = "'.$url.'"</script>';}
else
{echo '<font color="red"><b>Ошибка: не удалось удалить изображение!</b></font>';
echo '<script>window.location.href = "'.$url.'"</script>';}}
//-------Удаление картинки---end

//-------Переименование картинки--start
if(isset($_GET['picfolder']) and isset($_GET['ren_img'])){$ren_old=pathinfo($_GET['ren_img'],PATHINFO_FILENAME);
$ext=pathinfo($_GET['ren_img'], PATHINFO_EXTENSION);
echo 'Задайте новое имя для файла <font color="red"><b>'.$_GET['ren_img'].'</b></font><br>';
echo '<form name="f4" method="get" action="edit.php">
<input type="text" name="ren_to" value="'.$ren_old.'">
<input type="hidden" name="old_img_name" value="'.$_GET['ren_img'].'">
<input type="hidden" name="ext" value=".'.$ext.'">
<input type="hidden" name="in_folder" value="'.$_GET['picfolder'].'">
<a href="javascript: document.f4.submit ()">переименовать</a>
</form>';
echo '<br><br><br><a href="index.php?action=enter">Конфигурация</a>';}
if(isset($_GET['in_folder']) and isset($_GET['old_img_name']) and isset($_GET['ren_to']) and isset($_GET['ext'])){$oldpic='../albums/'.$_GET['in_folder'].'/'.$_GET['old_img_name'];$_GET['ren_to']=trim($_GET['ren_to']);
$_GET['ren_to']=rus2translit($_GET['ren_to']);
$newpic='../albums/'.$_GET['in_folder'].'/'.$_GET['ren_to'].$_GET['ext'];
$url='../albums/'.$_GET['in_folder'];
if(rename($oldpic,$newpic))
{echo 'Изображение переименовано!';
echo '<script>window.location.href = "'.$url.'"</script>';}
else
{echo 'Ошибка: не удалось переименовать изображение!';
echo '<script>window.location.href = "'.$url.'"</script>';}}

//-------Переименование картинки--end


//-------Удаление папки---start
if(isset($_GET['deldir'])){echo '<center><a href="edit.php?erasedir='.$_GET['deldir'].'" OnClick="return confirm(\'Папка будет удалена,продолжить?\');">удалить папку '.$_GET['deldir'].'</a><br><br><br><a href="index.php?action=enter">Конфигурация</a></center>';}
if(isset($_GET['erasedir'])){$ftd='../albums/'.$_GET['erasedir'].'/';
delTree($ftd);
echo'<center><font color="red">Папка '.$_GET['erasedir'].' удалена!</font></center>';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}
//-------Удаление папки---end

//-------Переименование папки--start
if(isset($_GET['rendir'])){echo 'Задайте новое имя для папки <font color="red"><b>'.$_GET['rendir'].'</b></font><br>';
echo '<form name="f3" method="get" action="edit.php">
<input type="text" name="newname" value="'.$_GET['rendir'].'">
<input type="hidden" name="oldname" value="'.$_GET['rendir'].'">
<a href="javascript: document.f3.submit ()">переименовать</a>
</form>';
echo '<br><br><br><a href="index.php?action=enter">Конфигурация</a>';}
if(isset($_GET['oldname']) and isset($_GET['newname'])){$old='../albums/'.$_GET['oldname'];
$_GET['newname']=trim($_GET['newname']);
$_GET['newname']=rus2translit($_GET['newname']);
$new='../albums/'.$_GET['newname'];
if(rename($old,$new))
{echo 'Папка <font color="red"><b>'.$_GET['oldname'].'</b></font> переименована!';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}
else
{echo '<font color="red"><b>Ошибка: не удалось переименовать папку!</b></font>';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}}
//-------Переименование папки--end

//-------Установка пароля на папку---start
if(isset($_GET['lockdir'])){echo 'Вы собираетесь задать пароль для папки <font color="red"><b>'.$_GET['lockdir'].'</b></font><br>';
echo '<form name="f4" method="get" action="edit.php">
<input type="text" name="pwd">
<input type="hidden" name="foldername" value="'.$_GET['lockdir'].'">
<a href="javascript: document.f4.submit ()">задать пароль</a>
</form>';
echo '<br><br><br><a href="index.php?action=enter">Конфигурация</a>';}

//--------------Если пароль существует, показываем ссылку для удаления--start
$foundpwp='../albums/'.$_GET['lockdir'].'/pass.php';
;@include($foundpwp);
if(file_exists($foundpwp)){echo '<br>Папка <font color="red"><b>'.$_GET['lockdir'].'</b></font> закрыта паролем: [ <i><b><font color="red">'.$key.' </font></b></i>] снять пароль?<br>';
echo '<a href="edit.php?unlock='.$_GET['lockdir'].'">удалить пароль</a>';
echo '<p><font color="red">Внимание: </font>пароль будет удалён без подтверждения, и сессия администратора 
завершена,<br>чтобы изменения вступили в силу!</p>';
echo '<a href="index.php?action=enter">Конфигурация</a>';}

//--------------Если пароль существует, показываем ссылку для удаления--end


//-------Запись пароля на в файл---start
if(isset($_GET['foldername']) and isset($_GET['pwd'])){$_GET['pwd']=trim($_GET['pwd']);
$newpass=fopen('../albums/'.$_GET['foldername'].'/pass.php',"w");
$text='<?php $key="'.$_GET['pwd'].'"; ?>';
fwrite($newpass,$text);
fclose($newpass);
echo 'Для папки <font color="red"><b>'.$_GET['foldername'].'</b></font> был установлен пароль <font color="red"><b>'.$_GET['pwd'].'</b></font>';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}
//-------Запись пароля на в файл---end

//-------Удаление пароля---start
if(isset($_GET['unlock'])){$delpass='../albums/'.$_GET['unlock'].'/pass.php';
@unlink($delpass);
echo 'Папка <font color="red"><b>'.$_GET['unlock'].'</b></font> - разблокирована, пароль удалён!';
echo '<script>window.location.href = "reset.php"</script>'; exit();
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}
//-------Удаление пароля---end

//---Интерфейс доп. опций--start
if(isset($_GET['options'])){echo '<font color="blue"><h2>Создать новый альбом</h2></font><fieldset><legend align="center">Введите название</legend><form name="f4" method="get" action="edit.php">
<input type="text" name="makedir"><br>
<a href="javascript: document.f4.submit ()">создать</a>
</form></fieldset>';
echo '<br><font color="blue"><h2><u>Конфигурация</u></h2></font><a href="setup.php">Открыть панель настроек</a>';}
//---Интерфейс доп. опций--end

//--Создание нового альбома----start
if(isset($_GET['makedir'])){$_GET['makedir']=rus2translit($_GET['makedir']);
$newdir='../albums/'.$_GET['makedir'];
if(mkdir($newdir))
{echo 'Папка <font color="red"><b>'.$_GET['makedir'].'</b></font> - создана!';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}
else{echo 'Ошибка! Не удалось создать папку';
echo "<html><head><meta http-equiv=\"refresh\" content=\"2;url=../\"></meta></head></html>";}}
//--Создание нового альбома----end

/*//--Панель системных настроек--start
if(isset($_GET['setup'])){echo '<font color="blue"><h2><u>Конфигурация</u></h2></font><fieldset><legend>Настройки галереи</legend>
</fieldset>';}
//--Панель системных настроек--end*/

//---Завершение сессии администратора--start
if(isset($_GET['logout']))
{unset($_SESSION['ok']);
echo "<html><head><meta http-equiv=\"refresh\" content=\"0;url=../\"></meta></head></html>";}
//---Завершение сессии администратора--end

include_once('footer.inc');

?>