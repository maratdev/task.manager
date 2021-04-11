<?php
error_reporting(E_ALL);

//Регистрация
if (isset($_POST['reg'])){
    $full_name = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['full_name'])));
    $login = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['login'])));
    $password = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['password'])));
    $password_confirm = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['password_confirm'])));
    $email = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['email'])));
    $phone = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['phone'])));
    if (empty($_POST['flag_email'])){
        $flag_email = 0;
    }else{
        $flag_email = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['flag_email'])));
    }

    //Добавление кук при регистрации
    $loginForm = setcookie('login', $login);
    //$passwordForm = setcookie('password', $password);
    $full_nameForm = setcookie('full_name', $full_name);
    $emailForm = setcookie('email', $email);
    $phoneForm = setcookie('phone', $phone);

    getUserByLogin($full_name, $login, $password, $password_confirm, $email, $phone, $flag_email);
}


//Авторизация
if (!empty($_POST['auth'])){
    $post_login = $_POST['user_login'];
    $post_pass = $_POST['user_password'];


    isAuth($post_login, $post_pass);
}



//Онлайн или нет

if (!empty($_SESSION['user']['login'])){

$OnLine = mysqli_query(getConnection(), "UPDATE users SET last_activity = UNIX_TIMESTAMP()  WHERE login = '".$_SESSION['user']['login']."'"); // Закоментироать что бы проверить работу функции онлайн или нет

$userOnLine = mysqli_fetch_assoc(mysqli_query(getConnection(), "SELECT * FROM users  WHERE login = '".$_SESSION['user']['login']."'"));

if ($userOnLine['last_activity'] < (time()-600)){ // 10 минут
    $_SESSION['online'] = 'Нет';
}else{
    $_SESSION['online'] = 'Да';

}
}
$get_login = isset($_GET['login']);

