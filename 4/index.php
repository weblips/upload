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
    if ($files[0]['error'] == 0){        // Проверяем размер 
        echo $files[0]['tmp_name'].'<br />'; 
    } 
} 
// Если файлов несколько 
elseif (count($files) > 1){ 
    $count = count($files); 
    // Обрабатываем файлы циклом 
    for ($sel = 0; $sel < $count; $sel++){        // Если файл залился без ошибок, обрабатываем 
        if ($files[$sel]['error'] == 0){ 
            echo $files[$sel]['tmp_name'].'<br />'; 
        } 
    } 
} 


?>
<html> 
<head> 
  <title>Мульти загрузка</title> 
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
    var previewWidth = 150, // ширина превью
        previewHeight = 150, // высота превью
        maxFileSize = 2 * 1024 * 1024, // (байт) Максимальный размер файла (2мб)
        selectedFiles = {},// объект, в котором будут храниться выбранные файлы
        queue = [],
        image = new Image(),
        imgLoadHandler,
        isProcessing = false,
        errorMsg, // сообщение об ошибке при валидации файла
        previewPhotoContainer = document.querySelector('#preview-photo'); // контейнер, в котором будут отображаться превью
 
    // Когда пользователь выбрал файлы, обрабатываем их
    $('input[type=file][id=photo]').on('change', function() {
        var newFiles = $(this)[0].files; // массив с выбранными файлами
 
        for (var i = 0; i < newFiles.length; i++) {
 
            var file = newFiles[i];
 
            // В качестве "ключей" в объекте selectedFiles используем названия файлов
            // чтобы пользователь не мог добавлять один и тот же файл
            // Если файл с текущим названием уже существует в массиве, переходим к следующему файлу
            if (selectedFiles[file.name] != undefined) continue;
 
            // Валидация файлов (проверяем формат и размер)
            if ( errorMsg = validateFile(file) ) {
                alert(errorMsg);
                return;
            }
 
            // Добавляем файл в объект selectedFiles
            selectedFiles[file.name] = file;
            queue.push(file);
 
        }
 
        $(this).val('');
        processQueue(); // запускаем процесс создания миниатюр
    });
 
    // Валидация выбранного файла (формат, размер)
    var validateFile = function(file)
    {
        if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
            return 'Фотография должна быть в формате jpg, png или gif';
        }
 
        if ( file.size > maxFileSize ) {
            return 'Размер фотографии не должен превышать 2 Мб';
        }
    };
 
    var listen = function(element, event, fn) {
        return element.addEventListener(event, fn, false);
    };
 
    // Создание миниатюры
    var processQueue = function()
    {
        // Миниатюры будут создаваться поочередно
        // чтобы в один момент времени не происходило создание нескольких миниатюр
        // проверяем запущен ли процесс
        if (isProcessing) { return; }
 
        // Если файлы в очереди закончились, завершаем процесс
        if (queue.length == 0) {
            isProcessing = false;
            return;
        }
 
        isProcessing = true;
 
        var file = queue.pop(); // Берем один файл из очереди
 
        var li = document.createElement('LI');
        var span = document.createElement('SPAN');
        var spanDel = document.createElement('SPAN');
        var canvas = document.createElement('CANVAS');
        var ctx = canvas.getContext('2d');
 
        span.setAttribute('class', 'img');
        spanDel.setAttribute('class', 'delete');
        spanDel.innerHTML = 'Удалить';
 
        li.appendChild(span);
        li.appendChild(spanDel);
        li.setAttribute('data-id', file.name);
 
        image.removeEventListener('load', imgLoadHandler, false);
 
        // создаем миниатюру
        imgLoadHandler = function() {
            ctx.drawImage(image, 0, 0, previewWidth, previewHeight);
            URL.revokeObjectURL(image.src);
            span.appendChild(canvas);
            isProcessing = false;
            setTimeout(processQueue, 200); // запускаем процесс создания миниатюры для следующего изображения
        };
 
        // Выводим миниатюру в контейнере previewPhotoContainer
        previewPhotoContainer.appendChild(li);
        listen(image, 'load', imgLoadHandler);
        image.src = URL.createObjectURL(file);
 
        // Сохраняем содержимое оригинального файла в base64 в отдельном поле формы
        // чтобы при отправке формы файл был передан на сервер
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
 
    // Удаление фотографии
    $(document).on('click', '#preview-photo li span.delete', function() {
        var fileId = $(this).parents('li').attr('data-id');
 
        if (selectedFiles[fileId] != undefined) delete selectedFiles[fileId]; // Удаляем файл из объекта selectedFiles
        $(this).parents('li').remove(); // Удаляем превью
        $('input[name^=photo][data-id="' + fileId + '"]').remove(); // Удаляем поле с содержимым файла
    });
 
</script>
<body> 
    <h1>Загрузка изображений:</h1>
<input type="button" value="Добавить картинку" onClick="addFile();"> 
<form action="" method="post" enctype="multipart/form-data"> 
<div id="multiUpload" style="display: block;"> 
</div> 
<div> 
<input type="submit" value="Загрузить"> 
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