<?php
session_start();
require_once 'bd.php';


//Регистрация
if (isset($_POST['reg'])){
    $full_name = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['full_name'])));
    $login = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['login'])));
    $password = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['password'])));
    $email = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['email'])));
    $phone = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['phone'])));
    $flag_email = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['flag_email'])));
    $password_confirm = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['password_confirm'])));


    $loginForm = setcookie('login', $login);
    $passwordForm = setcookie('password', $password);
    $full_nameForm = setcookie('full_name', $full_name);
    $emailForm = setcookie('email', $email);
    $phoneForm = setcookie('phone', $phone);

    $path = strtok($_SERVER["REQUEST_URI"], '#');

    if (!empty($password) and !empty($password_confirm)){

        if ($password === $password_confirm){

            $res = mysqli_query(getConnection(),"SELECT * FROM users WHERE login = '$login'");
            if (mysqli_fetch_array($res)){
                $_SESSION['message'] = [
                    'text'=>'Данный логин занят!',
                    'status'=>'error'
                ];
            }else{
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $query = "INSERT INTO users (full_name, login, password, email, phone, flag_email, last_activity, status) 
                            VALUES('$full_name', '$login', '$hash','$email', '$phone', '$flag_email', UNIX_TIMESTAMP(), '1')";
                mysqli_query(getConnection(), $query) or die(mysqli_error(getConnection()));
                $_SESSION['message'] = [
                    'text'=>'Регистрация прошла успешно!',
                    'status'=>'success'
                ];
                foreach($_COOKIE as $key => $value) setcookie($key, '', time() - 3600, '/');
                header("Refresh:0; url=$path");

            }

        }else{
            $_SESSION['message'] = [
                'text'=>'Пароли не совпадают!',
                'status'=>'error'
            ];
            header("Refresh:0; url=$path");


        }

    }else{
        $_SESSION['message'] = [
            'text'=>'Ввели не все значения!',
            'status'=>'error'
        ];
        header("Refresh:0; url=$path");

    }

}


//Авторизация
if (!empty($_POST['auth'])) {

    $login_form = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['user_login'])));
    $pass_form = mysqli_real_escape_string(getConnection(), strip_tags(trim($_POST['user_password'])));

    //Проверка правильность формы
    $check_user = mysqli_query(getConnection(), "SELECT * FROM users WHERE login = '$login_form'");
    if (mysqli_num_rows($check_user) > 0){
        $user = mysqli_fetch_assoc($check_user);
        if (password_verify($pass_form, $user['password'])){
            $_SESSION['user'] = [
                "id" => $user['id'],
                "full_name" => $user['full_name'],
                "email" => $user['email'],
                "phone" => $user['phone'],
                "login" => $user['login'],
                "password" => $user['password'],
                "status" => $user['status'],
                "flag_email" => $user['flag_email']
            ];

                //Создание кук если пройдена проверка login и пароль
                $path = strtok($_SERVER["REQUEST_URI"], '?');
                $_SESSION['id'] = 1;
                $loginFromCookie = setcookie('logins',  $_SESSION['user']['login'], strtotime("+20 minutes"), '/');
                //$passwordFromCookie = setcookie('password', $_SESSION['user']['password'], strtotime("+20 minutes"), '/');
                header("Location: ".$path);
                exit();

        }
        else{
            $_SESSION['message'] = [
                'text'=>'Не правильный логин или пароль.',
                'status'=>'error'
            ];
        }
    }else{
        $_SESSION['message'] = [
            'text'=>'Не правильный логин или пароль!',
            'status'=>'error'
        ];
    }

}


//Онлайн или нет

if (!empty($_SESSION['user']['login'])){

$OnLine = mysqli_query(getConnection(), "UPDATE users SET last_activity = UNIX_TIMESTAMP()  WHERE login = '".$_SESSION['user']['login']."'"); // Закоментироать что бы проверить работу функции онлайн или нет

$userOnLine = mysqli_fetch_assoc(mysqli_query(getConnection(), "SELECT * FROM users 
                                                            WHERE login = '".$_SESSION['user']['login']."'"));

if ($userOnLine['last_activity'] < (time()-600)){ // 10 минут
    $_SESSION['online'] = 'Нет';
}else{
    $_SESSION['online'] = 'Да';

}
}
$get_login = isset($_GET['login']);

