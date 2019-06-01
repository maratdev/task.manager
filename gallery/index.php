<?
//ini_set("upload_max_filesize", "5M");
//ini_set("post_max_size", "5M");
//ini_set("max_file_uploads", "5");
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form enctype="multipart/form-data" method="post" action="upload.php">
    <input name="myfile[]" type="file" multiple="multiple"/>
    <input type="submit" name="upload" value="Загрузить" />
</form>
</body>
</html>