<pre>
<?php
// гаражи
$garages = [
    1 => ['id' => 1, 'name' => 'Гараж на улице 1', 'size' => 1],
    7 => ['id' => 7, 'name' => 'Подземная парковка', 'size' => 100],
    23 => ['id' => 23, 'name' => 'У домика в деревне', 'size' => 2],
];

// машины
$cars = [
    ['name' => 'Белый Ford', 'garageId' => 7],
    ['name' => 'Черный Уаз', 'garageId' => 1],
    ['name' => 'Синий Таз',  'garageId' => 7],
];

foreach($cars as $key) {
    echo '<p>'.$key["name"].' ';
    if ($key['garageId']){
        foreach ($garages as $authorsKey => $authors) {
            if ($authors['id'] === $key['garageId']) {
                echo 'стоит '.$authors['name'].'</p>';
            }
        }
    }

}



