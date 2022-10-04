<div class="page max-page">
	<div class="block block-center block-row block-100 block-wrap">
		<?php if (empty($list)): ?>
                <p>Список пуст</p>
            <?php else: ?>
                <?php foreach ($list as $val): ?>
                	<div class="block block-30 block-column block-center text-center margin-3 text-16 border-black">
	                    <a href="/admin/contact/<?php echo $val['id'] ?>">
	                    	<h1><?php echo $val['id'] ?></h1>
							<h3><?php echo $val['type'] ?></h3>
							<p><?php echo $val['email'] ?></p>
							<p><?php echo $val['title'] ?></p>
							<p><?php echo $val['description'] ?></p>
							<span><?php echo $val['date'] ?></span>
						</a>
						<a href="/uncontact/<?php echo $val['id'] ?>" class="border-black">Удалить</a>
					</div>
                <?php endforeach; ?>
                <div class="clearfix">
                    <?php echo $pagination; ?>
                </div>
        <?php endif; ?>
	</div>
</div>