<div class="page max-page">
	<div class="block block-center block-row block-100 block-wrap">
		<?php if (empty($list)): ?>
                <p>Маршрутов нет</p>
            <?php else: ?>
                <?php foreach ($list as $val): ?>
                    <div class="block block-30 block-column block-center text-center margin-3 text-16 border-black">
                    	<h1><?php echo $val['id'] ?></h1>
						<h3>Откуда <?php echo $val['route_from'] ?></h3>
						<h3>Куда <?php echo $val['route_to'] ?></h3>
						<span>Заказчик <?php echo $val['client_email'] ?></span>
						<span>Исполнитель <?php echo $val['executor_email'] ?></span>
						<p>Описание <?php echo $val['description'] ?></p>
						<p>Цена <?php echo $val['cost'] ?></p>
						<span>Статус <?php echo $val['status'] ?></span>
						<span>Создание <?php echo date("d.m.Y в h:m", strtotime($val['date'])); ?></span>
						<span>Конец <?php echo date("d.m.Y в h:m", strtotime($val['date_end'])); ?></span>
					</div>
                <?php endforeach; ?>
                <div class="clearfix">
                    <?php echo $pagination; ?>
                </div>
        <?php endif; ?>
	</div>
</div>