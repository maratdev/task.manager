<?php
error_reporting(E_ALL);
include $_SERVER['DOCUMENT_ROOT'].'/include/main_menu.php';
include $_SERVER['DOCUMENT_ROOT'].'/include/bd.php';



    function getConnection() {
        $connect = @mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
        if(!$connect) {
            die (mysqli_errno().' '.mysqli_error().' Ошибка подключения.');
        }
        mysqli_character_set_name($connect);
        return $connect;
    }


    //вывод title
    //Функция вывода названия страницы на которой находися пользователь
    function isCurrentUrl($path, $menu){
            $parse =parse_url($path, PHP_URL_PATH);
            $pos = rtrim($parse, '/\\');

            foreach ($menu as $title => $url) {
                if (rtrim($url['path'], '/\\') == $pos){
                   return $url['title'];
                }
            }
    }

    //Сортировка меню
    function grade_sort($x, $y) {
        return ($x['sort'] > $y['sort']);
    }
    usort ($menu, 'grade_sort');

    //Выыод меню
    function showMenu($menu, $path){
        $parse =parse_url($path, PHP_URL_PATH);
        $pos = rtrim($parse, '/\\');
        foreach ($menu as $title => $url){
            echo "<li><a ";
            if (rtrim($url['path'], '/\\') == $pos){
                echo 'class="active"';
            }
            echo 'href='.$url['path'].'>'.string_mb_strimwidth($url['title']).'</a></li>';
        }

    }
        //Обрезка длинного текста меню
    function string_mb_strimwidth($string, $start = 0, $width = 15, $trim = '...') {
        return rtrim(mb_strimwidth($string, $start, $width, $trim));
    }



    // проверка, если пользователь нажал выход, сессия удаляется
    //хук для удаления с Chrome
    $str = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    $reg = "/exit/";
    if (preg_match($reg, $str) == 1){
        session_unset();
        unset($_SESSION);
        unset($_COOKIE['logins']);
        setcookie('logins', null, -1, '/');
        session_destroy();
        session_write_close();
        header("Location: ?login=yes");
        exit();
    }

// Перевод в ассоциативный массив
    function resultToArray($result_set){
        $results = [];
        while (($row = mysqli_fetch_assoc($result_set)) != false){
            $results[] = $row;
        }
        return $results;
    }

// Экранирует параметры, которые передаются в запрос
    function mysqli_real_escape($string){
        $results = mysqli_real_escape_string(getConnection(), $string);
        return $results;

    }

//  Поиск пользователю по id
    function getUserOnId($id){
        $result_set = mysqli_query(getConnection(),"SELECT * FROM users WHERE id= {mysqli_real_escape($id)}");
        return mysqli_fetch_assoc($result_set);
    }


