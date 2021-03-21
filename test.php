<?php
$lit = array(
    'gogol' => array(
        'name' => 'Гоголь Николай',
        'mail' => 'gogol@gogol.ru',
        'born' => '1809',
        'books' => array('Вечера на хуторе близь Диканьки', 'Мертвые души', 'Вий', 'Тарас Бульба'),
        'booksdate' => array('1833', '1816', '1840', '1843')
    ),
    'pushkin' => array(
        'name' => 'Пушкин Александр',
        'mail' => 'pushkin@pushkin.ru',
        'born' => '1799',
        'books' => array('Вечера на хуторе близь Диканьки', 'Мертвые души', 'Вий', 'Тарас Бульба'),
        'booksdate' => array('1833', '1816', '1840', '1843')
    ),
    'dostoevskii' => array(
        'name' => 'Достоевский Федор',
        'mail' => 'dostoevskii@dostoevskii.ru',
        'born' => '1865',
        'books' => array('Вечера на хуторе близь Диканьки', 'Мертвые души', 'Вий', 'Тарас Бульба'),
        'booksdate' => array('1833', '1816', '1840', '1843')
    )
);
    $menus = [
        [
            'label' => 'YiFramework',
            'url' => 'https://yifraemwork.ru',
        ],
        [
            'label'=> 'MoreFramework',
            'item'=> [
                [ 'label'=> 'Laravel', 'url' => 'https://laravel.ru'],
                [ 'label'=> 'Phalcon', 'url'=> 'https://phalconfraemwork.ru'],
            ],
        ],
        [
            'label'=> 'Symfony',
            'url'=> 'https://symfonyraemwork.ru',
        ],
        ];


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<a href=""></a>
<?
foreach ($lit as $key => $value) {
    echo $value['name'] . " - " . $value['mail'] . ", Дата рождения - " . $value['born'] . "<br>";

    $books = array_combine($value['booksdate'],$value['books']);

    echo 'Произведения:<br>';

    foreach ($books as $data => $name) {
        echo $data . ' - ' . $name . '<br>';
    }
}
?>

<ul>
    <? foreach ($menus as $item ):?>
        <li><a href='<?=$item['url']?>'><?=$item['label']?></a></li><ul>
            <?$count = count($item['item']) ?>
            <?for ($i=0; $i < $count; $i++): ?>
                <li><a href='<?=$item['item'][$i]['url']?>'><?=$item['item'][$i]['label']?></a></li>
            <?endfor;?>
        </ul>
    <?endforeach;?>
</ul>

</body>
</html>
