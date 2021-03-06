<?php
const MAX_FILE_SIZE = 5240000;
const MAX_FILE_UPLOADS = 5;
const UPLOAD_MAX_FILESIZE = 5;


$dir = 'upload';
$files = array_diff(scandir($dir), ['..','.']);

//Удаление файлов
if (!empty($_POST['delete_file'])){
    foreach ($_POST['delete_file'] as $key){
        if (file_exists($key)) {
            unlink($key);
        }
    }
}

//Время загрузки
if ($handle = opendir($dir.'/')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            //echo "$entry | ";
            $date_img= date("m.d.y H:i:s.",filectime($dir.'/'.$entry));
        } }
    closedir($handle);
}

// Валидация файла проверка на ошибки при загрузке
function outputMessage($filePath){
    // Проверим на ошибки
    if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) {
        // Массив с названиями ошибок
        $errorMessages = [
            UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение '. UPLOAD_MAX_FILESIZE.' в конфигурации PHP.',
            UPLOAD_ERR_FORM_SIZE  => 'Размер загружаемого файла превысил значение 5Mb .',
            UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
            UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
            UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
            UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
            UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',
        ];
        // Зададим неизвестную ошибку
        $unknownMessage = 'При загрузке файла произошла неизвестная ошибка.';
        // Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
        $outputMessage = isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $unknownMessage;
        // Выведем название ошибки
        //die($outputMessage);
        }
        return $outputMessage;
}

if (is_dir($dir)){

    // Отображать размер
function getFilesize($file){
    // ошибка
    if(!file_exists($file)) return "Файл не найден";

    $filesize = filesize($file);
    // Если размер больше 10 Кб
    if($filesize > 10024) {
        $filesize = ($filesize/1024);
        // Если размер файла больше Килобайта
        // то лучше отобразить его в Мегабайтах. Пересчитываем в Мб
        if($filesize > 1024) {
            $filesize = ($filesize/1024);
            // А уж если файл больше 1 Мегабайта, то проверяем
            // Не больше ли он 1 Гигабайта
            if($filesize > 1024) {
                $filesize = ($filesize/1024);
                $filesize = round($filesize, 1);
                return $filesize." GB";
            }
            else {
                $filesize = round($filesize, 1);
                return $filesize." Mb";
            }
        }
        else {
            $filesize = round($filesize, 1);
            return $filesize." Kb";
        }
    }
    else {
        $filesize = round($filesize, 1);
        return $filesize." b";
    }
}
}else {

    mkdir('upload');
}

//Максимальное размер загружаеммых файлов Jquery
function formatSizeUnits($bytes)
{
    if ($bytes >= 1073741824)
    {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    }
    elseif ($bytes >= 1048576)
    {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    }
    elseif ($bytes >= 1024)
    {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    }
    elseif ($bytes > 1)
    {
        $bytes = $bytes . ' bytes';
    }
    elseif ($bytes == 1)
    {
        $bytes = $bytes . ' byte';
    }
    else
    {
        $bytes = '0 bytes';
    }

    return $bytes;
}

//Максимальное колличество загружаемых файлов
function maxFileUploads(){
    ini_set('max_file_uploads', MAX_FILE_UPLOADS);
    return "Максимальное колличество загружаемых файлов: ". ini_get('max_file_uploads');

}

//Максимальный размер загружаемых файлов
function maxSizeUploads(){
    ini_set('post_max_size', MAX_FILE_SIZE);
    return "Максимальный размер загружаемых файлов: ". ini_get('post_max_size');

}

//Выборка разрешенных файлов для загрузки
$mimeTypes = ['jpg', 'png', 'jpeg'];

function mimeTypes($mimeTypes){
    //Выборка файлов FORM
    foreach($mimeTypes as $value) {
        $resultStr[] = 'image/'.$value;
    }
    return implode(', ', $resultStr);
}

//Ширина и высота файла для отображение на странице
function widHeiSize($files, $mimeTypes, $dir){

    foreach($files as $key=>$val) {
        if($val != "." && $val != "..") {
            $pieces = explode(".", $val);
        }
        if(in_array(isset($pieces), $mimeTypes)){
            if (!empty($files && file_exists($dir.'/'.$val))){
                list($width, $height) = getimagesize($dir.'/'.$val);

                if($width>$height) {
                    $image = 'height = "200"';

                }
                else {
                    $image = 'width = "200"';
                }
            }
        }
    }
    return $image;
}