//  Добавление сообщения в БД
    function addMessage($from, $to, $header, $text, $category, $read){
        mysqli_query(getConnection(),"INSERT INTO messages (`from`, `to`, header, text, `date`, `category_id`, `read`) 
         VALUES ({mysqli_real_escape($from)} , {mysqli_real_escape($to)}, '$header', '$text', UNIX_TIMESTAMP(), {mysqli_real_escape($category)}, {mysqli_real_escape($read)})");

    }


//  Вывод всех сообщений
    function getAllMessages($to){
        $result_set = mysqli_query(getConnection(),"SELECT * FROM messages WHERE `to` = {mysqli_real_escape($to)} ORDER BY `date` DESC ");
        return resultToArray($result_set);
    }

//  Вывод всех сообщений
function getAllMessages2($int, $to){
    $result_set = mysqli_query(getConnection(),"SELECT * FROM messages WHERE `to` = {mysqli_real_escape($to)} AND `read` = '$int' ORDER BY `date` DESC ");
    return resultToArray($result_set);
}


//  Вывод категории сообщения
function getSectionOnId($id){
    $result_set = mysqli_query(getConnection(),"SELECT * FROM categories WHERE id={mysqli_real_escape($id)}");
    return mysqli_fetch_assoc($result_set);
}


//  Поиск пользователю по login
function getIdOnUsers($login){
    $result_set = mysqli_query(getConnection(),"SELECT * FROM users WHERE id={mysqli_real_escape($login)}");
    return mysqli_fetch_assoc($result_set);
}

// Выборка из БД письма для тега option
function get_cat(){
    $sql = "SELECT * FROM color
             RIGHT JOIN categories ON color.id=categories.color_id
              ORDER BY categories.id";
    $result = mysqli_query(getConnection(), $sql);
    $arr_cat = [];

    if(mysqli_num_rows($result) != 0){
        for ($i = 0; $i < mysqli_num_rows($result); $i++){
            $row = mysqli_fetch_assoc($result);
            if (empty($arr_cat[$row['parent_id']])){
                $arr_cat[$row['parent_id']] = [];
            }
            $arr_cat[$row['parent_id']][]= $row;
        }
    }
    return $arr_cat;
}


// Вывод загловка письма в теге option 2
function view_cat($arr, $parent_id = 0){
    if (empty($arr[$parent_id])){
        return;
    }

    for ($i = 0; $i < count($arr[$parent_id]); $i++){
        if ($parent_id == 0){
            $disabled = 'disabled';
        }else{
            $arrows = '⋅';
        }
        echo "
            <option $disabled value=".$arr[$parent_id][$i]['id']." style='color: ".$arr[$parent_id][$i]['hex']."'>$arrows ".$arr[$parent_id][$i]['title']."</option>";

        view_cat($arr, $arr[$parent_id][$i]['id']);
    }
}

// Распечатка массива
//Вывод многоуровневого меню методом Tommy Lacroix tree
    function map_tree($dataset) {
        $tree = [];
        foreach ($dataset as $id => &$node) {
            if (!$node['parent_id']){
                $tree[$id] = &$node;
            }else{
                $dataset[$node['parent_id']]['childs'][$id] = &$node;
            }
        }
        return $tree;
    }

// Дерево в строуку HTML
    function categoriesToString($data){
        $string = '';
        foreach ($data as $item){
            $string .= categoriesToTemplate($item);
        }
        return $string;
    }


    // Шаблон вывода категорий
    function categoriesToTemplate($category){
            ob_start();
            include 'category_template.php';
            return ob_get_clean();
    }

    function get_categories (){
        $query = "SELECT * FROM categories";
        $res = mysqli_query(getConnection(), $query);
        $arr_cat = [];
        while ($row = mysqli_fetch_assoc($res)){
            $arr_cat[$row['id']] = $row;
        }
        return $arr_cat;
    }

    // Получение ID дочерных категорий
    function cats_id($array, $id){
        if(!isset($id)) return false;
        $data = '';
        foreach ($array as $item) {
            if ($item['parent_id'] == $id){
                $data .= $item['id'] . ",";
                $data .= cats_id($array, $item['id']);
            }
        }
        return $data;
    }

    // Хлебные крошки
    function breadcrumbs($array, $id){
        if (!$id) return false;

        $count = count($array);
        $breadcrumbs_array = [];
        for ($i = 0; $i < $count; $i++){
            if (isset($array[$id])){
                $breadcrumbs_array[$array[$id]['id']] = $array[$id]['title'];
                $id = $array[$id]['parent_id'];
            }else break;
        }
        return array_reverse($breadcrumbs_array, true);
    }

    // Получение писем
    function get_messages($ids, $to){
        global $mess;
        $my_messages = [];
        if (is_int($ids) && !empty($to)){
            $query = "SELECT * FROM messages
                        LEFT JOIN categories 
                        ON categories.id =  {mysqli_real_escape($ids)}
                        WHERE messages.to = {mysqli_real_escape($to)}
                        ORDER BY `date` DESC ";

            $res = mysqli_query(getConnection(), $query) or trigger_error(mysqli_error(getConnection())." in ". $query);
            while ($row = mysqli_fetch_array($res)){
                $my_messages[] = $row;
            }

        }elseif(!isset($to)){

            $query = "SELECT * FROM messages";
            $res = mysqli_query(getConnection(), $query) or trigger_error(mysqli_error(getConnection())." in ". $query);
            while ($row = mysqli_fetch_array($res)){
                $my_messages[] = $row;
            }
        }
            return $my_messages;

    }

// Проверка на модерацию
function resModeration($from){
        $resModeration = mysqli_query(getConnection(),"SELECT * FROM messages WHERE `from`= {mysqli_real_escape($from)} AND `read` = '1'");
        if (mysqli_num_rows($resModeration) > 0){
            return false;
        }else{
            return true;
        }
}

// Авторизация
$path = strtok($_SERVER["REQUEST_URI"], '?');

    function isAuth($post_login, $post_pass){
        global $path;
            $login_form = mysqli_real_escape(strip_tags(trim($post_login)));
            $pass_form =  strip_tags(trim($post_pass));


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
                        "status" => $user['status'],
                        "flag_email" => $user['flag_email']
                    ];

                    //Создание кук если пройдена проверка login и пароль
                    $_SESSION['id'] = 1;
                    header("Location: ".$path);
                    exit();

                }
                else{
                    $_SESSION['message'] = [
                        'text'=>'Не правильный логин или пароль.',
                        'status'=>'error'
                    ];
                    $loginFromCookie = setcookie('user_login', $post_login);
                    header("Refresh:1.5; url=?login=yes");
                }
            }else{
                $_SESSION['message'] = [
                    'text'=>'Не правильный логин или пароль!',
                    'status'=>'error'
                ];
                $loginFromCookie = setcookie('user_login', $post_login);
                header("Refresh:1.5; url=?login=yes");

            }
    }

// Регистрация
    function getUserByLogin($full_name, $login, $password, $password_confirm, $email, $phone, $flag_email){
        global $path;
            if (!empty($password) && !empty($password_confirm)){
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
                        mysqli_query(getConnection(), $query) or die('Ошибка БД или запроса: '.mysqli_error(getConnection()));
                        $_SESSION['message'] = [
                            'text'=>'Регистрация прошла успешно!',
                            'status'=>'success'
                        ];
                        foreach($_COOKIE as $key => $value) setcookie($key, '', time() - 3600, '/');
                        header("Refresh:1; url=?login=yes");
                    }

                }else{
                    $_SESSION['message'] = [
                        'text'=>'Пароли не совпадают!',
                        'status'=>'error'
                    ];
                    header("Refresh:1; url=?login=yes");

                }

            }else{
                $_SESSION['message'] = [
                    'text'=>'Ввели не все значения!',
                    'status'=>'error'
                ];
                header("Refresh:1; url=$path");
        }
    }




