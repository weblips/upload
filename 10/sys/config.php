<?php
/*
����� � ������������� ������ ���� ����������� � �������� albums
� ��������� ����� ������ ������������ ������������� � ������ ������������� �������, � ����� �������
*/

$login='pass'; //default admin pass - ������ �������������� �� ���������
$word='hoe238uy'; //�������� ������ ������, - ����� ��������� ����� ��������

//--------------------��������� ����������� ������������ 
$album_width='600'; // width in pixels
$thumb_width='120'; // width of thumbnail images
$thumb_height='80'; // height of thumbnail images
$pp='12'; //display how many pictures per page - ���������� ����������� � �������, �������������� �� ����� ��������
//$enable_thumbnailviewer='1'; //'0' disable - ���� �� ������, ����� ��� ����� �� �������� ��� ����������� �� ����� �������� ��������� '0', �� ��������� '1' ������������ ���������� ����������� �� javascript

//---------------------��������� ������� �������� (��� ��� ��������� �������)
// EDIT SETTINGS BELOW TO CUSTOMIZE YOUR GALLERY
$thumbs_pr_page='12';//Number of albums displayed on a single page - ���������� �������� ������������ �� ��������
$gallery_width='900px'; //Gallery width. Eg: '500px' or '70%'
$backgroundcolor='white'; 
$title='�������'; // Text to be displayed in browser titlebar
$folder_color='vista'; // Color of folder icons: blue / black / vista / purple / green / grey
$sorting_folders='name'; // Sort folders by: [name][date]
$sortdir_folders='ASC'; // Sort direction of folders: [ASC][DESC]
$show_admin_link='1';// '1' - display link for control panel, '0' - don't display
//'1' - ���������� ������ �� ������ ����������, '0' - �� ����������

//---Uploader settings--��������� ����������� ����������--start
$up_max='15M'; //uploader max_file_size - ������������ ������ ����������� � ����������
//����������� ����� ���������� ��������� M: ���������, Kb: ���������
$up_ext='jpg,jpeg,gif,png'; //���������� ���������� ������
//---Uploader settings--��������� ����������� ����������--end

//LANGUAGE STRINGS
$label_page='���.'; //Text used for page navigation
$label_all='���'; //Text used for link to display all images in one page
$label_noimages='<h2>����������� ����� ��� :(<br>���������� ����� � ����������<br>� ������� ALBUMS</h2>'; //Empty folder text
$label_loading='��������...'; //Thumbnail loading text

//ADVANCED SETTINGS
$thumb_size='120'; 
$label_max_length='10'; //Maximum chars of a folder name that will be displayed on the folder thumbnail
$templatefile='template'; //Don't edit this line!
  
//---Don't edit this line!---
/*if($enable_thumbnailviewer=='1'){$viewer='" rel="thumbnail"';}
else{$viewer='';}*/
//---------Don't edit this line!
if($show_admin_link=='1'){$cplink='<div align="right"><a href="cp?action=enter"><b>������ ����������</b></a></div>';}
else{$cplink='';}
?>