<div class="page max-page font-arial">
	<div class="block block-row block-center block-50">
		<div class="block block-column block-50 border-black">
			<?php echo $data['description']; ?>
		</div>
		<div class="block block-column block-50 border-black">
			<span class="block text-16">
				Заказчик: <a href="profile/<?php  echo $data['client_email']; ?>" ><?php echo $data['client_email']; ?></a>
			</span>
			<span class="block text-16">
				Откуда: <?php echo $data['route_from']; ?>
			</span>
			<span class="block text-16">
				Куда: <?php echo $data['route_to']; ?>
			</span>
			<span class="block text-16">
				Цена: <?php echo $data['cost']; ?>
			</span>
			<span class="block text-16">
				Создан: <?php echo $data['date']; ?>
			</span>
			<span class="block text-16">
				Срок: <?php echo $data['date_end']; ?>
			</span>
		</div>
	</div>
	<div class="block block-center block-100 border-black">
		<a href="/driver/route/<?php echo $data['id'] ?>/accept" class="block margin-1">Принять</a>
		<a href="/driver/routes" class="block margin-1">Отмена</a>
	</div>
</div>