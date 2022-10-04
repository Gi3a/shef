<div class="page max-page">
	<div class="block block-center block-row block-40 block-wrap">
		<?php if (empty($notification)): ?>
                <p>Уведомлений нет</p>
            <?php else: ?>
                <p>Уведомлений (<?php echo $vars['notifications'] ?>)</p>
                <?php foreach ($notification as $val): ?>
                    <div class="block block-100 block-column block-center text-center margin-3 text-16 border-black">
                        <div><?php echo $val['id']; ?></div>
						<div><?php echo $val['type']; ?></div>
						<p><?php echo $val['description']; ?></p>
						<span><?php echo $val['date']; ?></span>
                        <a href="/notification/<?php echo $val['id']; ?>/clear"><i class="far fa-times-circle"></i></a>
					</div>
                <?php endforeach; ?>
                <div class="clearfix">
                    <?php echo $pagination; ?>
                </div>
        <?php endif; ?>
	</div>
</div>