<div class="page max-page font-arial">
	<form class="form classic-form padding-3" action="/join" method="POST">
		<div class="block block-center block-40 margin-1">
			<h3>Регистрация компании</h3>
		</div>
		<div class="block block-center block-40 margin-1">
			<input type="text" name="email" placeholder="E-mail">
		</div>
		<div class="block block-center block-40 margin-1">
			<input type="text" name="login" placeholder="Логин">
		</div>
		<div class="block block-center block-40 margin-1">
			<input type="text" name="name" placeholder="Имя">
		</div>
		<div class="block block-center block-40 margin-1">
			<input type="text" name="company" placeholder="Название компании">
		</div>
		<div class="block block-center block-40 margin-1">
			<input type="tel" name="phone" placeholder="Номер телефона">
		</div>
		<div class="block block-center block-40 margin-1">
			<input type="password" name="password" placeholder="Придумайте пароль">
		</div>
		<input type="hidden" name="role" value="<?php echo 'company'; ?>">
		<input type="hidden" name="car" value="<?php echo 'none'; ?>">
		<div class="block block-center block-100 text-center margin-1">
			<button type="submit" class="block block-center block-100  text-center font-arial">
				Зарегистрироваться
			</button>
		</div>
		<div class="block block-100 block-center">
			<span>Нажимая кнопку зарегестрироваться<br><br> Вы соглашаетесь с <a href="agreements/terms">условиями использования</a></span>
		</div>
	</form>
</div>