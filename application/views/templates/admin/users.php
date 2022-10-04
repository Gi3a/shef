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
							<p><?php echo $val['company'] ?></p>
							<p><?php echo $val['package'] ?></p>
							<p><?php echo $val['role'] ?></p>
							<p><?php echo $val['date'] ?></p>
							<p><?php echo $val['description'] ?></p>
							<p><?php echo $val['status'] ?></p>

						<?php if ($val['status'] == 1): ?>
							<a href="/admin/user/<?php echo $val['id'] ?>/pause" class="border-black"><i class="fas fa-pause"></i> Заморозить</a>
						<?php else: ?>
							<a href="/admin/user/<?php echo $val['id'] ?>/activate" class="border-black"><i class="fas fa-pause"></i> Активировать</a>
						<?php endif ?>
						<a href="/admin/user/<?php echo $val['id'] ?>/clean" class="border-black"><i class="fas fa-trash-alt"></i> Удалить</a>
					</div>
                <?php endforeach; ?>
                <div class="clearfix">
                    <?php echo $pagination; ?>
                </div>
        <?php endif; ?>
	</div>
</div>