<?php
/*
Папки с изображениями должны быть расположены в каталоге albums
В названиях папок НЕЛЬЗЯ использовать кириллические и другие нестандартные символы, а также пробелы
*/

$login='pass'; //default admin pass - пароль администратора по умолчанию
$word='hoe238uy'; //название сессии админа, - любой случайный набор символов

//--------------------НАСТРОЙКИ ОТОБРАЖЕНИЯ ПОДКАТАЛОГОВ 
$album_width='600'; // width in pixels
$thumb_width='120'; // width of thumbnail images
$thumb_height='80'; // height of thumbnail images
$pp='12'; //display how many pictures per page - Количество изображений в альбоме, отображающихся на одной странице
//$enable_thumbnailviewer='1'; //'0' disable - если вы хотите, чтобы при клике на картинку она открывалась на новой странице поставьте '0', по умолчанию '1' используется встроенный просмотрщик на javascript

//---------------------НАСТРОЙКА ГЛАВНОЙ СТРАНИЦЫ (там где выводятся альбомы)
// EDIT SETTINGS BELOW TO CUSTOMIZE YOUR GALLERY
$thumbs_pr_page='12';//Number of albums displayed on a single page - Количество альбомов отображаемых на странице
$gallery_width='900px'; //Gallery width. Eg: '500px' or '70%'
$backgroundcolor='white'; 
$title='ГАЛЕРЕЯ'; // Text to be displayed in browser titlebar
$folder_color='vista'; // Color of folder icons: blue / black / vista / purple / green / grey
$sorting_folders='name'; // Sort folders by: [name][date]
$sortdir_folders='ASC'; // Sort direction of folders: [ASC][DESC]
$show_admin_link='1';// '1' - display link for control panel, '0' - don't display
//'1' - отображать ссылку на панель управления, '0' - не отображать

//---Uploader settings--Настройки встроенного загрузчика--start
$up_max='15M'; //uploader max_file_size - Максимальный размер изображения в мегабайтах
//загружаемый через встроенный загрузчик M: мегабайты, Kb: килобайты
$up_ext='jpg,jpeg,gif,png'; //допустимые расширения файлов
//---Uploader settings--Настройки встроенного загрузчика--end

//LANGUAGE STRINGS
$label_page='стр.'; //Text used for page navigation
$label_all='все'; //Text used for link to display all images in one page
$label_noimages='<h2>Изображений здесь нет :(<br>скопируйте папку с картинками<br>в каталог ALBUMS</h2>'; //Empty folder text
$label_loading='Загрузка...'; //Thumbnail loading text

//ADVANCED SETTINGS
$thumb_size='120'; 
$label_max_length='10'; //Maximum chars of a folder name that will be displayed on the folder thumbnail
$templatefile='template'; //Don't edit this line!
  
//---Don't edit this line!---
/*if($enable_thumbnailviewer=='1'){$viewer='" rel="thumbnail"';}
else{$viewer='';}*/
//---------Don't edit this line!
if($show_admin_link=='1'){$cplink='<div align="right"><a href="cp?action=enter"><b>панель управления</b></a></div>';}
else{$cplink='';}
?>