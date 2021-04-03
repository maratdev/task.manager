<?php
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.cookie_lifetime', 0);
session_set_cookie_params(0);
session_name('session_id');
session_start();


if (!isset($_SESSION['user']['login'])){
    header("Location: /");
}

include $_SERVER['DOCUMENT_ROOT'].'/include/function.php';
include $_SERVER['DOCUMENT_ROOT'].'/include/catalog.php';


if ($_GET['read']) {
    $cat = $_GET['category'];
    $id = $_GET['read'];

    mysqli_query(getConnection(), "UPDATE messages SET `read` = '0' WHERE id = '$id'"); // 0 прочитано
    header("Location: ?category=".$cat);
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="../styles.css" rel="stylesheet" />
    <title>Все сообщения!</title>
</head>
<body>

<?php include '../templates/header.php' ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">

            <br>
            <div class="category_menu">
                <ul class="category">
                    <?= $categories_menu;?>
                </ul>
                <hr>
                    <p> <?= $breadcrumbs;?></p>
                <br>
                <div class='side-bar' style='width: 450px; padding: 10px; border: 1px solid cadetblue'>
                    <?php if(!empty($my_messages)):?>
                        <?php foreach($my_messages as $message):?>
                            <?php if($id  == $message['category_id']): ?>
                                    <?php $sections = getSectionOnId($message['category_id']); ?>
                                    <?php $users = getIdOnUsers($message['from']); ?>
                                <br><br>
                                    <div class='full_name'>От кого: <?=$users['email']?></div>
                                    <div class='header'>Заголовок: <a class="<?=$message['read'] == 0 ? 'inactiveLink' : '' ?>"  href="?category=<?=$sections['id']?>&read=<?=$message[0]?>"> <?=$message['header']?></a></div>
                                    <div class='status_msg'>Статус: <?=$message['read'] == 1 ? '<b style="color: #e37400">Не прочитано</b>' : '<span style="color:#009900 ">Прочитано</span>' ?></div>

                                <?php if($message['read'] == 0): ?>
                                    <div class='message'><b>Сообщение:</b> <i><?=$message['text']?></i></div>
                                    <div class='date'><pre>Дата отправки: <?=date('Y-m-d H:i:s', $message['date']);?></pre></div>
                                    <div class='section'><pre>Раздел: <?=$sections['title']?></pre></div>
                                    <a href="add.php?to=<?=$users["id"]?>">Ответить</a>
                                    <?= $_SESSION['user']['status'] == 10  ? '<a style="margin-left: 5px" href="../include/passwords.php">Модерация</a><br>' : ''?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                   <?php endif;  ?>
                    <?= (isset($mess) ? 'Нет сообщений!' : '');?>
                </div>
            </div>
            <a  href="/">Назад</a>
        </td>
    </tr>
</table>

<?php include '../templates/footer.php' ?>
<script>
    $(document).ready(function () {
    $(".category").dcAccordion()
    });
</script>
</body>
</html>



