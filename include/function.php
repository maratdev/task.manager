<?php
include_once 'main_menu.php';

function h1($menu){
    foreach ($menu as $value){
        $class_active = strpos($_SERVER["REQUEST_URI"], $value['path']);

        if(array_search($class_active, $value)){
            echo $value['title'];
        }
    }

    if (($_SERVER["REQUEST_URI"]=='/index.php') or ($_SERVER["REQUEST_URI"]=='/') ){
        echo "Главная";
        }

}




function arraySort(array $menu, int $sort = SORT_ASC, string $key = 'sort') : array
{
    usort($menu, function($a, $b) use ($sort, $key) {
        return $sort === SORT_DESC ? $b[$key] <=> $a[$key] : $a[$key] <=> $b[$key];});

    return $menu;

}


function string_mb_strimwidth($string, $start = 0, $width = 15, $trim = '...') {
    return rtrim(mb_strimwidth($string, $start, $width, $trim));
}

$cssClass= "class='active'";
function showMenu(array $menu, string $cssClass, int $sortType = SORT_ASC){
    $menu = arraySort($menu, $sortType);
    require($_SERVER['DOCUMENT_ROOT'] . '/templates/menu.php');
}






