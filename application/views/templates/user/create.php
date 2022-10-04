<div class="page max-page font-arial">
	<div class="block block-center block-row block-100 tab">
		<a href="/add/advert" <?php if($this->route['action'] == 'add'){echo 'class="active"';} ?>>Подать объявление</a>
		<a href="/create/order" <?php if($this->route['action'] == 'create'){echo 'class="active"';} ?>>Создать заказ</a>
		<a href="/conduct/action" <?php if($this->route['action'] == 'conduct'){echo 'class="active"';} ?>>Провести промо акцию</a>
	</div>
	<form class="form block-60 classic-form margin-4" action="/create/order" method="POST">
		<div class="block block-center block-70 margin-2">
			<h3>Создать заказ</h3>
		</div>
		<div class="block block-center block-70 margin-2">
			<input type="text" name="title" placeholder="Название блюда">
		</div>
		<div class="block block-center block-70 margin-2">
			<textarea name="description" cols="30" rows="10" placeholder="Описание блюда"></textarea>
		</div>
		<div class="block block-center block-column block-70 margin-2">
			<span class="block block-center">Загрузите фото</span>
			<input class="block block-center" type="file" name="img">
		</div>
		<div class="block block-center block-70 margin-2">
			<input type="number" name="cost" placeholder="Укажите цену" min="1" max="1000000">
		</div>
		<div class="block block-center block-70 margin-2">
			<select name="category">
			<?php if (empty($data)): ?>
                <option type="hidden">Категории не найдены</option>
            <?php else: ?>
                <?php foreach ($data as $val): ?>
                    <option value="<?php echo $val['category'] ?>"><?php echo $val['category'] ?></option>
                <?php endforeach; ?>
        <?php endif; ?>
			</select>
		</div>
		<div class="block block-center block-70 margin-2">
			<div><span>Час</span><input type="radio" name="date_end" value="1"></div>
			<div><span>2 часа</span><input type="radio" name="date_end" value="2"></div>
			<div><span>3 часа</span><input type="radio" name="date_end" value="3"></div>
		</div>
		<div class="block block-center block-70 margin-2">
			<input type="text" name="city" placeholder="Укажите город">
		</div>
			<input type="hidden" name="type" value="order">
		<div class="block block-center block-100 text-center margin-2">
			<button type="submit" class="block block-center block-100  text-center font-arial">
				Создать заказ
			</button>
		</div>
	</form>
</div>