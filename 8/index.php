<html>
<head>
<link href='http://netdna.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css' rel='stylesheet'/>
</head>
<body>
	<div class="container" style="padding-top: 50px;">
		<h3>Загрузка файлов:</h3>
		<hr />
                <?php
		  
		  $files = glob("images/*.*");
                  echo '<div class="image_align row">';
for ($i=0; $i<count($files); $i++)
{
	$num = $files[$i];
        $info = getimagesize( $num );
	
	echo '	<div class="myimage col-md-3">
                    <a href="'.$num.'" rel="shadowbox"><img alt="placeholder" height="98" src="'.$num.'" width="130"> </a>
                </div>
                                             
';
        echo '</div>';
}
?>
		<form method="post" id="form" class="form-inline" enctype="multipart/form-data">
				<div class="form-group">
					<input type="file" multiple class="btn btn-primary" />
				</div>
				<div class="form-group">
				<label for="project_name">Имя папки:</label>
					<input type="text" class="form-control" id="project_name" />
				</div>
				<div class="form-group">
					<button type="button" id="btn" class="btn btn-primary" disabled><span class="glyphicon glyphicon-save"></span></button>
				</div>
				<div class="form-group">
					Images: <span class="badge count-images">0</span>
				</div>
		</form>
		<hr />
		<!-- Показываем превью -->
		<div id="upload-preview"></div>
	</div>
<!-- скрипты -->
<script src='http://code.jquery.com/jquery.js'></script>
<script src='http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
<!-- jQuery Plugin - upload multiple images ajax -->
<script src='js/uploadImages.js'></script>
<script>
$(function(){

/* Check File API compatibility */	
if (!$.fileReader()){
	alert("File API is not supported on your browser");
}
else{
	console.log("File API is supported on your browser");
}

/* createImage Event */
$(document).on("createImage", function(e){
	console.log(e.file.name);
	console.log(e.file.size);
	console.log(e.file.type);
});

/* deleteImage Event */
$(document).on("deleteImage", function(e){
	console.log(e.file.name);
	console.log(e.file.size);
	console.log(e.file.type);
	/* if not there are images, the button is disabled */
	if ($("#upload-preview").countImages() == 0)
	{
		$("#btn").attr("disabled", "disabled");
	}
});
	
/* Prevent form submit */
$("#form").on("submit", function(e){
	e.preventDefault();
});
	
/* Preview and Validate */
$("#form input[type='file']").on("change", function(){
	
	$("#upload-preview").uploadImagesPreview("#form", 
	{
		image_type: "jpg|jpeg|png|gif",
		min_size: 24,
		max_size: (1024*1024*3), /* 3 Mb */
		max_files: 10
	}, function(){
		switch(__errors__upload__) /* Check the possibles erros */
		{
			case 'ERROR_CONTENT_TYPE': alert("Error content type"); break;
			case 'ERROR_MIN_SIZE': alert("Error min size"); break;
			case 'ERROR_MAX_SIZE': alert("Error max size"); break;
			case 'ERROR_MAX_FILES': alert("Error max files"); break;
			default: $("#btn").removeAttr("disabled"); break; /* Activate the button Form */
		}
	});
});

/* Send form */
$("#btn").on("click", function(){
	
	/*images are required */
	if ($("#upload-preview").countImages() > 0)
	{
		$("#upload-preview").uploadImagesAjax("ajax.php", {
			params: {project_name: $("#project_name").val()}, /* Set the extra parameters here */
			beforeSend: function(){console.log("Sending ...");},
			success: function(data){$("#upload-preview").html(data); $("#form").fadeOut();},
			error: function(e){console.log(e.status);console.log(e.statusText);},
			complete: function(){console.log("Completed");}
		});
	}
	else{ // The button is not activated
		$(this).attr("disabled", "disabled");
	}
});
});
</script>

<style>
.img-responsive{
	max-width: 150px;
}
</style>
</body>
</html>