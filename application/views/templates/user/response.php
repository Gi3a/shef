<div class="page max-page">
	<div class="block block-center block-row block-100 tab">
		<a href="/requests" <?php if($this->route['action'] == 'requests'){echo 'class="active"';} ?>>Запросы</a>
		<a href="/response" <?php if($this->route['action'] == 'response'){echo 'class="active"';} ?>> Ответы</a>
	</div>
	<div class="block block-100 block-column block-center">
		<?php if (empty($list)): ?>
                <p>Запросов нет</p>
            <?php else: ?>
            <?php foreach ($list as $val): ?>
            	<div class="block block-100 block-row">
            		<div class="block block-30">
            			<div class="block-img">
	                    	<img src="http://shef.s3.amazonaws.com/images/offers/<?php echo $val['offer_id'] ?>/1.jpg" alt="<?php echo $val['title'] ?>">
	                    </div>
            		</div>
            		<div class="block block-40 block-column">
            			<span class="block block-100">Адрес: <?php echo $val['address'] ?></span>
            			<span class="block block-100">Опинсание: <?php echo $val['description'] ?></span>
            			<span class="block block-100">Кол-во: <?php echo $val['count'] ?></span>
            		</div>
            		<div class="block block-30 block-column">
            			<span class="block block-100">Статус: <?php echo $val['status'] ?></span>
            			<span class="block block-100">Тип оплаты: <?php echo $val['pay'] ?></span>
            			<span class="block block-100">Тип доставки:  <?php echo $val['delivery'] ?></span>
            			<span class="block block-100">Время доставки: <?php echo $val['time_delivery'] ?></span>
            		</div>
            	</div>
            <?php endforeach; ?>
                 <div class="clearfix">
                    <?php echo $pagination; ?>
                </div>
        <?php endif; ?>
	</div>
</div>