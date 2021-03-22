<?
foreach ($menu as $value){
    $class_active = strpos(REQUEST, $value['path']);
    if ($class_active !== false){
        $class_active = $cssClass;
    } elseif  ($value["sort"] == '1' and (REQUEST == '/' or REQUEST == '/?login=yes')){
        $class_active = $cssClass;
    }

    echo "<li><a $class_active  href='$value[path] '>" .string_mb_strimwidth($value['title'])."</a></li>";
}
