<?php
session_start();
$_SESSION['onsite']='1';
error_reporting(0);
if(!file_exists('albums/index.htm')){copy('sys/index.htm','albums/index.htm');}

// Do not edit below this section unless you know what you are doing!

//Compact Albums Store -image gallery script by Veterock 2015  http://veterock.com

/*ѕапки с изображени€ми должны быть расположены в каталоге albums
¬ названи€х папок Ќ≈Ћ№«я использовать кириллические и другие нестандартные символы, а также пробелы. ¬ложенные папки внутри альбомов не отображаютс€.
*/	

$version = "v 0.3";
ini_set("memory_limit","256M");

require("sys/config.php");
//-----------------------
// DEFINE VARIABLES
//-----------------------
$page_navigation = "";
$breadcrumb_navigation = "";
$thumbnails = "";
$new = "";
$images = "";
$exif_data = "";
$messages = "";
$sessval=$_SESSION['ok'];
if(isset($_GET['mode'])){$_SESSION['mode']=$_GET['mode'];}

//-----------------------
// FUNCTIONS
//-----------------------
function is_directory($filepath) {
	// $filepath must be the entire system path to the file
	if (!@opendir($filepath)) return FALSE;
	else {
		return TRUE;
		closedir($filepath);
	}
}

function padstring($name, $length) {
	global $label_max_length;
	if (!isset($length)) $length = $label_max_length;
	if (strlen($name) > $length) {
      return substr($name,0,$length) . "...";
   } else return $name;
}
function getfirstImage($dirname) {
	$imageName = false;
	$ext = array("jpg", "png", "jpeg", "gif", "JPG", "PNG", "GIF", "JPEG");
	if($handle = opendir($dirname))
	{
		while(false !== ($file = readdir($handle)))
		{
			$lastdot = strrpos($file, '.');
			$extension = substr($file, $lastdot + 1);
			if ($file[0] != '.' && in_array($extension, $ext)) break;
		}
		$imageName = $file;
		closedir($handle);
	}
	return($imageName);
}

function checkpermissions($file) {
	global $messages;
	if (substr(decoct(fileperms($file)), -1, strlen(fileperms($file))) < 4 OR substr(decoct(fileperms($file)), -3,1) < 4) $messages = "";
}

if (!defined("GALLERY_ROOT")) define("GALLERY_ROOT", "");
$thumbdir = rtrim('albums' . "/" .$_REQUEST["dir"],"/");
$thumbdir = str_replace("/..", "", $thumbdir); // Prevent looking at any up-level folders
$currentdir = GALLERY_ROOT . $thumbdir;

