<?
foreach ($menu as $value){
    $class_active = strpos($_SERVER["REQUEST_URI"], $value['path']) !== false ? $cssClass : '';
    echo "<li><a $class_active  href='$value[path] '>" .string_mb_strimwidth($value['title'])."</a></li>";
};
