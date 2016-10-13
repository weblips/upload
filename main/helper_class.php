<?
include('browser_detection_php_ar.php');
class myclass{
public function convert_pdf_into_image_win()
   {
		
		
	    system(substr(__FILE__, 0, strlen(__FILE__) - strlen(strrchr(__FILE__,  '\\'))).'\gs5.exe -q -sDEVICE=jpeg -dBATCH -dNOPAUSE -dFirstPage='.(int)$_POST['pagenumber'].' -dLastPage='.(int)($_POST['pagenumber']+1).' -r150x150 -sOutputFile=./'.$_POST['pagenumber'].'.jpg ./'.$_FILES["file"]["name"].'');
		
		unlink($_FILES["file"]["name"]);
		
		

		

   }
   
public function convert_pdf_into_image_lin()
   {
		
		
	    system(substr(__FILE__, 0, strlen(__FILE__) - strlen(strrchr(__FILE__,  '/'))).'/gs5 -q -sDEVICE=jpeg -dBATCH -dNOPAUSE -dFirstPage='.(int)$_POST['pagenumber'].' -dLastPage='.(int)($_POST['pagenumber']+1).' -r150x150 -sOutputFile=./'.$_POST['pagenumber'].'.jpg ./'.$_FILES["file"]["name"].'');
		
		unlink($_FILES["file"]["name"]);
		
		

		

   }  
   
public function pdf2image()
         {
              
			  
			  if($_FILES["file"]["error"] > 0)
		       {
		  echo "Error: " . $_FILES["file"]["error"] . "<br />";
		       }
		   else
		      {
		  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		  echo "Type: " . $_FILES["file"]["type"] . "<br />";
		  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		  move_uploaded_file($_FILES["file"]["tmp_name"],"./" . $_FILES["file"]["name"]);
		     }
			  		 
if(browser_detection('os')=='nt')
{
$this->convert_pdf_into_image_win();

}else {$this->convert_pdf_into_image_lin();}    

   
   
}

}
$myobj=new myclass();

?>