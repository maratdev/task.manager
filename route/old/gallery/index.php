<?php
include_once  $_SERVER['DOCUMENT_ROOT'] . '/include/function.php';
include_once $_SERVER['DOCUMENT_ROOT'] .  '/include/login_form.php';


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="../../styles.css" rel="stylesheet" />
    <title>Project - ведение списков</title>
    <style>
        .hidden{
            display: none;
        };
        .visible{

        }
    </style>
</head>

<body>

<?  include_once '../../templates/header.php'; ?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">

            <h1>Возможности проекта — <? h1($menu)?></h1>



            <h2><? if($true_form_set){ require '../../include/success.php';} if($view){require '../../include/error.php';}; ?>  </h2>


            <?if (isset($get_login)){ ?>


        </td>
        <td class="right-collum-index">

            <div class="project-folders-menu">
                <ul class="project-folders-v">
                    <li class="project-folders-v-active"><span>Авторизация</span></li>
                    <li><a href="#">Регистрация</a></li>
                    <li><a href="#">Забыли пароль?</a></li>
                </ul>
                <div style="clear: both;"></div>
            </div>
            <div class="index-auth">
                <form action="" method="POST">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">

                        <tr>
                            <td class="iat">Ваш e-mail: <br /> <input id="login_id" size="30" value="<?=$_POST['login']?>" name="login" /></td>
                        </tr>
                        <tr>
                            <td class="iat">Ваш пароль: <br /> <input id="password_id" type="password" size="30" value="<?=$_POST['password']?>" name="password" /></td>
                        </tr>
                        <tr>
                            <td><input name="submit" type="submit" value="Войти" /></td>
                        </tr>
                    </table>
                </form>
            </div>

        </td>
    </tr>
</table>
<?php }?>

<? include_once '../../templates/footer.php' ?>

</body>
</html>