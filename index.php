<?php
ini_set('session.gc_maxlifetime', 86400);
ini_set('session.cookie_lifetime', 0);
session_set_cookie_params(0);
session_name('session_id');
session_start();

include ''.$_SERVER['DOCUMENT_ROOT'].'/include/function.php';
include ''.$_SERVER['DOCUMENT_ROOT'].'/include/login_form.php';

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="styles.css" rel="stylesheet" />
    <title>Project - ведение списков</title>
</head>

<body>
<?php include ''.$_SERVER['DOCUMENT_ROOT'].'/templates/header.php' ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">
            <h1>Возможности проекта — <?php h1($menu); ?></h1>
            <p>Вести свои личные списки, например покупки в магазине, цели, задачи и многое другое. Делится списками с друзьями и просматривать списки друзей.</p>

            <?php  include $_SERVER['DOCUMENT_ROOT']. '/templates/auth.php'; ?>

            <?php if (isset($_SESSION['message'])):?>

                <h2 class="<?=$_SESSION['message']['status']?>"> <?=$_SESSION['message']['text']?>  </h2>
            <?endif; unset($_SESSION['message']); ?>

            <h2><?php if(isset($view)){include ''.$_SERVER['DOCUMENT_ROOT'].'/include/error.php';} ?> </h2>
        </td>
            <?php
            if(!empty($get_login == 'yes')){ include ''.$_SERVER['DOCUMENT_ROOT'].'/templates/form.php';} ?>

    </tr>
</table>
<?php include ''.$_SERVER['DOCUMENT_ROOT'].'/templates/footer.php'; ?>
</body>
</html>