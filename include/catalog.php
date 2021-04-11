<?php
$categories = get_categories();
$categories_tree = map_tree($categories);
$categories_menu = categoriesToString($categories_tree);

if (isset($_GET['category'])){
    $id = (int)$_GET['category'];
    // хлебные крошки
    $breadcrumbs = '';
   $breadcrumbs_array = breadcrumbs($categories, $id);
   if ($breadcrumbs_array){
       foreach ($breadcrumbs_array as $id => $title){
           $breadcrumbs .= "<a href='?category={$id}'>{$title}</a> /";
       }
       $breadcrumbs = rtrim($breadcrumbs, ' / ');
       $breadcrumbs = preg_replace("#(.+)?<a.+>(.+)</a>$#", "$1$2", $breadcrumbs); // удаление ссылки с последнего элемента

   }else{
       $breadcrumbs = "Каталог";
       $id = (int)$_GET['category'];
   }

    // ID дочерных категорий
    $ids = cats_id($categories, $id);
    $ids = !$ids ? $id : rtrim($ids, ',');
    $froms = getUserOnId($_SESSION['user']['id']);
    $tos = getAllMessages($froms['id']);
    foreach ($tos as $item){
       $to = $item['to'];
    }
    $my_messages = get_messages($ids ,$to);
}


