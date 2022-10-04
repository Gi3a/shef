<div class="page max-page">
	<div class="block block-center block-row block-100 tab">
		<a href="/profile/adverts" <?php if($this->route['action'] == 'adverts'){echo 'class="active"';} ?>><i class="fa fa-bullhorn"></i> Мои объявления</a>
		<a href="/profile/orders" <?php if($this->route['action'] == 'orders'){echo 'class="active"';} ?>><i class="fas fa-thumbtack"></i> Мои заказы</a>
		<a href="/profile/routes" <?php if($this->route['action'] == 'routes'){echo 'class="active"';} ?>><i class="far fa-compass"></i> Моя доставка</a>
	</div>
	<div class="block block-center block-row block-100 block-wrap offers">
		<?php if (empty($list)): ?>
                <p>Моих объявлений нет</p>
            <?php else: ?>
            	<div class="size"></div>
                <?php foreach ($list as $val): ?>
                	<div class="offer relative">
	                    <a href="/<?php echo $val['type'] ?>/<?php echo $val['id'] ?>">
	                    	<div class="offer-status absolute color-white">
								<span class="offer-views"><i class="fas fa-eye"></i> <?php echo $val['views'] ?></span>
								<span class="offer-likes"><i class="fas fa-heart"></i> <?php echo $val['liked'] ?></span>
	                    	</div>
	                    	<div class="offer-img">
	                    		<img src="http://shef.s3.amazonaws.com/images/offers/<?php echo $val['id'] ?>/1.jpg" alt="<?php echo $val['title'] ?>">
	                    	</div>
	                    	<div class="offer-text absolute color-white">
	                    		<span class="offer-title"><?php echo $val['title'] ?></span>
	                    		<span class="offer-cost"><?php echo $val['cost'] ?></span>
	                    		<span class="offer-city"><?php echo $val['city'] ?></span>
	                    		<span class="offer-category"><?php echo $val['category'] ?></span>
	                    	</div>
						</a>
						<?php if (($val['status'] == 0) and ($val['priority'] != 1.5) ): ?>
							<a href="/activate/<?php echo $val['id'] ?>" class="border-black margin-1">Активировать</a>
						<?php elseif(($val['status'] == 1) and ($val['priority'] != 1.5) ): ?>
							<a href="/deactivate/<?php echo $val['id'] ?>" class="border-black margin-1"> Деактивировать</a>
						<?php endif ?>
						<a href="/edit/<?php echo $val['id'] ?>" class="border-black margin-1">Редактировать</a>
						<a href="/delete/<?php echo $val['id'] ?>" class="border-black margin-1">Удалить</a>
					</div>
                <?php endforeach; ?>
                 <div class="clearfix">
                    <?php echo $pagination; ?>
                </div>
        <?php endif; ?>
	</div>
</div>

<script>
var $grid = $('.offers').masonry({itemSelector: '.offer',percentPosition: true,columnWidth: '.size'});
$grid.imagesLoaded().progress( function() {$grid.masonry();});
</script>