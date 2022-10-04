<div class="page max-page font-arial">
	<form enctype="multipart/form-data" class="form classic-form margin-1" action="/settings/<?php echo $_SESSION['user']['id']; ?>" method="POST">
		<div class="block block-center block-40 margin-1">
			<h3>Настройки аккаунта</h3>
		</div>
		<div class="block block-center block-column block-40 margin-1">
			
			<?php if ($img == true):?>
					<div class="block">
						<a href="/delete/profile/img/<?php echo $data['id']; ?>"><i class="fas fa-times"></i> Удалить фото</a>	
					</div>
					<img src="http://shef.s3.amazonaws.com/images/users/<?php echo $data['id']; ?>/1.jpg" alt="image">
			<?php elseif($img == false): ?>
				<span class="block block-center">Фото</span>
				<input type="file"  class="block block-center" name="img">
			<?php endif; ?>
		</div>
		<div class="block block-center block-40 margin-1">
			E-mail
			<input type="text" name="email" placeholder="E-mail" value="<?php echo $_SESSION['user']['email']; ?>" readonly>
		</div>
		<div class="block block-center block-40 margin-1">
			Логин
			<input type="text" name="login" placeholder="Login" value="<?php echo $_SESSION['user']['login']; ?>">
		</div>
		<div class="block block-center block-40 margin-1">
			Имя
			<input type="text" name="name" placeholder="Имя" value="<?php echo $_SESSION['user']['name']; ?>">
		</div>
		<div class="block block-center block-40 margin-1">
			Телефон
			<input type="tel" name="phone" placeholder="Номер телефона" value="<?php echo $_SESSION['user']['phone']; ?>">
		</div>
		<div class="block block-center block-40 margin-1">
			<textarea type="text" name="description" cols="100" rows="10" placeholder="Расскажите о себе"><?php echo $_SESSION['user']['description']; ?></textarea>
		</div>
		<div class="block block-center block-40 margin-1">
			Время работы
			<div>
				<?php $working_on = explode('-',$_SESSION['user']['working_on']); ?>
				<span>С</span>
				<select name="working_on_date">
					<option <?php if((!empty($working_on)) and ($working_on[0] == 'Mon')){echo 'selected';} ?> value="Mon">Понедельник</option>
					<option <?php if(($working_on != NULL) and ($working_on[0] == 'Tue')){echo 'selected';} ?> value="Tue">Вторник</option>
					<option <?php if(($working_on != NULL) and ($working_on[0] == 'Wed')){echo 'selected';} ?> value="Wed">Среда</option>
					<option <?php if(($working_on != NULL) and ($working_on[0] == 'Thu')){echo 'selected';} ?> value="Thu">Четверг</option>
					<option <?php if(($working_on != NULL) and ($working_on[0] == 'Fri')){echo 'selected';} ?> value="Fri">Пятница</option>
					<option <?php if(($working_on != NULL) and ($working_on[0] == 'Sat')){echo 'selected';} ?> value="Sat">Суббота</option>
					<option <?php if(($working_on != NULL) and ($working_on[0] == 'Sun')){echo 'selected';} ?> value="Sun">Воскресенье</option>
				</select>
				<input type="time" name="working_on_time"
               min="0:00" max="0:00" required  value="<?php echo $working_on[1].':'.$working_on[2]; ?>"/>
			</div>
			<div>
				<?php $working_off = explode('-',$_SESSION['user']['working_off']); ?>
				<span>До</span>
				<select name="working_off_date">
					<option <?php if((!empty($working_off)) and ($working_off[0] == 'Mon')){echo 'selected';} ?> value="Mon">Понедельник</option>
					<option <?php if(($working_off != NULL) and ($working_off[0] == 'Tue')){echo 'selected';} ?> value="Tue">Вторник</option>
					<option <?php if(($working_off != NULL) and ($working_off[0] == 'Wed')){echo 'selected';} ?> value="Wed">Среда</option>
					<option <?php if(($working_off != NULL) and ($working_off[0] == 'Thu')){echo 'selected';} ?> value="Thu">Четверг</option>
					<option <?php if(($working_off != NULL) and ($working_off[0] == 'Fri')){echo 'selected';} ?> value="Fri">Пятница</option>
					<option <?php if(($working_off != NULL) and ($working_off[0] == 'Sat')){echo 'selected';} ?> value="Sat">Суббота</option>
					<option <?php if(($working_off != NULL) and ($working_off[0] == 'Sun')){echo 'selected';} ?> value="Sun">Воскресенье</option>
				</select>
				<input type="time" name="working_off_time"
               min="0:00" max="0:00" required  value="<?php echo $working_off[1].':'.$working_off[2]; ?>"/>
			</div>
		</div>
		<div class="block block-center block-40 margin-1">
			<input type="password" name="password" placeholder="Новый пароль">
		</div>
		<div class="block block-center block-100 text-center margin-1">
			<button type="submit" class="block block-center block-100  text-center font-arial">
				Сохранить
			</button>
		</div>
	</form>
</div>