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
                [ 'label'=> 'Phalcon1', 'url'=> 'https://phalconfraemwork.ru'],
            ],

            'items'=> [
                [ 'label'=> 'Laravels', 'url' => 'https://laravel.ru'],
                [ 'label'=> 'Phalcons', 'url'=> 'https://phalconfraemwork.ru'],
            ],
        ],
        [
            'label'=> 'Symfony',
            'url'=> 'https://symfonyraemwork.ru',
        ],
        ];
$basket = [
    [
        'position'=> 'Книга по php',
        'quantity'=> 1,
    ],
    [
        'position'=> 'Мышь безпроводная',
        'quantity'=> 12,
    ],

];

$data2 = [
    'Мастера' => [
        [
            'Никнейм'  => 'Nick',
            'Город'    => 'Москва',
            'Доставка' => 'Да'
        ],
        [
            'Никнейм'  => 'Чебурашка',
            'Город'    => 'Челябинск',
            'Доставка' => 'Нет'
        ],
        [
            'Никнейм'  => 'Black',
            'Город'    => 'Казань',
            'Доставка' => 'Нет'
        ]
    ],
    'Товары'  => [
        [
            'Наименование' => 'Бетон',
            'Цена'         => 100,
            'Мастер'       => 'Nick'
        ],
        [
            'Наименование' => 'Герб',
            'Цена'         => 150,
            'Мастер'       => 'Nick'
        ],
        [
            'Наименование' => 'Квадрат',
            'Цена'         => 799,
            'Мастер'       => 'Black'
        ]
    ]
];

$data = [
    'authors' => [
        301 => [
            'id' => 301,
            'name' => 'Александр Сергеевич Пушкин',
            'email' => 'alexander_pushkin@example.com',
            'birthYear' => 1799,
        ],
        10 => [
            'id' => 10,
            'name' => 'Николай Васильевич Гоголь',
            'email' => 'nikolay_gogol@example.com',
            'birthYear' => 1809,
        ],
        17 => [
            'id' => 17,
            'name' => 'Михаил Юрьевич Лермонтов',
            'email' => 'mikhail_lermontov@example.com',
            'birthYear' => 1814,
        ],
    ],
    'books' => [
        [
            'title' => 'Евгений Онегин',
            'publishedAt' => '1823—1832',
            'author' => 301,
        ],
        [
            'title' => 'Полтава',
            'publishedAt' => '1828—1829',
            'author' => 301,
        ],
        [
            'title' => 'Мёртвые души',
            'publishedAt' => '1842',
            'author' => 10,
        ],
        [
            'title' => 'Сказка о рыбаке и рыбке',
            'publishedAt' => '1833',
            'author' => 301,

        ],
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

<?php
function print_list($list) {
    echo '<ul>';
    foreach($list as $list_item) {
        echo '<li>';
        echo "<a href='{$list_item['url']}'>{$list_item['label']}</a>";
        if (array_key_exists('items', $list_item) && is_array($list_item['items']))
            print_list($list_item['items']);
        echo '</li>';
    }
    echo "</ul>";
}
?>
<?




// qsoft
function countBasket($array = []): int {
    $total = 0;
    foreach ($array as &$value) {
        $total += $value['quantity'];
    }
    return $total;
}

echo countBasket($basket);

?>

</body>
</html>
