<pre>
<?php
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

<?
echo '=== Авторы ===<br>';
foreach($data["authors"] as $key => $authors) {
  echo '<p>'.$authors["name"].' - '.$authors['email'].' - '.$authors['birthYear'].'</p>';
   }
?>
<?
echo '=== Книги ===<br>';

foreach($data["books"] as $key) {
    echo '<p>'.$key["title"].' - ';
    if ($key['author']){
        foreach ($data["authors"] as $authorsKey) {
            if ($authorsKey['id'] === $key['author']) {
              echo $authorsKey['name'];
            }
        }
    }

    echo ' - '.$key["publishedAt"].'</p>';
}

function task17($n){
    $sum = 0;
    for($i=0; $i<= $n; $i++) {
        if($i % 3 == 0 && $i % 5 == 0) {
            $sum -= 1;
        }
        elseif($i % 3 == 0){
            echo $i.'<br>';
        }
        elseif($i % 5 == 0){
            $sum += $i;
        }
    }
    return $sum;
}

echo task17(3);


//foreach($data["books"] as $key) {
//    echo '<p>'.$key["title"].' - ';
//
//    if ($key['author']){
//
//        $search = $key['author'];
//        $new = array_column($data["authors"], 'name', 'id');
//        echo $new[$search];
//    }
//
//    echo ' - '.$key["publishedAt"].'</p>';
//}

?>


</pre>