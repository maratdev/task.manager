<td class="right-collum-index">
        <div class="project-folders-menu">
            <ul class="project-folders-v">
                <li class="project-folders-v-active"><span>Авторизация</span></li>
                <li><a href="#">Регистрация</a></li>
                <li><a href="#">Забыли пароль?</a></li>
            </ul>
            <div style="clear: both;"></div>
        </div>
        <div class="index-auth">
            <form action="" method="POST">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <? if (!$_SESSION['login'] && $_COOKIE['login']): ?>
                      <i > Cессия истекла, введи пароль ещё раз </i ><br >
                      <?endif;?>

                 <tr><td class="iat">Ваш e-mail: <br /> <input id="login_id" size="30" name="login" value="<?= $_COOKIE["login"] ?>"/></td></tr>
                    <tr>
                        <td class="iat">Ваш пароль: <br /> <input id="password_id" type="password" size="30" value="" name="password" /></td>
                    </tr>
                    <tr>
                        <td><input name="submit" type="submit" value="Войти" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </td>