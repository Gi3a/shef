<div class="page max-page font-arial">
	<form  enctype="multipart/form-data" class="form block-60 classic-form margin-4" action="/edit/<?php echo $data['id']; ?>" method="POST">
		<div class="block block-center block-70 margin-2">
			<h3>Редактирование</h3>
		</div>
		<div class="block block-center block-70 margin-2">
			<input type="text" name="title" placeholder="Название блюда" value="<?php echo $data['title'] ?>">
		</div>
		<div class="block block-center block-70 margin-2">
			<textarea name="description" cols="40" rows="15" placeholder="Описание блюда"><?php echo $data['description'] ?></textarea>
		</div>
		<div class="block block-center block-column block-70 margin-2">
			<?php if ($data['photo'] == 1):?>
				<div class="block block-100 block-column">
					<div class="block">
						<a href="/delete/img/<?php echo $data['id']; ?>"><i class="fas fa-times"></i> Удалить фото</a>	
					</div>
					<div class="block block-img">
						<img class="block block-center margin-1" src="http://shef.s3.amazonaws.com/images/offers/<?php echo $data['id'] ?>/1.jpg" alt="image">
					</div>
				</div>
			<?php elseif($data['photo'] == 0): ?>
				<span class="block block-center">Загрузить фото</span>
				<input class="block block-center" type="file" name="img">
			<?php endif;  ?>
		</div>
		<div class="block block-center block-70 margin-2">
			<input type="number" name="cost" placeholder="Укажите цену" min="1" max="1000000" value="<?php echo $data['cost'] ?>">
		</div>
		<div class="block block-center block-70 margin-2">
			<select name="category">
		<?php if (empty($list)): ?>
                <option type="hidden">Категории не найдены</option>
            <?php else: ?>
                <?php foreach ($list as $val): ?>
                    <option value="<?php echo $val['category'] ?>" <?php if($val['category'] == $data['category']){echo 'selected';} ?>><?php echo $val['category'] ?></option>
                <?php endforeach; ?>
        <?php endif; ?>
			</select>
		</div>
		<div class="block block-center block-70 margin-2">
			<input type="text" name="city" placeholder="Укажите город" value="<?php echo $data['city'] ?>">
		</div>
		<div class="block block-center block-100 text-center margin-2">
			<button type="submit" class="block block-center block-100  text-center font-arial">
				Сохранить
			</button>
		</div>
	</form>
</div>