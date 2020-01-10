<?php

if (isset($_SESSION['id'])){
    echo 'Здравствуйте, <b>'. $_SESSION['login'].' !</b> ';
    echo '<br><a href = "?action=exit">Выход</a>';

}

if (isset($_COOKIE['login'])){
    echo '<br><br>Ваши куки: '.$_COOKIE['login'].' и '.$_SESSION['password'];

}



