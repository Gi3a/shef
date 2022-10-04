<div class="page max-page">
	<div class="block block-center block-row block-100 block-wrap">
		<div class="block block-center block-30 border-black block-column margin-3 text-center">
			<h3 class="margin-1"><?php echo $package['title']; ?></h3>
			<p class="margin-1"><?php echo $package['description']; ?></p>
			<span class="margin-1">
				Срок: <input type="number"  min="<?php echo $package['min_days']; ?>" max="<?php echo $package['max_days']; ?>" value="<?php echo $package['min_days']; ?>"> дней
				</span>
			<h4 class="margin-1"><b>Стоимость: <?php echo $package['cost']; ?></b></h4>
			<span class="margin-1">Количество объявлений: <?php echo$package['offers']; ?></span>
			<a href="/package/<?php echo $this->route['id']; ?>/buy" class="margin-1">Перейти к оплате</a>
		</div>
	</div>
</div>