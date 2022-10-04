<div class="page max-page">
	<div class="block block-center block-row block-100 block-wrap">
		<?php if (empty($list)): ?>
                <p>Маршрутов нет</p>
            <?php else: ?>
                <?php foreach ($list as $val): ?>
                    <a href="/driver/look/<?php echo $val['id'] ?>" class="block block-30 block-column block-center text-center margin-3 text-16 border-black">
                    	<h3><?php echo $val['id'] ?></h3>
						<h3><?php echo $val['route_from'] ?></h3>
						<p><?php echo $val['route_to'] ?></p>
						<p><?php echo $val['description'] ?></p>
						<p><?php echo $val['cost'] ?></p>
						<span><?php echo $val['date'] ?></span>
						<span><?php echo $val['date_end'] ?></span>
						<span><?php echo $val['status'] ?></span>
					</a>
                <?php endforeach; ?>
                <div class="clearfix">
                    <?php echo $pagination; ?>
                </div>
        <?php endif; ?>
	</div>
</div>