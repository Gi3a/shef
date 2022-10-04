<div class="page max-page">
	<div class="block block-center block-row block-100 block-wrap">
		<?php foreach ($packages as $key => $val): ?>
		<div class="block block-center block-30 border-black block-column margin-3 text-center">
			<h3 class="margin-1"><?php echo $val['title']; ?></h3>
			<p class="margin-1"><?php echo $val['description']; ?></p>
			<span class="margin-1">Срок: <?php echo $val['days']; ?></span>
			<h4 class="margin-1"><b>Стоимость: <?php echo $val['cost']; ?></b></h4>
			<span class="margin-1">Количество объявлений: <?php echo $val['offers']; ?></span>
			<a href="/buy/packages/<?php echo $key; ?>" class="margin-1">Приобрести</a>
		</div>
		<?php endforeach; ?>
	</div>
</div>