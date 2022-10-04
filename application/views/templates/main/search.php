<div class="page max-page">
	<div class="block block-center block-row block-100 margin-1" style="background: #F5C99B;">
		<form action="/search/" class="block block-100 block-row search-form" id="search">
			<div class="block block-20 block-column block-center">
				<div class="block block-100 block-center margin-1">
					<span>Тип</span>
					<select name="t">
						<option value="advert" <?php if(!empty($params) and ($params['type'] == 'advert')){echo 'selected';} ?>>Объявления</option>
						<option value="order" <?php if(!empty($params) and ($params['type'] == 'order')){echo 'selected';} ?>>Заказы</option>
					</select>
				</div>
				<div class="block block-100 block-center margin-1">
					<span>Категория</span>
					<select name="c">
						<option value="all" <?php if(!empty($params) and ($params['category'] == 'all')){echo 'selected';} ?>>Все</option>
						<option value="soup" <?php if(!empty($params) and ($params['category'] == 'soup')){echo 'selected';} ?>>Супы</option>
						<option value="breakfast" <?php if(!empty($params) and ($params['category'] == 'breakfast')){echo 'selected';} ?>>Завтраки</option>
						<option value="snack" <?php if(!empty($params) and ($params['category'] == 'snack')){echo 'selected';} ?>>Закуски</option>
					</select>
				</div>
			</div>
			<div class="block block-50 block-column" style="position: relative;">
				<input type="text" placeholder="Поиск" name="v" value="<?php if(!empty($params) and ($params['value'] != '') and ($params['value'] != 'list')){echo $params['value'];} ?>" placeholder="Например: Малиновый пуддинг, роллы с лососем, пицца по итальянски, борщ, манты">
				<button type="submit"><i class="fa fa-search"></i></button>
				<?php if(!empty($params)): ?>
					<a href="/search/"><i class="fas fa-times"></i> Сброс</a>
				<?php endif; ?>
			</div>
			<div class="block block-20 block-column block-center">
				<div class="block block-90 block-center margin-1">
					<span>Сортировать</span>
					<select name="s">
						<option value="id" <?php if(!empty($params) and ($params['sort'] == 'id')){echo 'selected';} ?>>Все</option>
						<option value="date" <?php if(!empty($params) and ($params['sort'] == 'date')){echo 'selected';} ?>>Дате</option>
						<option value="cost" <?php if(!empty($params) and ($params['sort'] == 'cost')){echo 'selected';} ?>>Цена</option>
						<option value="views" <?php if(!empty($params) and ($params['sort'] == 'views')){echo 'selected';} ?>>Просмотров</option>
						<option value="liked" <?php if(!empty($params) and ($params['sort'] == 'liked')){echo 'selected';} ?>>Понравившиемся</option>
					</select>
				</div>
				<div class="block block-100 block-center block-column margin-1">
					<div class="block block-row block-100 margin-1">
						<input type="text" placeholder="От" name="cf" value="<?php if(!empty($params) and ($params['cost_from'] != '') and ($params['cost_from'] != '0')){echo $params['cost_from'];} ?>">
						<input type="text" placeholder="До" name="ct" value="<?php if(!empty($params) and ($params['cost_to'] != '') and ($params['cost_to'] != '999999')){echo $params['cost_to'];} ?>">
					</div>
					<div class="block block-row block-100 margin-1">
					<span class="block block-100" id="noti"></span>
					<input type="text" id="address" class="input" name="geo" placeholder="Город" value="<?php if(!empty($params) and ($params['city'] != '') and ($params['city'] != 'all')){echo $params['city'];} ?>">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="block block-center block-row block-100 block-wrap offers" id="offers">
		<?php if (empty($list)): ?>
                <?php if (!empty($params)): ?>
                	<p>Ничего не найдено</p>
                <?php endif ?>
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
	</div>
	<div class="block block-100 block-center margin-bottom-3">
		<a href="#" class="btn-modern">Загрузить еще <i class="fas fa-caret-down"></i></a>
	</div>
	<?php endif; ?>
</div>

<script>

 $( "#search" ).change(function() {

	var value=$("input[name$='v']").val();
	var type=$("select[name$='t']").val();
	var category=$("select[name$='c']").val();
	var sort=$("select[name$='s']").val();
	var cost_from=$("input[name$='cf']").val();
	var cost_to=$("input[name$='ct']").val();
	var city=$("input[name$='geo']").val();
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

var $grid = $('.offers').masonry({itemSelector: '.offer',percentPosition: true,columnWidth: '.size'});
$grid.imagesLoaded().progress( function() {$grid.masonry();});
</script>