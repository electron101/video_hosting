<div class="auth_form">
	<form action="" method="POST">
		<label for="login">Логин</label>
		<input type="hidden" name="act" value="login">
		<input type="text" id="login" name="log" required>
		<br>
		<label for="pass">Пароль</label>		
		<input type="password" id="pass" name="pass" required>
		<br>
		<input type="Submit" value="Войти">
	</form>
	<a href="?act=register" class="register">Регистрация</a>
</div>