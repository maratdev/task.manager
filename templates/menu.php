<?php
foreach ($menu as $value){
    $class_active = strpos($_SERVER["REQUEST_URI"], $value['path']);
    if ($class_active !== false){
        $class_active = $cssClass;
    } elseif  ($value["sort"] == '1' && ($_SERVER["REQUEST_URI"] == '' or $_SERVER["REQUEST_URI"] == '/?login=yes')){
        $class_active = $cssClass;
    }

    echo "<li><a $class_active  href='$value[path] '>" .string_mb_strimwidth($value['title'])."</a></li>";
}
