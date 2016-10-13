<?php
session_start();
require('../sys/config.php');
$c=$_SERVER['HTTP_REFERER'];
$s=$_SERVER['HTTP_HOST'];
if(strstr($c,$s)==false)
{die('Page not found!');}
if ($c=='')
{die('Page not found!');}
$dir=$_GET['up'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
<meta http-equiv="content-type" content="text/html; charset=windows-1251"/>

<title>UPLOADER</title>

<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1" />

<!-- production -->
<script type="text/javascript" src="js/plupload.full.min.js"></script>

</head>
<body style="font: 14px Verdana; background: #fff; color: #333">

<center><h2><font color="#0000FF">Загрузить файлы</font></h2>
<fieldset>
<p><font color="#0000FF">Допустимые расширения: </font><font color="#FF0000"><?php echo $up_ext; ?></font></p>
<p><font color="#0000FF">Максимальный размер файла: </font> <font color="#FF0000"><?php echo $up_max; ?></font></p>
<p>В список загрузок можно добавлять сразу несколько файлов</p></center>
</fieldset>
<div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
<br />

<div id="container">
    <center><a id="pickfiles" href="javascript:;">[выбрать]</a> 
    <a id="uploadfiles" href="javascript:;">[загрузить]</a>
</center>
</div>

<br />
<pre id="console"></pre>


<script type="text/javascript">
// Custom example logic

var title = '1';
var counter = 1;

function cyr2lat(str) {
 
    var cyr2latChars = new Array(
['а', 'a'], ['б', 'b'], ['в', 'v'], ['г', 'g'],
['д', 'd'],  ['е', 'e'], ['ё', 'yo'], ['ж', 'zh'], ['з', 'z'],
['и', 'i'], ['й', 'y'], ['к', 'k'], ['л', 'l'],
['м', 'm'],  ['н', 'n'], ['о', 'o'], ['п', 'p'],  ['р', 'r'],
['с', 's'], ['т', 't'], ['у', 'u'], ['ф', 'f'],
['х', 'h'],  ['ц', 'c'], ['ч', 'ch'],['ш', 'sh'], ['щ', 'shch'],
['ъ', ''],  ['ы', 'y'], ['ь', ''],  ['э', 'e'], ['ю', 'yu'], ['я', 'ya'],
 
['А', 'A'], ['Б', 'B'],  ['В', 'V'], ['Г', 'G'],
['Д', 'D'], ['Е', 'E'], ['Ё', 'YO'],  ['Ж', 'ZH'], ['З', 'Z'],
['И', 'I'], ['Й', 'Y'],  ['К', 'K'], ['Л', 'L'],
['М', 'M'], ['Н', 'N'], ['О', 'O'],  ['П', 'P'],  ['Р', 'R'],
['С', 'S'], ['Т', 'T'],  ['У', 'U'], ['Ф', 'F'],
['Х', 'H'], ['Ц', 'C'], ['Ч', 'CH'], ['Ш', 'SH'], ['Щ', 'SHCH'],
['Ъ', ''],  ['Ы', 'Y'],
['Ь', ''],
['Э', 'E'],
['Ю', 'YU'],
['Я', 'YA'],
 
['a', 'a'], ['b', 'b'], ['c', 'c'], ['d', 'd'], ['e', 'e'],
['f', 'f'], ['g', 'g'], ['h', 'h'], ['i', 'i'], ['j', 'j'],
['k', 'k'], ['l', 'l'], ['m', 'm'], ['n', 'n'], ['o', 'o'],
['p', 'p'], ['q', 'q'], ['r', 'r'], ['s', 's'], ['t', 't'],
['u', 'u'], ['v', 'v'], ['w', 'w'], ['x', 'x'], ['y', 'y'],
['z', 'z'],
 
['A', 'A'], ['B', 'B'], ['C', 'C'], ['D', 'D'],['E', 'E'],
['F', 'F'],['G', 'G'],['H', 'H'],['I', 'I'],['J', 'J'],['K', 'K'],
['L', 'L'], ['M', 'M'], ['N', 'N'], ['O', 'O'],['P', 'P'],
['Q', 'Q'],['R', 'R'],['S', 'S'],['T', 'T'],['U', 'U'],['V', 'V'],
['W', 'W'], ['X', 'X'], ['Y', 'Y'], ['Z', 'Z'],
 
[' ', '-'],['0', '0'],['1', '1'],['2', '2'],['3', '3'],
['4', '4'],['5', '5'],['6', '6'],['7', '7'],['8', '8'],['9', '9'],
['-', '-'],['.', '.']
 
    );
 
    var newStr = new String();
 
    for (var i = 0; i < str.length; i++) {
 
        ch = str.charAt(i);
        var newCh = '';
 
        for (var j = 0; j < cyr2latChars.length; j++) {
            if (ch == cyr2latChars[j][0]) {
                newCh = cyr2latChars[j][1];
 
            }
        }
        newStr += newCh;
 
    }
    return newStr.replace(/[-]{2,}/gim, '-').replace(/\n/gim, '');
}

var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,html4',
	browse_button : 'pickfiles', // you can pass in id...
	container: document.getElementById('container'), // ... or DOM Element itself
	url : 'upload.php?dir=<?php echo $dir; ?>',
	chunk_size : '1mb',
flash_swf_url : 'js/Moxie.swf',
	preinit : attachCallbacks,
	filters : {
		max_file_size : '<?php echo $up_max; ?>',
		mime_types: [
			{title : "Image files", extensions : "<?php echo $up_ext; ?>"}
		]
	},

	init: {
		PostInit: function() {
			document.getElementById('filelist').innerHTML = '';
			document.getElementById('uploadfiles').onclick = function() {
				uploader.start();
				return false;
			};
		},

		FilesAdded: function(up, files) {
			plupload.each(files, function(file) {
file.name = cyr2lat(file.name);
title = file.name;
				document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';

			});
		},

		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";

},

		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});

uploader.init();

function attachCallbacks(uploader) {
uploader.bind('FileUploaded', function(Up, File, Response) {
    if( (uploader.total.uploaded + 1) == uploader.files.length)

         {window.location.href = "../"
}
          
    })
}

</script>
<center><a href="../">В галерею</a></center>
</body>
</html>
