<?


$uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/upload/';
$filePath  = $_FILES['myfile']['tmp_name'];
$errorCode = $_FILES['myfile']['error'];




// Проверим на ошибки
if ($errorCode !== UPLOAD_ERR_OK || !is_uploaded_file($filePath)) {

    // Массив с названиями ошибок
    $errorMessages = [
        UPLOAD_ERR_INI_SIZE   => 'Размер файла превысил значение PHP.',
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
    die($outputMessage);
}

// Создадим ресурс FileInfo
$fi = finfo_open(FILEINFO_MIME_TYPE);

// Получим MIME-тип
$mime = (string) finfo_file($fi, $filePath);

// Проверим ключевое слово image (image/jpeg, image/png и т. д.)
if (strpos($mime, 'image') === false) die('Можно загружать только изображения.');


// Результат функции запишем в переменную
$image = getimagesize($filePath);

// Сгенерируем расширение файла на основе типа картинки
$extension = image_type_to_extension($image[2]);



// Зададим ограничения для картинок
$limitBytes  = 1024 * 1024 * 5;

// Проверим нужные параметры
if (filesize($filePath) > $limitBytes) die('Размер изображения не должен превышать 5 Мбайт.');

/// Сгенерируем новое имя файла
$name = md5_file($filePath);

// Сократим .jpeg до .jpg
$format = str_replace('jpeg', 'jpg', $extension);

if (isset($_POST['upload'])){

    foreach ($errorCode as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $filePath[$key];
            $name = basename($filePath[$key]);
            move_uploaded_file($tmp_name, "$uploadPath/$name");
        }
    }

}



?>

<pre>
    <?
    var_dump($_FILES);
    ?>
</pre>
