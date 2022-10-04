<div class="page max-page font-arial">
	<div class="block block-center block-row block-100 tab">
		<a href="/add/advert" <?php if($this->route['action'] == 'advert'){echo 'class="active"';} ?>>Подать объявление</a>
		<a href="/create/order" <?php if($this->route['action'] == 'order'){echo 'class="active"';} ?>>Создать заказ</a>
		<a href="/conduct/action" <?php if($this->route['action'] == 'conduct'){echo 'class="active"';} ?>>Провести промо акцию</a>
	</div>
	<form class="form block-60 classic-form margin-4" action="/conduct/action" method="POST">
		<div class="block block-center block-70 margin-2">
			<h3>Провести промо акцию</h3>
		</div>
		<div class="block block-center block-70 margin-2">
			<input type="text" name="title" placeholder="Название промо акции">
		</div>
		<div class="block block-center block-70 margin-2">
			<textarea name="description" cols="30" rows="10" placeholder="Описание акции"></textarea>
		</div>
		<div class="block block-center block-column block-70 margin-2">
			<span class="block block-center">Загрузите фото</span>
			<input class="block block-center" type="file" name="img">
		</div>
		<div class="block block-center block-column block-70 margin-2">
			<input type="text" name="code" placeholder="Промокод">
		</div>
		<div class="block block-center block-70 margin-2">
			Срок
			<div><span>Неделя</span><input type="radio" name="date_end" value="week"></div>
			<div><span>Месяц</span><input type="radio" name="date_end" value="month"></div>
			<div><span>Пол года</span><input type="radio" name="date_end" value="half"></div>
		</div>
		<div class="block block-center block-70 margin-2">
			<input type="text" name="city" placeholder="Укажите город">
		</div>
		<div class="block block-center block-100 text-center margin-2">
			<button type="submit" class="block block-center block-100  text-center font-arial">
				Добавить промо акцию
			</button>
		</div>
	</form>
</div>