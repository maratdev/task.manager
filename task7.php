<?php
if ($_POST) {

    $logins = include 'include/users.php';
    $passwords = include 'include/passwords.php';


    $login_form = strip_tags(trim($_POST['login']));
    $pass_form = strip_tags(trim($_POST['password']));

    //Проверка правильность формы

    if (($k = array_search($login_form, $logins)) !== false) {
        $passwords[$k] != $pass_form ?: $true_form_set = true;
    };


    if (!empty($k = array_search($login_form, $logins)) != false) {
        $passwords[$k] == $pass_form ?: $view = true;
    }else{
        $view = 'Пустая форма!';
    }

}

$get_login = $_GET['login'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="styles.css" rel="stylesheet" />
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

<div class="header">
    <div class="logo"><img src="i/logo.png" width="68" height="23" alt="Project" /></div>
    <div style="clear: both"></div>
</div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="left-collum-index">

            <h1>Возможности проекта —</h1>
            <p>Вести свои личные списки, например покупки в магазине, цели, задачи и многое другое. Делится списками с друзьями и просматривать списки друзей.</p>

            <h2><? if($true_form_set){ require 'include/success.php';} if($view){require 'include/error.php';}; ?> </h2>


            <?
            if (!empty($get_login == 'yes')){ ?>
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

<div class="footer">&copy;&nbsp;<nobr>2018</nobr> Project.</div>

</body>
</html>