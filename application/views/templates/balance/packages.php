<div class="page max-page">
	<div class="block block-center block-row block-100 block-wrap">
		<?php foreach ($packages as $key => $val): ?>
		<div class="block block-center block-30 border-black block-column margin-3 text-center">
			<h3 class="margin-1"><?php echo $val['title']; ?></h3>
			<p class="margin-1"><?php echo $val['description']; ?></p>
			<span class="margin-1">Срок: (от <?php echo $val['min_days']; ?>  до <?php echo $val['max_days']?>) дней</span>
			<h4 class="margin-1"><b>Стоимость: от <?php echo $val['cost']; ?></b></h4>
			<span class="margin-1">Количество объявлений: <?php echo $val['offers']; ?></span>
			<h6>* Стоимость может варироваться от срока</h6>
			<a href="/package/<?php echo $key; ?>" class="margin-1">Приобрести</a>
		</div>
		<?php endforeach; ?>
	</div>
</div>