<?php
session_name('session_id');
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/include/function.php';
include $_SERVER['DOCUMENT_ROOT'].'/include/login_form.php';
include $_SERVER['DOCUMENT_ROOT'].'/include/catalog.php';

$from_user = getUserOnId($_SESSION['user']['id']);
$result_set = mysqli_query(getConnection(),"SELECT * FROM messages WHERE tos = '{$from_user['id']}' AND `read` = '1' ORDER BY id LIMIT 1 ");

$arr = [];
while ($row = mysqli_fetch_assoc($result_set)){
    $arr[] = $row;
}

//echo '<pre>';
//print_r($arr);
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
            <h2>Последнее входящее сообщение </h2>
            <?php foreach ($arr as $mess): ?>
                <div class='message'><b>Заголовок:</b> <i><?=$mess['header']?></i></div>
                <div class='message'><b>Сообщение:</b> <i><?=$mess['text']?></i></div>
                <div class='date'><pre>Дата отправки: <?=date('Y-m-d H:i:s', $mess['date']);?></pre></div>
                <a href="add.php?to=<?=$mess['froms']?>">Ответить</a>
            <?php endforeach; ?>
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

