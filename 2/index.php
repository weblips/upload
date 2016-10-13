<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Multiple Images Upload Using jQuery, Ajax and PHP by CodexWorld</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="jquery.form.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#images').on('change',function(){
		$('#multiple_upload_form').ajaxForm({
			target:'#images_preview',
			beforeSubmit:function(e){
				$('.uploading').show();
			},
			success:function(e){
				$('.uploading').hide();
			},
			error:function(e){
			}
		}).submit();
	});
});
</script>
</head>

<body>
<div style="margin-top:50px;">
	<div class="upload_div">
    <form name="multiple_upload_form" id="multiple_upload_form" enctype="multipart/form-data" action="upload.php">
    	<input type="hidden" name="image_form_submit" value="1"/>
            <label>Choose Image</label>
            <input type="file" name="images[]" id="images" multiple >
        <div class="uploading none">
            <label>&nbsp;</label>
            <img src="uploading.gif"/>
        </div>
    </form>
    </div>
	
    <div class="gallery" id="images_preview">
        
    </div>
</div>
</body>
</html>