//-----------------------
// READ FILES AND FOLDERS
//-----------------------
$files = array();
$dirs = array();
 if ($handle = opendir($currentdir))
 {
	while (false !== ($file = readdir($handle)))
    {
// 1. LOAD FOLDERS
		if (is_directory($currentdir . "/" . $file))
			{ 
				if ($file != "." && $file != ".." )
				{
					checkpermissions($currentdir . "/" . $file); // Check for correct file permission
					// Set thumbnail to folder.jpg if found:
					if (file_exists("$currentdir/" . $file . "/folder.jpg"))
					{
						$dirs[] = array(
							"name" => $file,
							"date" => filemtime($currentdir . "/" . $file . "/folder.jpg"),
							"html" => "<li><a href='?dir=" .ltrim($_GET['dir'] . "/" . $file, "/") . "'><em>" . padstring($file, $label_max_length) . "</em><span></span><img src='" . GALLERY_ROOT . "createthumb.php?filename=$currentdir/" . $file . "/folder.jpg&amp;size=$thumb_size'  alt='$label_loading' /></a></li>");
					}  else
					{
					// Set thumbnail to first image found (if any):
						unset ($firstimage);
if(file_exists("$currentdir/" . $file."/pass.php")){$firstimage='../../sys/i/lock.png';} else
						{$firstimage = getfirstImage("$currentdir/" . $file);}
//----------—сылки на удаление,переименование и пр. каталогов-----start
if($sessval==$word){$edit='<div align="right">|<a href="cp/edit.php?deldir='.$file.'">delete|</a><br><a href="cp/edit.php?rendir='.$file.'">|rename|</a><br><a href="cp/edit.php?lockdir='.$file.'">|set password|</a><br><a href="uploader/index.php?up='.$file.'">|upload|</a></div>';}
else{$edit='';}
//----------//----------—сылки на удаление,переименование и пр. каталогов-----end
						if ($firstimage != "") {
						$dirs[] = array(
							"name" => $file,
							"date" => filemtime($currentdir . "/" . $file),
							"html" => "<li><a href='view.php?" . ltrim($_GET['dir'] . "/" . $file, "/") . "'><em>" . padstring($file, $label_max_length) . "</em><span></span><img src='" . GALLERY_ROOT . "createthumb.php?filename=$thumbdir/" . $file . "/" . $firstimage . "&amp;size=$thumb_size'  alt='$label_loading' /></a>$edit</li>");
						} else {
						// If no folder.jpg or image is found, then display default icon:
							$dirs[] = array(
								"name" => $file,
								"date" => filemtime($currentdir . "/" . $file),
								"html" => "<li><a href='?dir=" . ltrim($_GET['dir'] . "/" . $file, "/") . "'><em>" . padstring($file) . "</em><span></span><img src='" . GALLERY_ROOT . "sys/i/folder_" . strtolower($folder_color) . ".png' width='$thumb_size' height='$thumb_size' alt='$label_loading' /></a>$edit</li>");
						}
					}
				}
			}

// 3. LOAD FILES
	        	if ($file != "." && $file != ".." && $file != "folder.jpg")
		  		{
		  			// JPG, GIF and PNG
		  			if (preg_match("/.jpg$|.gif$|.png$/i", $file))
		  			{
						//Read EXIF
						if ($display_exif == 1) $img_captions[$file] .= readEXIF($currentdir . "/" . $file);

						checkpermissions($currentdir . "/" . $file);
			  			$files[] = array (
			  				"name" => $file,
							"date" => filemtime($currentdir . "/" . $file),
							"size" => filesize($currentdir . "/" . $file),
				  			"html" => "<li><a href='" . $currentdir . "/" . $file . "' rel='lightbox[billeder]' title='$img_captions[$file]'><span></span><img src='" . GALLERY_ROOT . "createthumb.php?filename=" . $thumbdir . "/" . $file . "&amp;size=$thumb_size' alt='$label_loading' /></a></li>");
		  			}
					// Other filetypes
					$extension = "";
		        	if (preg_match("/.pdf$/i", $file)) $extension = "PDF"; // PDF
		        	if (preg_match("/.zip$/i", $file)) $extension = "ZIP"; // ZIP archive
		        	if (preg_match("/.rar$|.r[0-9]{2,}/i", $file)) $extension = "RAR"; // RAR Archive
		        	if (preg_match("/.tar$/i", $file)) $extension = "TAR"; // TARball archive
		        	if (preg_match("/.gz$/i", $file)) $extension = "GZ"; // GZip archive
		        	if (preg_match("/.doc$|.docx$/i", $file)) $extension = "DOCX"; // Word
		        	if (preg_match("/.ppt$|.pptx$/i", $file)) $extension = "PPTX"; //Powerpoint
		        	if (preg_match("/.xls$|.xlsx$/i", $file)) $extension = "XLXS"; // Excel
		        			        	
		        	if ($extension != "")
			  		{
		  				$files[] = array (
		  					"name" => $file,
							"date" => filemtime($currentdir . "/" . $file),
							"size" => filesize($currentdir . "/" . $file),
			  				"html" => "<li><a href='" . $currentdir . "/" . $file . "' title='$file'><em-pdf>" . padstring($file, 20) . "</em-pdf><span></span><img src='" . GALLERY_ROOT . "images/filetype_" . $extension . ".png' width='$thumb_size' height='$thumb_size' alt='$file' /></a></li>");
        			}
     			}   		
	}
  closedir($handle);
  } else die("ERROR: Could not open $currentdir for reading!");

//-----------------------
// SORT FILES AND FOLDERS
//-----------------------
if (sizeof($dirs) > 0) 
{
	foreach ($dirs as $key => $row)
	{
		if($row["name"] == "") unset($dirs[$key]); //Delete empty array entries
		$name[$key] = strtolower($row['name']);
		$date[$key] = strtolower($row['date']);
	}	
	if (strtoupper($sortdir_folders) == "DESC") array_multisort($$sorting_folders, SORT_DESC, $name, SORT_DESC, $dirs);
	else array_multisort($$sorting_folders, SORT_ASC, $name, SORT_ASC, $dirs);
}
if (sizeof($files) > 0)
{
	foreach ($files as $key => $row)
	{
		if($row["name"] == "") unset($files[$key]); //Delete empty array entries
		$name[$key] = strtolower($row['name']);
		$date[$key] = strtolower($row['date']);
		$size[$key] = strtolower($row['size']);
	}
	if (strtoupper($sortdir_files) == "DESC") array_multisort($$sorting_files, SORT_DESC, $name, SORT_ASC, $files);
	else array_multisort($$sorting_files, SORT_ASC, $name, SORT_ASC, $files);
}

