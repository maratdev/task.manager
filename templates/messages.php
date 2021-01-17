<?php
session_name('session_id');
session_start();

include_once '../include/function.php';
include_once '../include/login_form.php';


$users = getUserOnId($_GET['to']);
if (isset($_POST['message'])){
    $message = $_POST['message'];
    $to = $_POST['to']; // от кого
    $from = getIdOnLogin($_SESSION['user']['login']); //кому
    addMessage($from, $to, $message);
    $_SESSION['pm'] = 1;
}
echo "Отправка от ".$_SESSION['user']['login']."!"; // Для отладки от каго логина исходит сообщения и передается ли ссесия
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
<form action="messages.php?to=<?=$_GET['to']?>" method="POST" >
    <h2 style="color: #fff">Отправка сообщения пользователю <?= $users['login']?> !</h2>
    <p style="color: #fff"><?=($_SESSION['pm'] == 1 ? 'Ваше собщение отправлено!' : ''); unset($_SESSION['pm'])?></p>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <p><textarea rows="10" cols="45" name="message"></textarea></p>
        <p><input type="hidden" name="to" value="<?=$_GET['to']?>"></p>
        <p><input type="submit" name="smessage" value="Отправить"></p>
    </table>
</form>
<a style="color: #fff" href="/">Назад</a>
</body>
</html>
