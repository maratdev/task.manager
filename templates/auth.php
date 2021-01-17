<?php
session_start();
?>

    <? //Вывод информации о пользователе
    if ($_SESSION['id']):?>
         <p>Здравствуйте, <b> <?=$_SESSION['user']['full_name']?> </b></p>
         <p>Ваш логин: <b> <?=$_SESSION['user']['login']?> </b></p>
         <p>Ваш номер:<b> <?=$_SESSION['user']['phone']?> </b></p>
         <p>Ваш email: <b> <?=$_SESSION['user']['email']?> </b></p>
         <?=($_SESSION['user']['status'] == 10 ? '<p>Статус: <b> Администратор </b></p>' : '');?>
         <p>Вы можете отправлять сообщения:  <b> <?=(($_SESSION['user']['status'] == 2 or $_SESSION['user']['status'] == 10) ? 'Да' : 'Нет');?> </b></p>
         <p>Рассылка email:  <b> <?=($_SESSION['user']['flag_email'] == 'on'  ? 'Да' : 'Нет');?> </b></p>
         <?=(($_SESSION['user']['status'] == 2 or $_SESSION['user']['status'] == 10)  ? '<a href = "include/success.php">Входящие сообщения</a>' : '');?>
    <?endif;?>
<?php

    if ($_SESSION['user']['status'] == 10){     // Реализация доступа для администратора 10 - админ 1 -user 2 - send message
        //Кто из пользователей был онлайн в течении 15 секунд
        $time15s = time()-15; //15 сек
        $time10m = time()-600; //10 минут
        $whoOnline = mysqli_query($link, "SELECT * FROM users WHERE last_activity > '".($time15s)."' ");
        echo '<p><b>Кто онлайн:</b></p>';
        while ($result = mysqli_fetch_assoc($whoOnline)){
            echo " 
            <div class='online'>
                <div class='full_name'>Имя: ".$result['full_name']."</div>
                <div class='login'>Логин: ".$result['login']."</div>
                <div class='login'>Статус: ".($result['status'] == 10 ? 'Администратор' : '')."</div>
            </div>
            <br>";
        }

    }

if ($_SESSION['user']['status'] == 2 or $_SESSION['user']['status'] == 10){   // Пользователь имеющий право писать сообщения (2)
    // Вывод всех зарегистрированых пользователей и отправка сообщений
    if ($_SESSION['id']){
        $login = $_SESSION['user']['login'];
        $resultAll = mysqli_query($link, "SELECT * FROM users WHERE login != '$login' "); // Вывод
        if($resultAll) {
            echo '<p><b>Отправить сообщение:</b></p>';
            while ($result = mysqli_fetch_assoc($resultAll)){
                echo " 
            <div class='online'>
                <div class='full_name'>Имя: ".$result['full_name']." </div>
                <div class='login'>Логин: ".$result['login']."</div>
                <a href='templates/messages.php?to=".$result['id']."'>Написать сообщение</a>
            </div>
            <br>";
            }
        }
    }

}

if (!empty($_COOKIE['logins']) and !empty($_SESSION['password'])){
    echo '<br><br>Ваши куки: '.$_COOKIE['logins'].' и '.$_SESSION['password'];
}

if ($_SESSION['id']):?>
  <br><br><a href = "?action=exit">Выход</a>
<?endif;?>




