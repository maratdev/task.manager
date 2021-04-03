<td class="right-collum-index">

        <div class="project-folders-menu">
            <ul class="project-folders-v">
                <li class="tablinks" onclick="openCity(event, 'Auth')" id="defaultOpen"><a href="#">Авторизация</a></li>
                <li class="tablinks" onclick="openCity(event, 'Reg')" ><a href="#">Регистрация</a></li>
                <li class="tablinks"><a href="#">Забыли пароль?</a></li>
            </ul>
            <div style="clear: both;"></div>
        </div>

        <div id="Auth" class="tabcontent index-auth">
            <form action="" method="POST">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if (!isset($_SESSION['login']) && $_COOKIE['logins']): ?>
                      <i> Cессия истекла, введи пароль ещё раз </i><br>
                      <?php endif;?>

                 <tr><td class="iat">Ваш логин: <br /> <input name="user_login" value="<?= $_COOKIE["logins"] ?>"/></td></tr>
                    <tr>
                        <td class="iat">Ваш пароль: <br /> <input type="password"  name="user_password" /></td>
                    </tr>
                    <tr>
                        <td><input name="auth" type="submit" value="Войти" /></td>
                    </tr>
                </table>
            </form>
        </div>
    <div id="Reg" class="tabcontent index-auth">
        <form action="" method="POST" >
            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tr><td class="iat">Ваше имя: <br /> <input name="full_name" value="<?= $_COOKIE["full_name"] ?>"/></td></tr>
                <tr><td class="iat">Ваш логин: <br /> <input name="login" value="<?= $_COOKIE["login"] ?>"/></td></tr>
                <tr><td class="iat">Ваш email: <br /> <input name="email" value="<?= $_COOKIE["email"] ?>"/></td></tr>
                <tr><td class="iat">Ваш номер телефона: <br /> <input name="phone" value="<?= $_COOKIE["phone"] ?>"/></td></tr>
                <tr><td class="iat">Ваш пароль: <br /> <input type="password" value="<?= $_COOKIE["password"] ?>" name="password" /></td></tr>
                <tr><td class="iat">Подтвердите пароль: <br /> <input type="password" value="" name="password_confirm" /></td></tr>
                <tr><td class="iat"><p><input type="checkbox" name="flag_email" value="1">Cогласен на получение уведомлений по email</p></td></tr>
                <tr>
                    <td><button name="reg" type="submit" >Зарегистрироваться</button></td>
                </tr>
            </table>
        </form>
    </div>
    </td>