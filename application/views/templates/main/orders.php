<div class="page max-page">
	<div class="block block-center block-row block-100 margin-1">
		<div class="block block-20 block-center">
			<span>Категория</span>
			<select name="category" onchange="top.location=this.value">
				<option value="/orders">Все</option>
				<option value="/orders/soup">Супы</option>
				<option value="/orders/breakfast">Завтраки</option>
				<option value="/orders/snack">Закуски</option>
			</select>
		</div>
		<div class="block block-20 block-center">
			<span>Сортировать</span>
			<form action="/orders/" method="GET">
				<select name="sort" onchange="this.form.submit()">
					<option <?php if(!empty($this->route['sort']) and substr($this->route['sort'], 6) == '') {echo 'selected';} ?> value="id">Все</option>
					<option <?php if(!empty($this->route['sort']) and substr($this->route['sort'], 6) == 'date') {echo 'selected';} ?> value="date">Свежее</option>
					<option <?php if(!empty($this->route['sort']) and substr($this->route['sort'], 6) == 'cost') {echo 'selected';} ?> value="cost">Дешевое</option>
					<option <?php if(!empty($this->route['sort']) and substr($this->route['sort'], 6) == 'date_end') {echo 'selected';} ?> value="date_end">Скоро закончится</option>
				</select>
			</form>
		</div>
	</div>
	<div class="block block-center block-row block-100 block-wrap offers">
		<?php if (empty($list)): ?>
                <p>Заказов нет</p>
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