<?php
session_start();
require_once 'bd.php';

//Регистрация
if (isset($_POST['reg'])){
    $full_name = strip_tags(trim($_POST['full_name']));
    $login = strip_tags(trim($_POST['login']));
    $password = strip_tags(trim($_POST['password']));
    $email = strip_tags(trim($_POST['email']));
    $phone = strip_tags(trim($_POST['phone']));
    $flag_email = strip_tags(trim($_POST['flag_email']));
    $password_confirm = strip_tags(trim($_POST['password_confirm']));

    if (!empty($password) and !empty($password_confirm)){
        if ($password === $password_confirm){

            $passwordHash =  hash(sha512, $password);

            $res = mysqli_query($link,"SELECT * FROM users WHERE login = '$login'");
                if (mysqli_fetch_array($res)){
                    $_SESSION['message'] = [
                        'text'=>'Данный логин занят!',
                        'status'=>'error'
                    ];
                }else{
                    $query = "INSERT INTO users (full_name, login, password, email, phone, flag_email, last_activity, status) 
                            VALUES('$full_name', '$login', '$passwordHash','$email', '$phone', '$flag_email', UNIX_TIMESTAMP(), '1')";
                    mysqli_query($link, $query) or die(mysqli_error($link));
                    $_SESSION['message'] = [
                        'text'=>'Регистрация прошла успешно!',
                        'status'=>'success'
                    ];
                }

        }else{
            $_SESSION['message'] = [
                'text'=>'Пароли не совпадают!',
                'status'=>'error'
            ];
        }
    }else{
        $_SESSION['message'] = [
            'text'=>'Ввели не все значения!',
            'status'=>'error'
        ];

    }

}

$loginForm = setcookie('login', $login);
$passwordForm = setcookie('password', $password);
$full_nameForm = setcookie('full_name', $full_name);
$emailForm = setcookie('email', $email);
$phoneForm = setcookie('phone', $phone);


//Авторизация
if (!empty($_POST['auth'])) {

    $login_form = strip_tags(trim($_POST['login']));
    $pass_form = strip_tags(trim(hash(sha512, $_POST['password'])));

    //Проверка правильность формы
    $check_user = mysqli_query($link, "SELECT * FROM users WHERE login = '$login_form' AND password = '$pass_form'");
   if (mysqli_num_rows($check_user) > 0){
       $user = mysqli_fetch_assoc($check_user);
       $_SESSION['user'] = [
            "id" => $user['id'],
            "full_name" => $user['full_name'],
            "email" => $user['email'],
            "phone" => $user['phone'],
            "login" => $user['login'],
            "status" => $user['status'],
            "flag_email" => $user['flag_email']
       ];
       $true_form_set = true;
   }else{
       $_SESSION['message'] = [
           'text'=>'Не правильный логин или пароль',
           'status'=>'error'
       ];
   }

}

//Онлайн или нет
$OnLine = mysqli_query($link, "UPDATE users SET last_activity = UNIX_TIMESTAMP()  WHERE login = '".$_SESSION['user']['login']."'"); // Закоментироать что бы проверить работу функции онлайн или нет

$userOnLine = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users 
                                                            WHERE login = '".$_SESSION['user']['login']."'"));

if ($userOnLine['last_activity'] < (time()-600)){ // 10 минут
    $_SESSION['online'] = 'Нет';
}else{
    $_SESSION['online'] = 'Да';

}

$get_login = isset($_GET['login']);







