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
                    <a href="/request/<?php echo $val['id'];?>" class="block block-100 block-row border-black">
                		<div class="block block-20 block-center">
                		</div>
                		<div class="block block-30 block-column block-center">
                			<span class="block block-100">Адрес: <?php echo $val['address'] ?></span>
                		</div>
                		<div class="block block-20 block-column block-center">
                			<span class="block block-100">Статус: <?php echo $val['status'] ?></span>
                			<span class="block block-100">Тип оплаты: <?php echo $val['pay'] ?></span>
                			<span class="block block-100">Тип доставки:  <?php echo $val['delivery'] ?></span>
                			<span class="block block-100">Время доставки: <?php echo $val['time_delivery'] ?></span>
                		</div>
                		<div class="block block-20 block-center block-column">
                            <?php if($val['status'] == 'search'): ?>
                    			<a class="padding-1" href="/request/<?php echo $val['id'] ?>/accept"><i class="fas fa-check"></i> Выполнить</a>
                                <a class="padding-1" href="/request/<?php echo $val['id'] ?>/decline"><i class="fas fa-times"></i> Отказать</a>
                            <?php elseif(($val['status'] == 'do') or ($val['delivery'] == 'delivery')): ?>
                                <a href="#">Драйвер выехал, ожидайте доставки</a>
                                
                            <?php endif; ?>
                		</div>
                    </a>
            <?php endforeach; ?>
                 <div class="clearfix">
                    <?php echo $pagination; ?>
                </div>
        <?php endif; ?>
	</div>
</div>