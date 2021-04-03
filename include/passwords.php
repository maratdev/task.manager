<?php
session_name('session_id');
session_start();

if (isset($check)){
    unset($_POST['formCheck']);
    header("Location: ".$_SERVER['REQUEST_URI']);
}

if ($_SESSION['user']['id'] != 1){
    header("Location: /?login=yes");
}

include $_SERVER['DOCUMENT_ROOT'].'/include/function.php';
$login = $_SESSION['user']['login'];

if ($_POST['formCheck']){
    $formCheck = $_POST['formCheck'];
}


// Обновление БД статуса юзера для отправки сообщения // 2 -  можно отправлять
    if(empty($formCheck) and $_POST['mod']=='on') {
       mysqli_query(getConnection(), "UPDATE users SET status = '1' WHERE login != '$login'");
    }else {
        for($i=0; $i < count($formCheck); $i++) {
            if(isset($formCheck)==$formCheck[$i]) {
                mysqli_query(getConnection(), "UPDATE users SET status = '2' WHERE id = '$formCheck[$i]'");
                    $check = true;
            }
        }
    }
    //  Обновление БД статуса юзера для отправки сообщения // 1 - нельзя отправлять
    $resultAll2 = mysqli_query(getConnection(), "SELECT * FROM users WHERE login != '$login' ");
    while ($result = mysqli_fetch_assoc($resultAll2)){
        if (!empty($formCheck) and $_POST['mod']=='on' ){
            $resCheck = array_diff(explode(' ', $result['id']), array_values($formCheck));
            $strResult = implode($resCheck, '');
            mysqli_query(getConnection(), "UPDATE users SET status = '1' WHERE id = '$strResult' AND login != '$login'");
            $check = true;

        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <title>Админка</title>
</head>
<body>
<div class="container-md">
    <h3>Все пользователи</h3>
    <form action="" method="POST">
    <table class="table table-striped">
        <caption>List of users</caption>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Login</th>
                <th scope="col">Email</th>
                <th scope="col">Message</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($_SESSION['id']):
                $resultAll = mysqli_query(getConnection(), "SELECT * FROM users WHERE login != '$login' "); // Вывод ?>
                <?php if($resultAll): ?>
                    <?php while ($result = mysqli_fetch_assoc($resultAll)):?>
                        <tr>
                            <th scope="row"><?=$result['id']?> </th>
                            <td><?=$result['login']?></td>
                            <td><?=$result['email']?></td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" name="formCheck[]" type="checkbox" id="flexCheckChecked" value="<?=$result['id']?>" <?=($result['status'] == '2'  ? 'checked' : '');?>  >
                                </div>
                            </td>
                        </tr>
                    <?php endwhile;?>
                <?php endif;?>
            <?php endif; ?>
        </tbody>
    </table>
        <button name="mod" value="on" type="submit" class="btn btn-primary">Сохранить</button>
        <a class="btn btn-secondary btn-sm" href="<?= $_SERVER['HTTP_REFERER'] == '' ? '/' : '../posts/success.php?category=9' ?>" role="button">Назад</a>
    </form>
</div>
</body>
</html>
