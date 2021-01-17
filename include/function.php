<?php
include_once 'main_menu.php';
require_once 'bd.php';
    $path = strtok($_SERVER["REQUEST_URI"], '?');

    //Создание кук если пройдена проверка login и пароль

    if (isset($true_form_set)){
        $_SESSION['login'] = $login_form;
        $_SESSION['password'] = $pass_form;
        $_SESSION['id'] = 1;

        $loginFromCookie = setcookie('logins',  $login_form, strtotime("+20 minutes"), '/');
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
        if ($_SERVER["REQUEST_URI"] == '/' or $_SERVER["REQUEST_URI"] == '/?login=yes'){
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



    // проверка, если пользователь нажал выход, сессия удаляется
    //хук для удаления с Chrome
    $str = $_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
    $reg = "/exit/";
    if (preg_match($reg, $str) == 1){
        session_unset();
        unset($_SESSION);
        unset($_COOKIE['logins']);
        //setcookie('logins', null, -1, '/');
        session_destroy();
        session_write_close();
        header("Location: ?login=yes");
        exit();
    }

    // ЗАПОЛНИТЬ КОМЕНТАРИЯМИ
    function resultToArray($result_set){
        $results = [];
        while (($row = mysqli_fetch_assoc($result_set)) != false){
            $results[] = $row;
        }
        return $results;
    }

    function getUserOnId($id){
        global $link;
        $result_set = mysqli_query($link,"SELECT * FROM users WHERE id='$id'");
        return mysqli_fetch_assoc($result_set);
    }
    function getIdOnLogin($login){
        global $link;
        $result_set = mysqli_query($link,"SELECT id FROM users WHERE login='$login'");
        $row = mysqli_fetch_assoc($result_set);
        return $row['id'];
    }

    function addMessage($from, $to, $message){
        global $link;
        mysqli_query($link,"INSERT INTO messages (froms, tos, message, `date`, `section`) 
                                        VALUES ('$from', '$to', '$message', UNIX_TIMESTAMP(), '' )");
    }

function getAllMessages($to){
    global $link;
    $result_set = mysqli_query($link,"SELECT * FROM messages WHERE tos = '$to' ORDER BY `date` DESC ");
    return resultToArray($result_set);
}


    // Вывод многоуровнего меню
    function get_cat(){
        global $link;
        $sql = "SELECT id, title, parent_id FROM categories";
        $result = mysqli_query($link, $sql);
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

    // Вывод на экран меню
    function view_cat($arr, $parent_id = 0){
           if (empty($arr[$parent_id])){
               return;
           }
           echo "<ul>";
           for ($i = 0; $i < count($arr[$parent_id]); $i++){
                echo "<li><a href='?category_id=".$arr[$parent_id][$i]['id']."&parent_id=".$parent_id."'>".$arr[$parent_id][$i]['title']."</a>";
                view_cat($arr, $arr[$parent_id][$i]['id']);
                echo "</li>";
           }
           echo "</ul>";
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
        global $link;
        $query = "SELECT * FROM categories";
        $res = mysqli_query($link, $query);
        $arr_cat = [];
        while ($row = mysqli_fetch_assoc($res)){
            $arr_cat[$row['id']] = $row;
        }
        return $arr_cat;
    }

    // Получение ID дочерных категорий
    function cats_id($array, $id){
        if(!id) return false;

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
            if ($array[$id]){
                $breadcrumbs_array[$array[$id]['id']] = $array[$id]['title'];
                $id = $array[$id]['parent_id'];
            }else break;
        }
        return array_reverse($breadcrumbs_array, true);
    }

    // Получение писем

    function get_messages($ids, $to){
        global $link;
        if ($ids){
            $query = "SELECT *
                        FROM messages
                        LEFT JOIN categories 
                        ON categories.id = $ids
                        WHERE messages.tos = $to
                        ORDER BY `date` DESC ";
        }else{
            $query = "SELECT * FROM messages ORDER BY `message`";
           // echo 'нет сообщений!';
        }
        $res = mysqli_query($link, $query);
        $my_messages = [];
            while ($row = mysqli_fetch_assoc($res)){
                $my_messages[] = $row;
            }
        return $my_messages;
    }

    // $result_set = mysqli_query($link,"SELECT * FROM messages WHERE tos = '$to' ORDER BY `date` DESC ");






