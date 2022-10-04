<div class="page max-page font-arial">
	<div class="block block-center block-row block-100 tab">
		<a href="/add/advert" <?php if($this->route['action'] == 'add'){echo 'class="active"';} ?>>Подать объявление</a>
		<a href="/create/order" <?php if($this->route['action'] == 'create'){echo 'class="active"';} ?>>Создать заказ</a>
		<a href="/conduct/action" <?php if($this->route['action'] == 'conduct'){echo 'class="active"';} ?>>Провести промо акцию</a>
	</div>
	<form enctype="multipart/form-data" class="form block-60 classic-form margin-4" action="/add/advert" method="POST">
		<div class="block block-center block-70 margin-2">
			<h3>Добавить объявление</h3>
		</div>
			<div class="block block-column block-center block-70 margin-2">
				<?php if ($limit == 1): ?>
					Вам доступно 1 объявление
				<?php elseif(($limit >= 2) and ($limit <= 4)): ?>
					Вам доступно <?php echo $limit; ?> объявления
				<?php elseif($limit == 0): ?>
					Достигнут лимит объявлений
				<?php else: ?>
					Вам доступно <?php echo $limit; ?> объявлений
				<?php endif ?>
				<a href="/packages">Больше объявлений</a>
			</div>		
		<div class="block block-center block-70 margin-2">
			<input type="text" name="title" placeholder="Название блюда">
		</div>
		<div class="block block-center block-70 margin-2">
			<textarea name="description" cols="30" rows="10" placeholder="Описание блюда"></textarea>
		</div>
		<div class="block block-center block-column block-70 margin-2">
			<span class="block block-center">Загрузите фото</span>
			<input class="block block-center" type="file" name="img" value="1">
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
			<textarea name="keywords" cols="30" rows="10" placeholder="Укажите ключевые слова. Например: шоколадный, мясной, вафли"></textarea>
		</div>
		<div class="block block-center block-70 margin-2">
			<div><span>Срочное (24 часа)</span><input type="radio" name="date_end" value="urgent"></div>
			<div><span>Обычное (7 дней)</span><input type="radio" name="date_end" value="common"></div>
			<?php if ($package == 'default'): ?>
				<div><a href="/packages"><span>Больше</span><input type="radio" name="date_end" value="package"></a></div>
			<?php elseif($package == 'monthly'): ?>
				<div><span>Пакет (31 день)</span><input type="radio" name="date_end" value="monthly"></div>
			<?php elseif($package == 'third'): ?>
				<div><span>Пакет (3 месяца)</span><input type="radio" name="date_end" value="third"></div>
			<?php elseif($package == 'half'): ?>
				<div><span>Пакет (6 месяцев)</span><input type="radio" name="date_end" value="half"></div>
			<?php elseif($package == 'yearly'): ?>
				<div><span>Пакет (1 год)</span><input type="radio" name="date_end" value="yearly"></div>
			<?php endif; ?>
		</div>
		<span class="block block-100" id="noti"></span>
		<div class="block block-center block-70 margin-2">
			<input type="text" id="address" class="input" name="city" placeholder="Укажите город">
		</div>
			<input type="hidden" name="type" value="advert">
		<div class="block block-center block-100 text-center margin-2">
			<button type="submit" class="block block-center block-100  text-center font-arial">
				Подать объявление
			</button>
		</div>
	</form>
</div>

<script src="/public/js/city.js"></script>	