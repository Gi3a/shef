<div class="page max-page">
	<div class="block block-center block-row block-100 tab">
		<a href="/profile/adverts" <?php if($this->route['action'] == 'adverts'){echo 'class="active"';} ?>><i class="fa fa-bullhorn"></i> Мои объявления</a>
		<a href="/profile/orders" <?php if($this->route['action'] == 'orders'){echo 'class="active"';} ?>><i class="fas fa-thumbtack"></i> Мои заказы</a>
		<a href="/profile/routes" <?php if($this->route['action'] == 'routes'){echo 'class="active"';} ?>><i class="far fa-compass"></i> Моя доставка</a>
	</div>
	<div class="block block-center block-row block-100 block-wrap">
		<?php if (empty($list)): ?>
                <p>Маршрутов нет</p>
            <?php else: ?>
                <?php foreach ($list as $val): ?>
                	<div class="block block-30 block-column block-center text-center margin-3 text-16 border-black">
	                    	<?php if($val['status'] == 'search'): ?>
								<i class="fa fa-search"></i>
							<?php else: ?>
								<i class="fas fa-car"></i>
	                    	<?php endif; ?>
							<h3><?php echo $val['route_from'] ?></h3>
							<p><?php echo $val['route_to'] ?></p>
							<p><?php echo $val['description'] ?></p>
							<p><?php echo $val['cost'] ?></p>
							<span><?php echo $val['date'] ?></span>
							<span><?php echo $val['date_end'] ?></span>
						<a href="/profile/route/cancel/<?php echo $val['id'] ?>" class="border-black">Отменить маршрут</a>
					</div>
                <?php endforeach; ?>
                <div class="clearfix">
                    <?php echo $pagination; ?>
                </div>
        <?php endif; ?>
	</div>
</div>