<div class="page">
	<div class="block block-100 block-row">
		<div class="block block-20 block-center relative">
			<div class="block block-15 block-column left-0 top-0 border-black fixed left-0 top-10 margin-1 padding-1">
				<div class="block block-100 block-column">
				<?php if ($data['photo'] != 0):?>
					<div class="block block-100 block-img">
						<img src="https://s3.eu-central-1.amazonaws.com/shef/images/users/<?php echo $data['id']; ?>/1.jpg" alt="image">
					</div>
				<?php endif; ?>
					<div class="block block-100 block-column block-center">
						<span class="block block-100"><?php echo $data['name']; ?></span>
						<span class="block block-100 padding-1"><?php if ($data['role'] == 'company'): ?>Компания</span>
						<?php elseif($data['role'] == 'driver'): ?>Драйвер</span>
						<?php else: ?>Пользователь</span>
						<?php endif; ?>
						<span class="block block-100"><?php echo $data['phone']; ?></span>
						<span class="block block-100"><a href="http://shef/@<?php echo $data['login']; ?>">shef/@<?php echo $data['login']; ?></a></span>
						<span class="block block-100 padding-1">На Shef с<?php echo date("M-Y" , strtotime($data['date'])); ?></span>
					<?php if ((!empty($_SESSION)) AND ($_SESSION['user']['id'] == $this->route['id'])): ?>
						<span class="block block-100"><a href="/settings/<?php echo $_SESSION['user']['id']; ?>"><i class="fa fa-cog"></i> Настройки</a></span>
					<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
