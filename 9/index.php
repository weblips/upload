<?php
/**
*	powered by @cafewebmaster.com
*	free for private use
*	please donate by paypal or give a backlink
*/

	
	$album_name 	= "Photo Album / Picture Gallery with PHP"; // title (description below)
	$album_desc 	= "This a small -all-in-one-file- but powerful photo gallery script with most needed features like display image filesize, dimensions and sort by name, size, lastmodified time. Create thumbnail images dynamically on the fly, showing pager, total images etc..."; 

	
	$album_width 	= 600; // width in pixels
	$thumb_width 	= 120; // width of thumbnail images
	$thumb_height 	= 80; // height of thumbnail images
	
	$pp = 12; //display how many pictures per page
	
	
	
######################## You dont need to edit below ##########################
	
	
	$start = $_GET[start] ? $_GET[start] : 0 ;
	
	$sortby = $_COOKIE[sortby] ? $_COOKIE[sortby] : "name" ;
	if($_GET[sortby]){
		$sortby = $_GET[sortby];
		setcookie("sortby", $_GET[sortby], time()+86400 );
		header("location: index.php");
	}
	
	
	
	
	$od = opendir("./");
	while($file = readdir($od)){
		if( eregi("\.(gif|jpe?g|png)$", $file) ){
			$file2 = rawurlencode($file);
			$img_arr[$file2] 			= $file;
			$img_arr_filesize[$file2] 	= filesize($file);
			$img_arr_filemtime[$file2] 	= filemtime($file);
			
			list($imagex, $imagey, $type, $attr) = getimagesize($file);
			$img_arr_sizexy[$file2] 	= $imagex."x".$imagey;
		}
	}
	
	
	
	asort($img_arr);
	asort($img_arr_filesize);
	asort($img_arr_filemtime);
	
	
	switch($sortby){
		case "time":
			$img_arr_final = $img_arr_filemtime;
			break;
	
		case "size":
			$img_arr_final = $img_arr_filesize;
			break;
		
		case "name":
			$img_arr_final = $img_arr;
			break;
	}
	
	$total_images = count($img_arr_final);

	foreach($img_arr_final as $k=>$v){
		$i++;
		if($i < $start+1) continue;
		if($i > $start + $pp) break;
		
		$img_name = strlen($img_arr[$k]) > 18 ? substr($img_arr[$k],0,16)."..." :$img_arr[$k];
		
		$alt = $img_arr[$k] . " -|- Last modified: " . date("Y-m-d H:i:s", $img_arr_filemtime[$k]) . " ";
		
		$imgl .= "<div class=\"img_thumb\"><a href=\"$k\"><img src=\"index.php?thumb=$k\" alt=\"$alt\" title=\"$alt\" /></a><p title=\"".$img_arr[$k]."\"><strong>".$img_name."</strong><br /><span class=\"mini\">".$img_arr_sizexy[$k].", ".round(($img_arr_filesize[$k]/1024))." KB</span></p></div>";
		
		
	}

	
	
	
	for($p=0; $p*$pp <  $total_images ; $p++){
		$active = ($p*$pp) == $start ? "active" : "" ;
		$page_htmo .= "<a href=\"index.php?start=".($p*$pp)."\" class=\"$active pages\">".($p+1)."</a> ";
	}
	
	

	$arr_sortby = array("name"=>"Name", "size"=>"Size", "time"=>"Time");	
	
	foreach($arr_sortby as $k=>$v){

		if($sortby == $k){
			$sortby_html[] = "<strong>$v</strong>";
		} else {
			$sortby_html[] = "<a href=\"index.php?sortby=$k\">$v</a>";
		}
		
	}	
	
	$sortby_htmo = implode(" | ", $sortby_html);
	
	
	
	
	
	
		
function make_thumbnail($updir, $img){
	global $thumb_width, $thumb_height;

	$thumbnail_width	= $thumb_width ? $thumb_width : 120;
	$thumbnail_height	= $thumb_height ? $thumb_height : 80;

	$arr_image_details	= GetImageSize("$updir"."$img");
	$original_width		= $arr_image_details[0];
	$original_height	= $arr_image_details[1];

	if( $original_width > $original_height ){
		$new_width	= $thumbnail_width;
		$new_height	= intval($original_height*$new_width/$original_width);
	} else {
		$new_height	= $thumbnail_height;
		$new_width	= intval($original_width*$new_height/$original_height);
	}

	$dest_x = intval(($thumbnail_width - $new_width) / 2);
	$dest_y = intval(($thumbnail_height - $new_height) / 2);



	if($arr_image_details[2]==1) { $imgt = "ImageGIF"; $imgcreatefrom = "ImageCreateFromGIF"; $imgx = "gif"; }
	if($arr_image_details[2]==2) { $imgt = "ImageJPEG"; $imgcreatefrom = "ImageCreateFromJPEG"; $imgx = "jpeg"; }
	if($arr_image_details[2]==3) { $imgt = "ImagePNG"; $imgcreatefrom = "ImageCreateFromPNG";  $imgx = "png"; }


	if( $imgt ) { 
		$old_image	= $imgcreatefrom("$updir"."$img");
		$new_image	= ImageCreateTrueColor($thumbnail_width, $thumbnail_height);
		imageCopyResized($new_image,$old_image,$dest_x, 		
		$dest_y,0,0,$new_width,$new_height,$original_width,$original_height);
		
		
		header("Content-Type: image/jpeg"); imagejpeg($new_image, NULL, 80);
	}

}

if($_GET['thumb']) { 
 if( in_array($_GET['thumb'], $img_arr) ) make_thumbnail("./", $_GET['thumb']); // against file inclusion
 exit(); 
}
	
	
$footer = '<a id="cw" href="http://www.cafewebmaster.com" title="Powered by Cafe Webmaster : Resources for Web developers" style="text-decoration: none; background-color: none; border: none;">&#169;</a>';
	
	
$css_album_width = $album_width."px";	
$css_thumb_width = $thumb_width."px";
$css_thumb_height = $thumb_height."px";	
	
	
	
echo <<<cafewebmaster_com
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<title>$album_name</title>
		<meta name="description" content="$album_desc" />
		<style type="text/css">
			#cw_image_gallery { width: $css_album_width; margin: auto; font: 12px verdana; text-decoration: none;  }
			#cw_image_gallery img { width: $css_thumb_width;  height: $css_thumb_height; border: 3px solid #033; }
			#sortby { text-align: right;  border-bottom: 1px solid #abc; padding: 10px; clear: both; }
			#pagenav { text-align: right; border-top: 1px solid #abc; padding: 10px; clear: both; }
			#pagenav a.pages { padding: 2px 5px; text-decoration: none; border: 1px solid #abc; background-color: #cde; }
			#pagenav a.pages:hover, #pagenav a.active { background-color: #036; color: #fff; }
			.img_thumb { float: left; text-align: center; font: 10px verdana; margin: 10px; }
			.img_thumb p, #cw_image_gallery.img_thumb a { margin: 0; padding: 0;}
			.mini { font: 9px verdana; }
		</style>
	</head>
	<body>

	<div id="cw_image_gallery">
		<h1>$album_name</h1>
		<p>$album_desc</p>
		<div id="sortby">Sort by: $sortby_htmo</div>
		$imgl
		<div id="pagenav">Total Images: <strong>$total_images</strong> | $footer | Page: $page_htmo</div>
		
	</div>

	</body></html>
cafewebmaster_com;


