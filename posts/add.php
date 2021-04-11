<?php
session_name('session_id');
session_start();
ob_start();

include $_SERVER['DOCUMENT_ROOT'].'/include/function.php';
include $_SERVER['DOCUMENT_ROOT'].'/include/login_form.php';
include $_SERVER['DOCUMENT_ROOT'].'/include/catalog.php';

$from = getUserOnId($_SESSION['user']['id']); //от

if (!isset($_SESSION['user']['login'])) {
    header("Location: /?login=yes");
}

if (isset($_POST['smessage1'])){
    $path = strtok($_SERVER["REQUEST_URI"], '#');
    header("Location: ".$path);
}

//$users = getUserOnId($_GET['to']);
$usersTo =  $_SESSION['user']['login'];
$usersEmailTo =  $_SESSION['user']['email'];



    if (!empty($_POST['message']) and !empty($_POST['category'])){
        $text = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['message'])));
        $header = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['header'])));
        if ($_POST['to_user']){
            $to = strip_tags(trim($_POST['to_user'])); // кому
        }elseif ($_POST['to']){
            $to = strip_tags(trim($_POST['to'])); // кому
        }

        $category = strip_tags(trim($_POST['category']));
        $read = 1; // Не прочитано
        addMessage($from['id'], $to, $header, $text, $category, $read);
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
    <link href="/styles.css" rel="stylesheet" />
    <title>Отправка сообщений</title>
</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'].'/templates/header.php' ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">
<h2>Отправка сообщения</h2>
<p><?=(isset($_SESSION['pm']) && $_SESSION['pm'] == 1 ? 'Ваше собщение отправлено!' : 'Вы вели не все значения!'); unset($_SESSION['pm'])?></p>

<?php if ((isset($_SESSION['user']['status']) and $_SESSION['user']['status'] == 2) or (isset($_SESSION['user']['status'])  and $_SESSION['user']['status'] == 10)):  // Пользователь имеющий право писать сообщения (2) ?>

    <!--  // Вывод всех зарегистрированых пользователей и отправка сообщений -->
    <?php if (isset($_SESSION['user']['login'])):
        $login = $_SESSION['user']['login'];
        $resultAll = mysqli_query(getConnection(), "SELECT * FROM users WHERE login != '$login' && status !='1' ");
        ?>
        <?php if($resultAll): ?>
        <form action="" method="POST">
        <select name="to_user">
            <option value="0">Выберите пользователя</option>
            <?php while ($result = mysqli_fetch_assoc($resultAll)): ?>
                <option value="<?=$result['id']?>"><?=$result['login']?></option>
            <?php endwhile;?>
        </select>
        <?php endif;?>
    <?php endif;?>

    <select name="category">
            <option value="0">Выберите категорию</option>
            <?php
            $result = get_cat();
            view_cat($result);
            ?>
    </select>
        <p><input type="text" name="header" placeholder="Заголовок письма"></p>
        <p><textarea rows="10" cols="45" name="message" placeholder="Введите сообщение" ></textarea></p>
        <p><input type="submit" name="smessage" value="Отправить"></p>

</form>

<?php else: ?>
    <form action="add.php?to=<?=$_GET['to']?>" method="POST" >
        <p><?= !empty($_POST['smessage'])  ? 'Ваше собщение отправлено!' : ''; unset($_SESSION['pm'])?>  <?= resModeration($from['id']) == true  ? '' : 'Ваше заявка на модерации!' ?></p>
            <p> <input type="text" disabled value="<?=$usersTo?>" placeholder="<?=$usersTo?>"></p>
            <p><input type="hidden" name="category" value="9"></p>
            <p><input type="hidden" name="header" value="Модерация"></p>
            <p><textarea hidden rows="10" cols="45" name="message" placeholder="" >Ник: <b><?=$usersTo?> </b> Почта: <b><?=$usersEmailTo?> </b></textarea></p>
            <p><input type="hidden" name="to" value="<?=$_GET['to']?>"></p>
            <p><input type="submit" <?= resModeration($from['id']) != true  ? 'disabled' : ''; ?> name="smessage1" value="Отправить"></p>
    </form>

    <?if (resModeration($from['id']) == true){
        echo '';
    }else{
        header("Location: /?login=yes");
    } ?>
<?php endif;  ?>
<br>
<a href="/">Назад</a>
        </td>
    </tr>
</table>
<?php include $_SERVER['DOCUMENT_ROOT'].'/templates/footer.php'; ?>
</body>
</html>
