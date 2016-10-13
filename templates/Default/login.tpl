[not-group=5]
<p>
			<h3>Привет, <a href="{profile-link}">{login}</a></h3>
			
			<span>[admin-link]<a href="{admin-link}" target="_blank"><b>Админпанель</b></a>[/admin-link]</span><br>
			<span><a href="{profile-link}">Мой профиль</a></span><br>
			<span><a href="{newposts-link}">Непрочитанное</a></span><br>
			<span><a href="/?do=lastcomments">Последние комментарии</a></span><br>
			<span><a href="{stats-link}">Статистика</a></span><br><br>

			<span><a href="{addnews-link}">Добавить новость</a></span><br>
			<span><a href="{pm-link}">Сообщений: </a><strong><a class="radial" href="{pm-link}">{new-pm}</a></strong></span><br><br>

			<span><a class="readon" href="{logout-link}">Выход</a></span>
</p>


[/not-group]
[group=5]


<form class="" method="post" action="">
  <div class="control-group">
    <label class="control-label" for="login_name">Логин</label>
    <div class="controls">
      <input type="text" name="login_name" id="login_name" placeholder="Логин">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="login_password">Пароль</label>
    <div class="controls">
      <input type="password" name="login_password" id="login_password" placeholder="Пароль">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <label class="" for="login_not_save">
        <input type="checkbox" name="login_not_save" id="login_not_save" value="1">Не запоминать меня
      </label>
      <button type="submit" class="readon" onclick="submit();" title="Войти"> Войти</button>
    </div><input name="login" type="hidden" id="login" value="submit" />
  </div>
</form>



<a href="{lostpassword-link}">Забыли пароль?</a><br>
<a href="{registration-link}"><i>Регистрация</i></a>
[/group]