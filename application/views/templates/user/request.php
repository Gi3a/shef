<div class="page">
	<div class="block block-100 block-column margin-1">
		<div class="block block-100 block-center block-column">
			<span><?php echo $data['address']; ?></span>
			<span><?php echo $data['promocode'] ?></span>
			<span><?php echo $data['pay'] ?></span>
			<span><?php echo $data['delivery'] ?></span>
			<span><?php echo $data['time_delivery'] ?></span>
			<span><?php echo $data['date'] ?></span>
			<span><?php echo $data['offer_customer'] ?></span>
			<span><?php echo $data['status'] ?></span>
			<?php if ($_SESSION['user']['email'] == $data['offer_email']):?>
				<a href="#">Выполнять</a>
				<a href="#">Не выполнять</a>
			<?php endif; ?>
		</div>
		<div class="block block-center block-row block-100 block-wrap offers">
		<?php if (empty($offers)): ?>
                <p>Моих понравившихся нет</p>
            <?php else: ?>
            	<div class="size"></div>
                <?php foreach ($offers as $val): ?>
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
</div>


<script>
var $grid = $('.offers').masonry({itemSelector: '.offer',percentPosition: true,columnWidth: '.size'});
$grid.imagesLoaded().progress( function() {$grid.masonry();});
</script>