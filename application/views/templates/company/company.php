<div class="page">
	<div class="block block-100 block-row">
		<div class="block block-20 block-center relative">
			<div class="block block-15 block-column left-0 top-0 border-black fixed left-0 top-10 margin-1 padding-1">
				<div class="block block-100 block-column">
				<?php if ($data['photo'] != 0):?>
					<div class="block block-100 block-img">
						<img src="http://shef.s3.amazonaws.com/images/users/<?php echo $data['id']; ?>/1.jpg" alt="image">
					</div>
				<?php endif; ?>
					<div class="block block-100 block-column block-center">
						<span class="block block-100 padding-1"><?php if ($data['role'] == 'company'): ?>Компания <?php echo $data['company']?></span>
						<?php if (($data['working_on'] != NULL) and ($data['working_off'] != NULL)): ?>
							<span class="block block-100 padding-1"><?php echo $data['working']; ?></span>
						<?php endif ?>
						<?php else: ?>Пользователь</span><?php endif; ?>
						<span class="block block-100"><?php echo $data['phone']; ?></span>
						<span class="block block-100"><a href="http://shef/@<?php echo $data['login']; ?>">shef/@<?php echo $data['login']; ?></a></span>
						<span class="block block-100 padding-1">На Shef с <?php echo date("M-Y" , strtotime($data['date'])); ?></span>
						<?php if ((!empty($_SESSION)) AND ($_SESSION['user']['id'] == $this->route['id'])): ?>
							<span class="block block-100"><a href="/settings/<?php echo $_SESSION['user']['id']; ?>"><i class="fa fa-cog"></i> Настройки</a></span>
						<?php endif; ?>
						<?php
							$date_time_array = getdate( time() );
							echo $date_time_array['weekday'];
 						?>
					</div>
				</div>
			</div>
		</div>
		<div class="block block-80 border-black block-column margin-3 padding-3" style="float: right">
			<div class="block block-100 block-column block-center">
				<span class="block block-100 padding-1"><?php echo $data['name']; ?></span>
				<p class="block block-100 pading-1"><?php echo $data['description']; ?></p>
			</div>
			<hr>
			<div class="block block-100 block-wrap offers">
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
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<script>
var $grid = $('.offers').masonry({itemSelector: '.offer',percentPosition: true,columnWidth: '.size'});
$grid.imagesLoaded().progress( function() {$grid.masonry();});
</script>