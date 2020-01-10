<?php
$host ='localhost';
$userDB ='mysql';
$passwordDB ='mysql';
$DBname ='mydb';

//Создаем подключение к БД
$connect = mysqli_connect($host, $userDB, $passwordDB, $DBname);

if(mysqli_connect_errno()){
   echo mysqli_connect_error();
}else{
$result = mysqli_query(
    $connect ,
  "select name, sum(count) from products group  by name ; "); //Вывод всех таблиц из products на экран
  //"select * from products where price = 2000; "); //Вывод всех таблиц которая цена равна 2000
  //"select * from products where price < 2000; "); //Вывод всех таблиц которая цена не равна 2000 != -аналог >= - больше и равно <= - меньше или равно и.т.д
//  "select * from products where description is not null; "); //Проверяет есть ли описание с значением null is not - не соответсвует null
  //"select name, price from products where price between 2000 and 5000"); // задаем диапазон выборки с 2000 до 5000
  //"select distinct name from products; "); //Убрать дубли в название
  //"select name as 'Название', price as 'Цена:'  from products; ");  // вместо * - name , price..  можно делать выборку, name as '' - Вставляем свое название на экр.
  //"update products set price=price +'50' where id='2';"); //Обновление цены с прибавлением цены 50р
  //"update products set price=price +'50' order by price asc limit 2;"); //Обновление цены с в диапазоне 2
  //"delete from products order by price asc limit 2"); // Удаление таблицы в диапозоне с наименьшей суммой
  //"delete from products where id = '2'"); //Удаление таблицы с id 2

//  "insert into products (name, price, count, stock_id) //Добавление товара в таблицу
//  values('Лампа', '2000', '15', '2'),
//        ('Шторы', '1700', '4', '3'),
//        ('Клавиатура', '700', '30', '3'),
//        ('Компьютерная мышь', '500', '14', '1')");
//Добавление товара в таблицу
//  "insert into products (name, price, count, stock_id)
//     values('Клавиатура', '3000', '15', '3')");



//var_export($result);
while ($row = mysqli_fetch_assoc($result)){
    echo "<pre>";
    var_export($row);
}


}


//закрываем подключение
mysqli_close($connect);