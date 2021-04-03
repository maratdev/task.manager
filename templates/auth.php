 <?php //Вывод информации о пользователе
    if (isset($_SESSION['id'])):?>
         <p>Здравствуйте, <b> <?=$_SESSION['user']['full_name']?> </b></p>
         <p>Ваш логин: <b> <?=$_SESSION['user']['login']?> </b></p>
         <p>Ваш номер:<b> <?=$_SESSION['user']['phone']?> </b></p>
         <p>Ваш email: <b> <?=$_SESSION['user']['email']?> </b></p>
         <?=($_SESSION['user']['status'] == 10 ? '<p>Статус: <b> Администратор </b></p>' : '');?>
         <p>Вы можете отправлять сообщения:  <b> <?=(($_SESSION['user']['status'] == 2 or $_SESSION['user']['status'] == 10) ? 'Да' : '<a href="../posts/add.php?to=1">Нет</a>');?> </b></p>
         <p>Рассылка email:  <b> <?=($_SESSION['user']['flag_email'] == '1'  ? 'Да' : 'Нет');?> </b></p>
         <?=(($_SESSION['user']['status'] == 2 or $_SESSION['user']['status'] == 10)  ? "<a href = '/posts/success.php'>Входящие сообщения</a>" : "");?>
    <?php endif;?>

    <?php // Реализация доступа для администратора 10 - админ 1 -user 2 - send message
    if (!empty($_SESSION['user']['status']) && $_SESSION['user']['status'] == 10): ?>
    <!-- Кто из пользователей был онлайн в течении 15 секунд-->
        <?php   $time15s = time()-15; //15 сек
                $time10m = time()-600; //10 минут ?>
        <?php $whoOnline = mysqli_query(getConnection(), "SELECT * FROM users WHERE last_activity > '".($time15s)."' "); ?>
        <hr>
        <p><b>Кто онлайн:</b></p>
        <?php while ($result = mysqli_fetch_assoc($whoOnline)): ?>
            <div class='online'>
                <div class='full_name'>Имя: <?= $result['full_name']?></div>
                <div class='login'>Логин: <?= $result['login']?> </div>
                <div class='login'>Статус:
                <?php switch ($result['status']):
                    case 10: ?>
                        Администратор
                    <?php break; ?>
                    <?php case 2: ?>
                        Может отправлять сообщения
                        <?php break; ?>
                    <?php case 1: ?>
                        Юзер
                        <?php break; ?>
                    <?php default: ?>
                        Не известно.
                    <?php endswitch; ?>
                </div>
            </div>
            <br>
            <hr>
            <?php endwhile;?>
    <?php endif;?>

   <?php if ($_SESSION['user']['status'] == 2 or $_SESSION['user']['status'] == 10):  // Пользователь имеющий право писать сообщения (2) ?>
    <!--  // Вывод всех зарегистрированых пользователей и отправка сообщений -->
        <?php if ($_SESSION['user']['login']):
            $login = $_SESSION['user']['login'];
            $resultAll = mysqli_query(getConnection(), "SELECT * FROM users WHERE login != '$login' && status !='1' ");
        ?>
    <?php if($resultAll): ?>
                <p><b>Отправить сообщение:</b></p>
               <?php  while ($result = mysqli_fetch_assoc($resultAll)): ?>
                    <div class='online'>
                        <div class='full_name'>Имя: <?=$result['full_name']?> </div>
                        <div class='login'>Логин: <?=$result['login']?></div>
                        <a href='/posts/add.php?to=<?=$result['id']?>'>Написать сообщение</a>
                    </div>
                    <br>
                <?php endwhile;?>
                <?php endif;?>
            <?php endif;?>
        <?php endif;?>

<?php if (!empty($_COOKIE['logins']) && !empty($_SESSION['user']['password'])): ?>
    <br><br>Ваши куки: <?=$_COOKIE['logins']?> и <?=$_SESSION['user']['password']?>

<?php endif;?>

<?php if (!empty($_SESSION['user']['login'])):?>
  <br><br><a href = "?action=exit">Выход</a>
<?php endif;?>




