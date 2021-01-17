<?php
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.cookie_lifetime', 0);
session_set_cookie_params(0);
session_name('session_id');
session_start();

include_once 'include/login_form.php';
include_once 'include/function.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="styles.css" rel="stylesheet" />
    <title>Project - ведение списков</title>
</head>

<body>

<?php include_once 'templates/header.php' ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">
            <h1>Возможности проекта — <?php h1($menu); ?></h1>
            <p>Вести свои личные списки, например покупки в магазине, цели, задачи и многое другое. Делится списками с друзьями и просматривать списки друзей.</p>

            <?php  include_once $_SERVER['DOCUMENT_ROOT']. '/templates/auth.php'; ?>

            <? if ($_SESSION['message']):?>
                <h2 class="<?=$_SESSION['message']['status']?>"> <?=$_SESSION['message']['text']?>  </h2>
            <?endif; unset($_SESSION['message']); ?>

            <h2><?php if(isset($view)){require 'include/error.php';}; ?>  </h2>
        </td>
            <?php if(!empty($get_login == 'yes')){ include_once 'templates/form.php';}; ?>

    </tr>
</table>
            <?php include_once 'templates/footer.php' ?>


</body>
</html>