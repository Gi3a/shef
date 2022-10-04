<div class="page max-page main-page">

	<div class="block block-100 block-column wrapper relative margin-bottom-5">
		<div class="wrapper-img" style="background: url(http://shef.s3.amazonaws.com/images/offers/<?php echo $random_background; ?>/1.jpg);"></div>
		<div class="block block-center block-column block-70 margin-1 wrapper-title absolute left-15 top-20">
			<div class="block block-100 block-center main-logotype">
				<i class="logo big-white"></i>
			</div>
			<div class="block block-100 block-center block-column">
				<h2 class="margin-1">Food Marketplace</h2>
				<h3 class="margin-1">Крупная онлайн платформа для купле/продажи еды</h3>
			</div>
		</div>

		<div class="block block-50 margin-3 absolute wrapper-form left-25 top-60">
			<form action="/search/" method="GET" class="search-form" id="search">
				<button type="submit"><i class="fas fa-search"></i></button>
				<input type="text" placeholder="Например: Малиновый пуддинг, роллы с лососем, пицца по итальянски, борщ, манты" name="v">
			</form>
		</div>
		<div class="block block-100 wrapper-info absolute bottom-10">
			<div class="block wrapper-author absolute left-5">
				<a class="color-white" href="/advert/<?php echo $random_background; ?>">Фото взято из объявления</a>
			</div>
			<div class="block wrapper-how absolute right-5">
				<a class="color-white" href="#">Как оказаться здесь</a>
			</div>
		</div>
	</div>

	<div class="block block-center block-row block-100 block-wrap margin-bottom-3 actions">
		<h3 class="block block-90"><a href="/actions">Акции</a></h3>
		<?php if (empty($actions)): ?>
        <?php else: ?>
                <?php foreach ($actions as $val): ?>
                	<div class="action">
                		<div class="action-img">
                			<img src="http://shef.s3.amazonaws.com/images/actions/<?php echo $val['id'] ?>/1.jpg" alt="<?php echo $val['title'] ?>">
                		</div>
                		<div class="action-text">
                			<span class="action-title"><?php echo $val['title'] ?></span>
                			<span class="action-code"><?php echo $val['code'] ?></span>
	                    	<span class="action-description"><?php echo $val['description'] ?></span>
                		</div>
                	</div>
                <?php endforeach; ?>
        <?php endif; ?>
	</div>

	<div class="block block-center block-row block-100 block-wrap margin-bottom-3">
		<h3 class="block block-90"><a href="/adverts">Объявления</a></h3>
		<?php if (empty($adverts)): ?>
        <?php else: ?>
                <?php foreach ($adverts as $val): ?>
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
        <?php endif; ?>
	</div>
	<div class="block block-center block-row block-100 block-wrap  margin-bottom-3">
		<h3 class="block block-90"><a href="/orders">Заказы</a></h3>
		<?php if (empty($orders)): ?>
            <?php else: ?>
                <?php foreach ($orders as $val): ?>
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
        <?php endif; ?>
	</div>
	<div class="block block-center block-row block-100 block-wrap margin-bottom-3">
		<h3 class="block block-90"><a href="/hot">Горячее</a></h3>
		<?php if (empty($hots)): ?>
                <p>Пусто</p>
            <?php else: ?>
                <?php foreach ($hots as $val): ?>
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
        <?php endif; ?>
	</div>
	<div class="block block-center block-row block-100 block-wrap margin-bottom-3">
		<h3 class="block block-90"><a href="/recomended">Рекомендованное</a></h3>
		<?php if (empty($recomended)): ?>
                <p>Пусто</p>
            <?php else: ?>
                <?php foreach ($recomended as $val): ?>
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
        <?php endif; ?>
	</div>
	<div class="block block-100 block-center margin-bottom-5">
		<a href="#" class="btn-modern">Пройти тест <i class="fas fa-mortar-pestle"></i></a>
	</div>
</div>

<script>

 $( "#search" ).change(function() {

	var value=$("input[name$='v']").val();
	var type= 'advert';
	var category= 'all';
	var sort= 'id';
	var cost_from= 0;
	var cost_to= 999999;
	var city= 'all';
	if (value == '') {value='list';}
	if (cost_from == '') {cost_from=0;}
	if (cost_to == '') {cost_to=999999;}
	if (city == '') {city='all';}
	var search = [value,type,category,sort,cost_from,cost_to,city];
	$.ajax({
	        type: "GET",
	        url: "/search/",
	        data:"search",
	        dataType:"html",
	        success: function(html){
		       $(location).attr('href','/search/search?search='+search);
		    }
		});
});
</script>