<?php
if ($_POST) {
    $logins = include 'users.php';
    $passwords = include 'passwords.php';

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