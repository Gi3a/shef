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
			<div class="block block-center block-column block-100">
				<?php if ( $vars['countExecutors'] > 0): ?>
					<p class="block block-center block-column block-100">Отправленных заявок на выполнение (<?php echo $vars['countExecutors']; ?>)</p><br>
				<?php else: ?>
					<p  class="block block-center block-column block-100">Заявок нет</p>
				<?php endif ?>
    		</div>
			<?php if (!empty($_SESSION)) : ?>
				<?php if (!empty($status)): ?>
					<?php if ((!empty($orderExecutor)) and (($_SESSION['user']['email'] == $data['email']) or ($_SESSION['user']['email'] == $orderExecutor[0]['email_executor']))): ?>
							<div class="block block-center block-100 border-black block-column">
						 		<span class="block block-center">Исполнитель: <?php echo $orderExecutor[0]['email_executor'] ?></span>
						 		<span class="block block-center">Условия: <?php echo $orderExecutor[0]['description'] ?></span>
						 		<span class="block block-center">Цена: <?php echo $orderExecutor[0]['cost'] ?></span>
						 		<span class="block block-center">Доставка: <?php echo $orderExecutor[0]['route'] ?></span>
						 		<span class="block block-center">Дата начала: <?php echo $orderExecutor[0]['date'] ?></span>
						 		<span class="block block-center">Дата окончания: <?php echo $orderExecutor[0]['date_end'] ?></span>
						 		<span class="block block-center">Статус: <?php echo $orderExecutor[0]['status'] ?></span>


						 		<?php if (($_SESSION['user']['email'] == $data['email'])  and ($orderExecutor[0]['status'] == 'do')): ?>
						 			<a href="/order/<?php echo $data['id']; ?>/refuse">Отменить исполнителя</a>


						 		<?php elseif(($_SESSION['user']['email'] == $orderExecutor[0]['email_executor']) and ($orderExecutor[0]['status'] == 'do')): ?>
						 			<a href="/order/<?php echo $data['id']; ?>/<?php echo $orderExecutor[0]['id']; ?>/ready">Сообщить о готовности заказа</a>
						 			<a href="/order/<?php echo $data['id']; ?>/<?php echo $orderExecutor[0]['id']; ?>/cancel">Отменить заказ</a>


						 		<?php elseif(($orderExecutor[0]['status'] == 'ready') and (($_SESSION['user']['email'] == $data['email']) or ($_SESSION['user']['email'] == $orderExecutor[0]['email_executor']))): ?>
						 			<span class="block block-100 borde-black"><?php echo $phone; ?></span>
						 			<?php if ($_SESSION['user']['email'] == $orderExecutor[0]['email_executor']): ?>
						 				<a href="/order/<?php echo $data['id']; ?>/done">Я получил оплату</a>
						 			<?php endif ?>
						 		<?php endif ?>
						 	</div>
					<?php endif ?>
				<?php elseif(empty($status)): ?>
					<?php if ($_SESSION['user']['email'] != $data['email']): ?>
						<div class="block block-row block-center block-100">
							<form class="form classic-form margin-10" action="/order/<?php echo $data['id']; ?>/make" method="POST">
								<textarea type="text" name="description" cols="40" rows="8" placeholder="Например: Я готов выполнить ваш заказ, на 200 тг меньше указанной суммы"></textarea>
								<input type="number" name="cost" placeholder="Укажите цену" min="1" max="1000000">
								<span>Сколько времени вам понадобиться?</span>
								<div class="block block-center block-70 margin-2">
									<div><span>Час</span><input type="radio" name="date_end" value="1"></div>
									<div><span>2 часа</span><input type="radio" name="date_end" value="2"></div>
									<div><span>3 часа</span><input type="radio" name="date_end" value="3"></div>
								</div>
								<span>Вы сможете доставить ?</span>
								<div class="block block-center block-70 margin-2">
									<div><span>Да</span><input type="radio" name="route" value="yes"></div>
									<div><span>Нет</span><input type="radio" name="route" value="no"></div>
								</div>
								<button type="submit">Отправить заявку на выполнение</button>
							</form>
						</div>
					<?php endif ?>
				    <?php if ($_SESSION['user']['email'] == $data['email']): ?>
						    <?php if (empty($listExecutors)): ?>
								<p>Испольнителей нет</p>
							<?php else: ?>
								 <?php foreach ($listExecutors as $val): ?>
								 	<div class="block block-center block-50 border-black block-column">
								 		<span class="block block-center">Исполнитель: <?php echo $val['email_executor'] ?></span>
								 		<span class="block block-center">Условия: <?php echo $val['description'] ?></span>
								 		<span class="block block-center">Цена: <?php echo $val['cost'] ?></span>
								 		<span class="block block-center">Доставка: <?php echo $val['route'] ?></span>
								 		<span class="block block-center">Дата начала: <?php echo $val['date'] ?></span>
								 		<span class="block block-center">Дата окончания: <?php echo $val['date_end'] ?></span>
								 		<a href="/order/<?php echo $data['id']; ?>/<?php echo $val['id']; ?>/apply">Подвердить выполнение</a>
								 	</div>
								 <?php endforeach; ?>
							<?php endif; ?>
					<?php endif; ?>
					<?php if (!empty($suggestionData)): ?>
							<div class="block block-center block-100 border-black block-column">
						 		<span class="block block-center">Исполнитель: <?php echo $suggestionData[0]['email_executor'] ?></span>
						 		<span class="block block-center">Условия: <?php echo $suggestionData[0]['description'] ?></span>
						 		<span class="block block-center">Цена: <?php echo $suggestionData[0]['cost'] ?></span>
						 		<span class="block block-center">Доставка: <?php echo $suggestionData[0]['route'] ?></span>
						 		<span class="block block-center">Дата начала: <?php echo $suggestionData[0]['date'] ?></span>
						 		<span class="block block-center">Дата окончания: <?php echo $suggestionData[0]['date_end'] ?></span>
						 		<a href="/order/<?php echo $data['id']; ?>/unmake">Отменить предложение</a>
						 	</div>
					<?php endif ?>
				<?php endif ?>
		    <?php endif ?>
		</div>
		<div class="block block-20 fixed right-0 top-10 block-column block-center padding-2">
			<a class="block block-100 block-column" href="/<?php echo $profile['role'] ?>/<?php echo $profile['id'] ?>">
				<span><?php if ($profile['role'] == 'company') {echo 'Компания "'. $profile['company'] . '"';} elseif($profile['role'] == 'user'){echo 'Пользователь';} ?></span>
				<span>
					<?php if ($profile['photo'] == 1): ?>
						<img src="http://shef.s3.amazonaws.com/users/<?php echo $profile['id']; ?>/1.jpg" alt="image">
					<?php endif; ?>
				</span>
				<span><?php echo $profile['name']; ?></span>
			</a>
		</div>
	</div>
</div>






