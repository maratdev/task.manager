<?php
$categories = get_categories();
$categories_tree = map_tree($categories);
$categories_menu = categoriesToString($categories_tree);

if ($_GET['category']){
    $id = (int)$_GET['category'];
    // хлебные крошки
   $breadcrumbs_array = breadcrumbs($categories, $id);
   if ($breadcrumbs_array){
       foreach ($breadcrumbs_array as $id => $title){
           $breadcrumbs .= "<a href='?category={$id}'>{$title}</a> /";
       }
       $breadcrumbs = rtrim($breadcrumbs, ' / ');
       $breadcrumbs = preg_replace("#(.+)?<a.+>(.+)</a>$#", "$1$2", $breadcrumbs); // удаление ссылки с последнего элемента

   }else{
       $breadcrumbs = "Каталог";
   }

    // ID дочерных категорий
    $ids = cats_id($categories, $id);
    $ids = !$ids ? $id : rtrim($ids, ',');
    $tos = getAllMessages(getIdOnLogin($_SESSION['login']));

    foreach ($tos as $item){
       $to = $item['tos'];
    }


    $my_messages = get_messages($ids ,$to);
}


