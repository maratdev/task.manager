<?php
error_reporting(E_ALL);
require_once $_SERVER['DOCUMENT_ROOT']."/gallery/function.php";

if(isset($_POST['delete_file'])){
    header('Location: '.$_SERVER['REQUEST_URI']);
}

?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="//malsup.github.io/min/jquery.form.min.js"></script>
    <link href="/styles.css" rel="stylesheet" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Cache-Control" content="no-cache">
    <title>Gallery</title>
</head>
<body>
<h2>Галерея</h2>
<div class="infoMsgFile">
    <a href="index.php">Венрнуться обратно</a>
</div>

<form method="post">
<div class="flex">
    <?php foreach($files as $key=>$val): ?>
    <div class="flex-itm">
        <img <?=widHeiSize($files, $mimeTypes, $dir)?> src='<?= $dir.'/'.$val ?>' >
        <br>
        <i class='date_img'><?= $date_img?></i><br>
        <i class='getFilesize'><?= getFilesize($dir.'/'.$val)?> </i><br>
        <i class='getFilesize'><?= $val?> </i><br>
        <input  type="checkbox" name="delete_file[]" value="<?= $dir.'/'.$val ?>">Удалить<br>
    </div>
    <?php endforeach; ?>
</div>
    <i class="infoMsgFile"><?php
        if (empty(glob($dir."/*.*"))) {echo 'В каталоге нет фото!<br>';
        }else{echo '<input type="submit" value="Удалить"  >';
        }
        ?>
    </i>

</form>



</body>
</html>
