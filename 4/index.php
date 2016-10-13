<?php 
if(is_array($_FILES)){ 
    $f_sel = 0; 
    while (list ($key, $value) = each ($_FILES)){ 
        if (gettype($value) == 'array'){ 
            while (list ($key_2, $value_2) = each ($value)){ 
                $files[$f_sel][$key_2] = $value_2; 
            } 
        } 
        $f_sel++; 
    } 
    @reset($_FILES); 
} 
if (count($files) == 1){ 
    if ($files[0]['error'] == 0){        // ��������� ������ 
        echo $files[0]['tmp_name'].'<br />'; 
    } 
} 
// ���� ������ ��������� 
elseif (count($files) > 1){ 
    $count = count($files); 
    // ������������ ����� ������ 
    for ($sel = 0; $sel < $count; $sel++){        // ���� ���� ������� ��� ������, ������������ 
        if ($files[$sel]['error'] == 0){ 
            echo $files[$sel]['tmp_name'].'<br />'; 
        } 
    } 
} 


?>
<html> 
<head> 
  <title>������ ��������</title> 
</head> 
<style type="text/css"> 

</style> 
<script type="text/javascript"> 
function addFile() { 
    var d = new Date(); 
    var span = newEl('span'); 
    span.id = d.getTime(); 
    span.style.display = 'block'; 
    var input = newEl('input'); 
    input.type = 'file'; 
    input.name = 'file'+d.getTime(); 
    span.appendChild(input); 
    var div = getEl('multiUpload'); 
    div.appendChild(span); 
} 

function newEl (type) { 
    return document.createElement(type); 
} 

function getEl (id) { 
    return document.getElementById(id); 
} 
</script> 
<script>
    var previewWidth = 150, // ������ ������
        previewHeight = 150, // ������ ������
        maxFileSize = 2 * 1024 * 1024, // (����) ������������ ������ ����� (2��)
        selectedFiles = {},// ������, � ������� ����� ��������� ��������� �����
        queue = [],
        image = new Image(),
        imgLoadHandler,
        isProcessing = false,
        errorMsg, // ��������� �� ������ ��� ��������� �����
        previewPhotoContainer = document.querySelector('#preview-photo'); // ���������, � ������� ����� ������������ ������
 
    // ����� ������������ ������ �����, ������������ ��
    $('input[type=file][id=photo]').on('change', function() {
        var newFiles = $(this)[0].files; // ������ � ���������� �������
 
        for (var i = 0; i < newFiles.length; i++) {
 
            var file = newFiles[i];
 
            // � �������� "������" � ������� selectedFiles ���������� �������� ������
            // ����� ������������ �� ��� ��������� ���� � ��� �� ����
            // ���� ���� � ������� ��������� ��� ���������� � �������, ��������� � ���������� �����
            if (selectedFiles[file.name] != undefined) continue;
 
            // ��������� ������ (��������� ������ � ������)
            if ( errorMsg = validateFile(file) ) {
                alert(errorMsg);
                return;
            }
 
            // ��������� ���� � ������ selectedFiles
            selectedFiles[file.name] = file;
            queue.push(file);
 
        }
 
        $(this).val('');
        processQueue(); // ��������� ������� �������� ��������
    });
 
    // ��������� ���������� ����� (������, ������)
    var validateFile = function(file)
    {
        if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
            return '���������� ������ ���� � ������� jpg, png ��� gif';
        }
 
        if ( file.size > maxFileSize ) {
            return '������ ���������� �� ������ ��������� 2 ��';
        }
    };
 
    var listen = function(element, event, fn) {
        return element.addEventListener(event, fn, false);
    };
 
    // �������� ���������
    var processQueue = function()
    {
        // ��������� ����� ����������� ����������
        // ����� � ���� ������ ������� �� ����������� �������� ���������� ��������
        // ��������� ������� �� �������
        if (isProcessing) { return; }
 
        // ���� ����� � ������� �����������, ��������� �������
        if (queue.length == 0) {
            isProcessing = false;
            return;
        }
 
        isProcessing = true;
 
        var file = queue.pop(); // ����� ���� ���� �� �������
 
        var li = document.createElement('LI');
        var span = document.createElement('SPAN');
        var spanDel = document.createElement('SPAN');
        var canvas = document.createElement('CANVAS');
        var ctx = canvas.getContext('2d');
 
        span.setAttribute('class', 'img');
        spanDel.setAttribute('class', 'delete');
        spanDel.innerHTML = '�������';
 
        li.appendChild(span);
        li.appendChild(spanDel);
        li.setAttribute('data-id', file.name);
 
        image.removeEventListener('load', imgLoadHandler, false);
 
        // ������� ���������
        imgLoadHandler = function() {
            ctx.drawImage(image, 0, 0, previewWidth, previewHeight);
            URL.revokeObjectURL(image.src);
            span.appendChild(canvas);
            isProcessing = false;
            setTimeout(processQueue, 200); // ��������� ������� �������� ��������� ��� ���������� �����������
        };
 
        // ������� ��������� � ���������� previewPhotoContainer
        previewPhotoContainer.appendChild(li);
        listen(image, 'load', imgLoadHandler);
        image.src = URL.createObjectURL(file);
 
        // ��������� ���������� ������������� ����� � base64 � ��������� ���� �����
        // ����� ��� �������� ����� ���� ��� ������� �� ������
        var fr = new FileReader();
        fr.readAsDataURL(file);
        fr.onload = (function (file) {
            return function (e) {
                $('#preview-photo').append(
                        '<input type="hidden" name="photos[]" value="' + e.target.result + '" data-id="' + file.name+ '">'
                );
            }
        }) (file);
    };
 
    // �������� ����������
    $(document).on('click', '#preview-photo li span.delete', function() {
        var fileId = $(this).parents('li').attr('data-id');
 
        if (selectedFiles[fileId] != undefined) delete selectedFiles[fileId]; // ������� ���� �� ������� selectedFiles
        $(this).parents('li').remove(); // ������� ������
        $('input[name^=photo][data-id="' + fileId + '"]').remove(); // ������� ���� � ���������� �����
    });
 
</script>
<body> 
    <h1>�������� �����������:</h1>
<input type="button" value="�������� ��������" onClick="addFile();"> 
<form action="" method="post" enctype="multipart/form-data"> 
<div id="multiUpload" style="display: block;"> 
</div> 
<div> 
<input type="submit" value="���������"> 
</div> 
</form>
 <div>
        <ul id="preview-photo">
            <?php echo '<img src="">'?>
        </ul>
    </div>

<script type="text/javascript">addFile();</script> 
</body> 
</html> 