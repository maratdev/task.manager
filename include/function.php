<?php
include_once 'main_menu.php';
    $path = strtok($_SERVER["REQUEST_URI"], '?');

    //Создание кук если пройдена проверка login и пароль

    if (isset($true_form_set)){
        $_SESSION['login'] = $login_form;
        $_SESSION['password'] = $pass_form;
        $_SESSION['id'] = 1;

        $loginFromCookie = setcookie('login', $login_form, strtotime("+20 minutes"), '/');
       // $passwordFromCookie = setcookie('password', $pass_form, strtotime("+20 minutes"), '/');
        header("Location: ".$path);
        exit();
    }

    //Функция вывода названия страницы на которой находися пользователь
    function h1($menu){
        foreach ($menu as $value){
            $class_active = strpos($_SERVER["REQUEST_URI"], $value['path']);

            if(array_search($class_active, $value)){
                echo $value['title'];
            }
        }

        //Вывод заголовка Главная
        if ($_SERVER["REQUEST_URI"] == '/' or ($_SERVER["REQUEST_URI"] == '/index.php?login=yes')){
            echo "Главная";
         }elseif ($_SERVER["REQUEST_URI"] == '/index.php' or ($_SERVER["REQUEST_URI"] == '/?login=yes')){
            echo "Главная";
        }
    }


    //Сортировка меню
    function arraySort(array $menu, int $sort = SORT_ASC, string $key = 'sort') : array{
        usort($menu, function($a, $b) use ($sort, $key) {
            return $sort === SORT_DESC ? $b[$key] <=> $a[$key] : $a[$key] <=> $b[$key];});

        return $menu;
    }

    foreach ($menu as $key => $val) {
        $sort[$key] = $val['path'];
    }

    //вывод title
    function page_title($menu, $sort){
        return $menu[array_search($_SERVER['REQUEST_URI'], $sort)]['title'];
    }


    function string_mb_strimwidth($string, $start = 0, $width = 15, $trim = '...') {
        return rtrim(mb_strimwidth($string, $start, $width, $trim));
    }

    //добавление класса к ссылке
    $cssClass= "class='active'";
    function showMenu(array $menu, string $cssClass, int $sortType = SORT_ASC){
        $menu = arraySort($menu, $sortType);
        require($_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php');
    }



    // проверка, если пользователь нажал выход, сессия удаляется //хук для удаления с Chrome
    $str = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    $reg = "/exit/";
    if (preg_match($reg, $str) == 1){
        session_unset();
        unset($_SESSION);
        session_destroy();
        session_write_close();
        setcookie(session_name(),'',0,'/');


        header("Location: ?login=yes");
        exit();
    }

    if($_SERVER["REQUEST_URI"] == $path and empty($_SESSION['login'])){
        header("Location: ?login=yes");
    }
