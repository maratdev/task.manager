<?php
if(isset($_POST['delete_file'])){
    header('Location: '.$_SERVER['REQUEST_URI']);
}
require_once $_SERVER['DOCUMENT_ROOT']."/gallery/function.php";

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="//malsup.github.io/min/jquery.form.min.js"></script>
    <link href="/styles.css" rel="stylesheet" />
    <script type="text/javascript">
        jQuery(document).ready(function($) {
        // Проверка на максимальный размер файла
            $('#js-file').bind('change',function() {
                if(this.files[0].size > <?= MAX_FILE_SIZE ?>)//
                {
                    alert("Максимлаьный размер файлов для разовой нагрузки: <?= formatSizeUnits(MAX_FILE_SIZE) ?>. Вы выбрали: " + Math.trunc((this.files[0].size/1024/1024)*100)/100+" MB"+ " файлов. Пожалуйста повторите попытку.");
                    return false;
                }
            });
        // Проверка на максимальное количество файлов
            $('#btn').click(function(){
                var count = $('#js-file')[0].files.length;
                if(count > <?= MAX_FILE_UPLOADS?>)//
                {
                    alert("Максимлаьно количество файлов для разовой нагрузки: <?= MAX_FILE_UPLOADS?>. Вы выбрали: " + $('#js-file')[0].files.length + " файлов. Пожалуйста повторите попытку.");
                    return false;
                }
            });

            $('#js-form').submit(function(){
                var in_file= $("#js-file").val();
                if(in_file==""){
                    alert("Вы не выбрали файл");
                    return false;
                }
                else{
                    return true;
                }
        });

        });
    </script>

    <script>
        $('#js-file').change(function() {
            $('#js-form').ajaxSubmit({
                type: 'POST',
                url: '/upload.php',
                cache       : false,
                target: '#result',
                success: function() {
                    // После загрузки файла очистим форму.
                    $('#js-form')[0].reset();
                },
            });
        });
    </script>

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache">
    <title>Upload Gallery</title>
</head>
<body>
<div class="infoMsgFile">
   <?= maxFileUploads();?><br>
   <?= maxSizeUploads();?>
</div>
<form id="js-form" enctype="multipart/form-data" method="post" action="upload.php">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?= MAX_FILE_SIZE?>">
    <input id="js-file" name="upload[]" type="file" multiple="multiple" accept="<?= mimeTypes($mimeTypes);?>"/>
    <input id="btn" class="btn_submit disabled" type="submit"  value="Загрузить" />

</form>
</body>
</html>
