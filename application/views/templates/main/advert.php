<div class="page">
	<div class="block block-100 block-column relative">

		<div class="block block-50 block-column block-center padding-2">
			<span><?php echo $data['title']; ?></span>
			<div class="block block-100 block-img">
				<img class="block block-center margin-1" src="http://shef.s3.amazonaws.com/images/offers/<?php echo $data['id'] ?>/1.jpg" alt="<?php echo $data['title']; ?>">
			</div>
		</div>
		<div class="block block-20 block-column block-center fixed left-0 top-10 padding-2">
			<span class="block block-100 padding-1">Цена: <?php echo $data['cost']; ?></span>
			<span class="block block-100 padding-1">Дата публикации: <?php echo date("d.m.Y в H:m", strtotime($data['date'])); ?></span>
			<p class="block block-100 padding-1">Описание: <?php echo $data['description']; ?></p>
			<span class="block block-100 padding-1"> <?php echo $data['liked']; ?> <i class="fas fa-heart"></i></span>
		</div>
		<div class="block block-50 block-column block-center padding-2">
			<?php if (isset($_SESSION['user'])): ?>
				<form class="block blokc-100 block-center form classic-form" action="/<?php echo $data['id']; ?>/comment" method="POST">
					<input type="text" name="description" placeholder="Ваш комментарий">
					<button type="submit">Опубликовать</button>
				</form>
			<?php endif; ?>
			<div class="block block-100 block-column">
				<span><?php echo $commentsCount; ?> комментариев</span>
				<?php foreach ($comments as $info): ?>
                	<div class="block block-center border-black block-100 marin-3">
                		<div class="block block-30 margin-3"><p><?php echo $info['email'] ?></p></div>
                		<div class="block block-50 margin-3"><p><?php echo $info['description'] ?></p></div>
                		<div class="block block-20 margin-3">
                			<span><?php echo $info['date'] ?></span>
                			<?php if (!empty($_SESSION['user']) and $_SESSION['user']['email'] ==  $info['email']): ?>
                				<a href="/<?php echo $info['offer']; ?>/uncomment/<?php echo $info['id']; ?>"><i class="far fa-times-circle"></i></a>
                			<?php endif ?>
                		</div>
					</div>
                <?php endforeach; ?>
			</div>
		</div>
		<div class="block block-20 fixed right-0 top-10 block-column block-center padding-2">
			<a class="block block-100 block-column" href="/<?php if($profile['role'] == 'user'){echo 'profile';}else{echo $profile['role'];} ?>/<?php echo $profile['id'] ?>">
				<span><?php if ($profile['role'] == 'company') {echo 'Компания "'. $profile['company'] . '"';} elseif($profile['role'] == 'user'){echo 'Пользователь';} ?></span>
				<span class="block block-100 block-img">
					<?php if ($profile['photo'] == 1): ?>
						<img src="https://s3.eu-central-1.amazonaws.com/shef/images/users/<?php echo $profile['id']; ?>/1.jpg" alt="image">
					<?php endif; ?>
				</span>
				<span><?php echo $profile['name']; ?></span>
			</a>
			<?php if (isset($_SESSION['user'])): ?>
				<?php if ($like == false): ?>
						В список желаемого <a href="/<?php echo $data['type'] ?>/<?php echo $data['id'] ?>/like" class="block border-black"><i class="far fa-heart"></i></a>
					<?php else: ?>
						Убрать из списка желаемого <a href="/<?php echo $data['type'] ?>/<?php echo $data['id'] ?>/dislike" class="block border-black"><i class="fas fa-heart"></i></a>
				<?php endif; ?>
			<?php endif; ?>
			<?php if(isset($_SESSION['user'])): ?>
				<button id="take" class="btn-modern">Заказать</button>
			<?php else: ?>
				<a href="/login"><i class="fas fa-utensils"></i> Заказать</a>
			<?php endif; ?>
		</div>
	</div>
</div>


<div id="taking" class="fixed modal block-90 top-5 padding-5">
	<div class="block block-100 block-center relative">
		<i class="logo min"></i>
		<a class="fixed right-15 padding-1" id="btn-close"><i class="fas fa-times"></i></a>
	</div>
	<form action="/offer/<?php echo $data['id']; ?>/take" method="POST">
		<div class="block block-100 block-center padding-1">
			<h3>Сделать заказ</h3>
		</div>
		<span class="block block-100" id="noti"></span>
		<div class="block block-100 block-center padding-1">
			<input type="text" id="address" class="input" placeholder="Адрес" name="address">
		</div>
		<div class="block block-100 block-center padding-1">
			<input type="number" name="count" placeholder="Количество" min="1" max="1000000">
		</div>
		<div class="block block-100 block-center padding-1">
			<textarea name="description" placeholder="Пожелания? Например: Без майонеза и сахара. Больше лука!"></textarea>
		</div>
		<div class="block block-100 block-center padding-1">
			<input type="text" name="promocode" placeholder="Промокод">
		</div>
		<div class="block block-100 block-center padding-1">
			Оплата
			<select name="pay">
				<option value="money">Наличными</option>
				<option value="shef_balance">Shef.Balance</option>
			</select>
		</div>
		<div class="block block-100 block-center padding-1">
			Доставка
			<select name="delivery">
				<option value="pickup">Самовывоз</option>
				<option value="delivery">Доставка</option>
				<option value="shef_delivery">Shef.Driver</option>
			</select>
		</div>
		<div class="block block-100 block-center padding-1">
			Время доставки
			<input type="time" min="0:00" max="0:00" name="time_delivery" required/>
		</div>
		<div class="block block-100 block-center padding-1">
			<button type="submit" id="send">Заказать</button>
		</div>
	</form>
</div>



<script>
	$( "#take" ).click(function() {
	var modal = $('#taking');

	if (modal.css('display') == 'none'){
		modal.css('display', 'block');
	}else{
		modal.css('display', 'none');
	}

	$( "#btn-close" ).click(function() {
		if (modal.css('display') != 'none'){

			modal.css('display', 'none');
		}
	});

	$( "#send" ).click(function() {
		localStorage.promocode = $("input[name='promocode']").val();
		localStorage.pay = $( "select[name='pay']" ).val();
		localStorage.delivery = $( "select[name='delivery" ).val();
		localStorage.time_delivery = $("input[name='time_delivery']").val();
	});

});

	if (localStorage.promocode != null) {$("input[name='promocode']").val(localStorage.promocode);}
	if (localStorage.pay != null) {$("select[name='pay']").val(localStorage.pay);}
	if (localStorage.delivery != null) {$("select[name='delivery']").val(localStorage.delivery);}
	if (localStorage.time_delivery != null) {$("input[name='time_delivery']").val(localStorage.time_delivery);}
</script>