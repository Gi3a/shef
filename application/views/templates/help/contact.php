<div class="page max-page">
	<form action="/contact" method="POST" class="classic-form block block-50 block-center margin-3">
		<div class="block block-100 block-center padding-1">
			<select name="type" name="type">
				<option value="profile">Учетная запись</option>
				<option value="offer">Объявления и заказы</option>
				<option value="suggestion">Предложение и партнерство</option>
				<option value="pay">Оплата</option>
				<option value="other">Другое</option>
			</select>
		</div>
		<div class="block block-100 block-center padding-1">
			<input type="text" placeholder="E-mail" name="email">
		</div>
		<div class="block block-100 block-center padding-1">
			<input type="text" placeholder="Название сообщения" name="title">
		</div>
		<div class="block block-100 block-center padding-1">
			<textarea id="" cols="30" rows="10" placeholder="Текст сообщения" name="description"></textarea>
		</div>
		<div class="block block-100 block-center padding-1">
			<button type="submit">Отправить</button>
		</div>
	</form>
</div>