<?php
include 'main_menu.php';
include 'bd.php';

    function getConnection() {
        $connect = @mysqli_connect(DB_SERVER, DB_USER, DB_PASS,DB_NAME);
        if(!$connect) {
            die (mysqli_errno().' '.mysqli_error().' Ошибка подключения.');
        }
        mysqli_character_set_name($connect);
        return $connect;
    }

    
    //Сортировка меню
    function arraySort(array $menu, int $sort = SORT_ASC, string $key = 'sort') : array{
        usort($menu, function($a, $b) use ($sort, $key) {
            return $sort === SORT_DESC ? $b[$key] <=> $a[$key] : $a[$key] <=> $b[$key];});

        return $menu;

    }

    //вывод title
//Функция вывода названия страницы на которой находися пользователь
function isCurrentUrl($path, $menu){
        $parse =parse_url($path, PHP_URL_PATH);
        $pos = rtrim($parse, '/\\');
        foreach ($menu as $title=>$url) {
            if (rtrim($url['path'], '/\\') == $pos){
               return $url['title'];
            }elseif(($_SERVER["REQUEST_URI"] == '/' or $_SERVER["REQUEST_URI"] == '/?login=yes')){
                return 'Главная';
            }
        }
    }


    function string_mb_strimwidth($string, $start = 0, $width = 15, $trim = '...') {
        return rtrim(mb_strimwidth($string, $start, $width, $trim));
    }

    //добавление класса к ссылке
    $cssClass= "class='active'";
    function showMenu(array $menu, string $cssClass, int $sortType = SORT_ASC){
        $menu = arraySort($menu, $sortType);
        include($_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php');
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

//  Поиск пользователю по id
    function getUserOnId($id){
        $result_set = mysqli_query(getConnection(),"SELECT * FROM users WHERE id='$id'");
        return mysqli_fetch_assoc($result_set);
    }


//  Добавление сообщения в БД
    function addMessage($from, $to, $header, $message, $category, $read_msg){
        mysqli_query(getConnection(),"INSERT INTO messages (froms, tos, header, message, `date`, `section`, read_msg) 
                                        VALUES ('$from', '$to', '$header', '$message', UNIX_TIMESTAMP(), '$category', '$read_msg')");
    }


//  Вывод всех сообщений
    function getAllMessages($to){
        $result_set = mysqli_query(getConnection(),"SELECT * FROM messages WHERE tos = '$to' ORDER BY `date` DESC ");
        return resultToArray($result_set);
    }


//  Вывод категории сообщения
function getSectionOnId($id){
    $result_set = mysqli_query(getConnection(),"SELECT * FROM categories WHERE id='$id'");
    return mysqli_fetch_assoc($result_set);
}


//  Поиск пользователю по login
function getIdOnUsers($login){
    $result_set = mysqli_query(getConnection(),"SELECT * FROM users WHERE id='$login'");
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
        global $mess;
        $my_messages = [];
        if (is_int($ids) and !empty($to)){
            $query = "SELECT * FROM messages
                        LEFT JOIN categories 
                        ON categories.id = $ids
                        WHERE messages.tos = $to
                        ORDER BY `date` DESC ";

            $res = mysqli_query(getConnection(), $query) or trigger_error(mysqli_error(getConnection())." in ". $query);
            while ($row = mysqli_fetch_array($res)){
                $my_messages[] = $row;
            }
        }else{
           $mess = '';
        }
            return $my_messages;

    }