//-----------------------
// OFFSET DETERMINATION
//-----------------------
	$offset_start = ($_GET["page"] * $thumbs_pr_page) - $thumbs_pr_page;
	if (!isset($_GET["page"])) $offset_start = 0;
	$offset_end = $offset_start + $thumbs_pr_page;
	if ($offset_end > sizeof($dirs) + sizeof($files)) $offset_end = sizeof($dirs) + sizeof($files);

	if ($_GET["page"] == "all")
	{
		$offset_start = 0;
		$offset_end = sizeof($dirs) + sizeof($files);
	}

//-----------------------
// PAGE NAVIGATION
//-----------------------
if (!isset($_GET["page"])) $_GET["page"] = 1;
if (sizeof($dirs) + sizeof($files) > $thumbs_pr_page)
{
	$page_navigation .= "$label_page ";
	for ($i=1; $i <= ceil((sizeof($files) + sizeof($dirs)) / $thumbs_pr_page); $i++)
	{
		if ($_GET["page"] == $i)
			$page_navigation .= "$i";
			else
				$page_navigation .= "<a href='?dir=" . $_GET["dir"] . "&amp;page=" . ($i) . "'>" . $i . "</a>";
		if ($i != ceil((sizeof($files) + sizeof($dirs)) / $thumbs_pr_page)) $page_navigation .= " | ";
	}
	//Insert link to view all images
	if ($_GET["page"] == "all") $page_navigation .= " | $label_all";
	else $page_navigation .= " | <a href='?dir=" . $_GET["dir"] . "&amp;page=all'>$label_all</a>";
}

//-----------------------
// DISPLAY FOLDERS
//-----------------------
if (count($dirs) + count($files) == 0) {
	$thumbnails .= "<li>$label_noimages</li>"; //Display 'no images' text
	if($currentdir == "photos") $messages = "";
}
$offset_current = $offset_start;
for ($x = $offset_start; $x < sizeof($dirs) && $x < $offset_end; $x++)
{
	$offset_current++;
	$thumbnails .= $dirs[$x]["html"];
}

//-----------------------
// DISPLAY FILES
//-----------------------
for ($i = $offset_start - sizeof($dirs); $i < $offset_end && $offset_current < $offset_end; $i++)
{
	if ($i >= 0)
	{
		$offset_current++;
		$thumbnails .= $files[$i]["html"];
	}
}

//Include hidden links for all images AFTER current page so lightbox is able to browse images on different pages
for ($y = $i; $y < sizeof($files); $y++)
{	
	$page_navigation .= "<a href='" . $currentdir . "/" . $files[$y]["name"] . "' rel='lightbox[billeder]'  class='hidden' title='" . $img_captions[$files[$y]["name"]] . "'></a>";
}

//-----------------------
// OUTPUT MESSAGES
//-----------------------
if ($messages != "") {
$messages = "<div id=\"topbar\">" . $messages . " <a href=\"#\" onclick=\"document.getElementById('topbar').style.display = 'none';\";><img src=\"images/close.png\" /></a></div>";
}

//PROCESS TEMPLATE FILE
	if(GALLERY_ROOT != "") $templatefile = GALLERY_ROOT . "sys/integrate.html";
	else $templatefile = "sys/" . $templatefile . ".html";
	if(!$fd = fopen($templatefile, "r"))
	{
		echo "Template $templatefile not found!";
		exit();
	}
	else
	{
		$template = fread ($fd, filesize ($templatefile));
		fclose ($fd);
		$template = stripslashes($template);
		$template = preg_replace("/<% title %>/", $title, $template);
		$template = preg_replace("/<% messages %>/", $messages, $template);
		$template = preg_replace("/<% gallery_root %>/", GALLERY_ROOT, $template);
		$template = preg_replace("/<% images %>/", "$images", $template);
		$template = preg_replace("/<% thumbnails %>/", "$thumbnails", $template);
		$template = preg_replace("/<% breadcrumb_navigation %>/", "$breadcrumb_navigation", $template);
		$template = preg_replace("/<% page_navigation %>/", "$page_navigation", $template);
		$template = preg_replace("/<% bgcolor %>/", "$backgroundcolor", $template);
		$template = preg_replace("/<% gallery_width %>/", "$gallery_width", $template);
		$template = preg_replace("/<% version %>/", "$version", $template);
		$template = preg_replace("/<% cplink %>/", "$cplink", $template);
		echo "$template";
	}
?>
