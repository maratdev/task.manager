<?php
session_name('session_id');
session_start();

if (!isset($_SESSION['user']['login'])){
    header("Location: /?login=yes");
}

include ''.$_SERVER['DOCUMENT_ROOT'].'/include/function.php';
include ''.$_SERVER['DOCUMENT_ROOT'].'/include/login_form.php';
include ''.$_SERVER['DOCUMENT_ROOT'].'/include/catalog.php';

$users = getUserOnId($_GET['to']);
$usersTo =  $_SESSION['user']['login'];
$usersEmailTo =  $_SESSION['user']['email'];
$from = getIdOnLogin($_SESSION['user']['login']); //от

$resModeration = mysqli_query($link,"SELECT * FROM messages WHERE froms= '$from' AND read_msg = '1'");
if (mysqli_num_rows($resModeration) > 0){
    $ModTrue = false;
}else{
    $ModTrue = true;
}

if (!empty($_POST['message']) and !empty($_POST['category']) and $ModTrue == true){
        $message = $_POST['message'];
        $header = $_POST['header'];
        $to = $_POST['to']; // кому
        $category = $_POST['category'];
        $read_msg = 1; // Не прочитано
        addMessage($from, $to, $header, $message, $category, $read_msg);
        $_SESSION['pm'] = 1;
    }

//echo "Отправка от ".$_SESSION['user']['login']."!"; // Для отладки от какого логина исходит сообщения и передается ли ссесия
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../styles.css" rel="stylesheet" />
    <title>Отправка сообщений</title>
</head>
<body>
<?php
if($_SESSION['user']['status'] != 1): ?>
<form action="add.php?to=<?=$_GET['to']?>" method="POST" >
    <p style="color: #fff"><?=($_SESSION['pm'] == 1 ? 'Ваше собщение отправлено!' : 'Вы вели не все значения!'); unset($_SESSION['pm'])?></p>
    <h2 style="color: #fff">Отправка сообщения пользователю «<?= $users['login']?>»</h2>
    <h3 style="color: #fff">Заголовок письма !</h3>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <select name="category">
            <option value="0">Выберите категорию</option>
            <?
            $result = get_cat();
            view_cat($result);
            ?>
        </select>
        <p><input type="text" name="header" placeholder="Заголовок письма"></p>
        <p><textarea rows="10" cols="45" name="message" placeholder="Введите сообщение" ></textarea></p>
        <p><input type="hidden" name="to" value="<?=$_GET['to']?>"></p>
        <p><input type="submit" name="smessage" value="Отправить"></p>
    </table>
</form>
<?php else:  ?>
    <form action="add.php?to=<?=$_GET['to']?>" method="POST" >
        <p style="color: #fff"><?=$_POST['smessage'] == 'Отправить'  ? 'Ваше собщение отправлено!' : ''; unset($_SESSION['pm'])?><?=$ModTrue == true  ? '' : ' Ваше заявка на модерации!';?></p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <p> <input type="text" disabled value="<?=$usersTo?>" placeholder="<?=$usersTo?>"></p>
            <p><input type="hidden" name="category" value="9"></p>
            <p><input type="hidden" name="header" value="Модерация"></p>
            <p><textarea hidden rows="10" cols="45" name="message" placeholder="" >Ник: <b><?=$usersTo?> </b> Почта: <b><?=$usersEmailTo?> </b></textarea></p>
            <p><input type="hidden" name="to" value="<?=$_GET['to']?>"></p>
            <p><input type="submit" <?=$ModTrue != true  ? 'disabled' : ''; ?> name="smessage" value="Отправить"></p>
        </table>
    </form>
<?php endif;  ?>
<br>
<a style="color: #fff" href="/">Назад</a>
</body>
</html>
