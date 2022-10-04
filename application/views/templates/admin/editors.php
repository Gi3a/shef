<div class="page max-page">
	<div class="block block-center block-row block-100 block-wrap">
		<?php if (empty($list)): ?>
                <p>Список пуст</p>
            <?php else: ?>
                <?php foreach ($list as $val): ?>
                	<div class="block block-30 block-column block-center text-center margin-3 text-16 border-black">
                		<h1><?php echo $val['id'] ?></h1>
							<h3><?php echo $val['email'] ?></h3>
							<p><?php echo $val['name'] ?></p>
							<p><?php echo $val['phone'] ?></p>
							<p><?php echo $val['role'] ?></p>
						<a href="/admin/member/<?php echo $val['id'] ?>/delete" class="border-black">Удалить</a>
					</div>
                <?php endforeach; ?>
                <div class="clearfix">
                    <?php echo $pagination; ?>
                </div>
        <?php endif; ?>
	</div>
</div>