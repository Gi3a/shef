<div class="page max-page">
	<h2 class="padding-1">Рекомендуемое <i class="fas fa-thumbs-up"></i></h2>
	<div class="block block-center block-row block-100 block-wrap offers">
		<?php if (empty($list)): ?>
                <p>Объявлений нет</p>
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