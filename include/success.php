<?php
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.cookie_lifetime', 0);
session_set_cookie_params(0);
session_name('session_id');
session_start();

include_once 'login_form.php';
include_once 'function.php';
include_once 'catalog.php';
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

<?php include_once '../templates/header.php' ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">
            <?
            $result = get_cat();
            echo "<div class='side-bar' style='width: 450px; padding: 10px; border: 1px solid cadetblue'>";
            view_cat($result);
            echo "</div>";
            ?>
               <?php
               $messages = getAllMessages(getIdOnLogin($_SESSION['login']));
                    for ($i = 0; $i < count($messages); $i++){
                        $from = getUserOnId($messages[$i]["froms"]);
                        echo " 
                            <div class='online'>
                                <div class='full_name'>От кого: ".$from["login"]." </div>
                                <div class='sections'>Раздел: ".$messages[$i]["section"]." </div>
                                <div class='message'>Сообщение: ".$messages[$i]["message"]."</div>
                                <div class='date'>Дата отправки: ".date("Y-m-d H:i:s", $messages[$i]["date"])."</div>
                                 <a href='../templates/messages.php?to=".$from["id"]."' title='Ответить'>Ответить</a>
                            </div>
                            <br>";
                    }
               ?>
            <br>
            <div class="category_menu">
                <ul class="category">
                    <?= $categories_menu;?>
                </ul>
                <hr>
                    <p> <?= $breadcrumbs;?></p>
                <br>
                 <hr>
                    <?php if($my_messages): ?>
                       <?php foreach($my_messages as $message):  ?>
                           <a href="?id=<?=$message['id']?>?froms=<?=$message['froms']?>"><?=$message['message']?></a><br>
                       <?php endforeach;  ?>
                   <?php else:;  ?>
                    <p>Нет сообщений !</p>
                   <?php endif;  ?>
                <pre>
                   <?
                   print_r($my_messages);
                   ?>
                </pre>

            </div>

            <a  href="/">Назад</a>
        </td>
    </tr>
</table>

<?php include_once '../templates/footer.php' ?>
<script>
    $(document).ready(function () {
    $(".category").dcAccordion()
    });
</script>
</body>
</html>
