<nav>
	<div class="nav-left">
		<a href="#" id="btn-menu"><i class="fas fa-bars"></i></a>
		<a href="/search" class="desktop-nav"><i class="fa fa-search"></i></a>
		<a href="/add/advert" class="desktop-nav"><i class="fa fa-plus"></i></a>
	</div>
	<div class="nav-mid">
		<a href="/"><i class="logo norm"></i></a>
	</div>
	<div class="nav-right">
		<a href="/liked" class="desktop-nav"><i class="fas fa-heart"></i></a>
		<a href="#" id="btn-geo" class="desktop-nav"><i class="fas fa-globe-asia"></i></a>
		<a href="#" id="btn-profile"><i class="fas fa-user"></i></a>
	</div>
</nav>


<!-- Menu -->
	<div id="menu" class="menu">
		<div class="menu-top">
			<div class="divider mobile-nav">
				<a href="/add/advert"><i class="fa fa-plus"></i> Добавить</a>
			</div>
			<div class="divider mobile-nav">
				<a href="/search"><i class="fa fa-search"></i> Поиск</a>
			</div>
			<div class="divider">
				<a href="/recomended"><i class="fas fa-thumbs-up"></i> Рекомендации</a>
				<a href="/hot"><i class="fas fa-fire"></i> В топе</a>
			</div>


		</div>
		<div class="menu-bottom">
			<div class="divider">
				<a href="/packages"><i class="fas fa-shopping-bag"></i> Пакеты</a>
			</div>
			<div class="divider">
				<a href="/create/route"><i class="fas fa-car"></i> Нужна доставка</a>
			</div>
			<div class="divider">
				<a href="/about"><i class="fa fa-hashtag"></i> О платформе</a>
				<a href="/agreements"><i class="fas fa-passport"></i> Соглашения</a>
			</div>
		</div>
	</div>

	<div id="profile" class="menu">
		<div class="menu-top">

			<div class="divider">
				<a href="/profile/<?php echo $_SESSION['user']['id']; ?>"><i class="fa fa-home"></i> Моя страница </a>
			</div>
			<div class="divider mobile-nav">
				<a href="/liked"><i class="fas fa-heart"></i> Понравилось</a>
			</div>
			<div class="divider">
				<a href="/profile/adverts"><i class="fas fa-address-book"></i> Добавленное</a>
			</div>
			<div class="divider">
				<a href="/requests"><i class="fas fa-utensils"></i> Заявки</a>
			</div>
		</div>

		<div class="menu-bottom">
			<div class="divider mobile-nav">
				<a href="#" id="btn-geo"><i class="fas fa-globe-asia"></i> Где я</a>
			</div>
			<div class="divider">
				<a href="/notifications"><i class="far fa-bell"></i> Уведомления *<?php echo $vars['notifications'] ?></a>
			</div>
			<div class="divider">
				<a href="/balance/<?php echo $_SESSION['user']['id']; ?>"><i class="fas fa-wallet"></i> Баланс</a>
			</div>

			<div class="divider">
				<a href="/exit"><i class="fa fa-power-off"></i> Выйти</a>
			</div>
		</div>
	</div>


<div id="geo" class="fixed modal block-70 top-10 padding-3">
	<div class="block block-100 block-center relative">
		<i class="logo min"></i>
		<a class="fixed right-15 padding-1" id="btn-close"><i class="fas fa-times"></i></a>
	</div>
	<div class="block block-100 block-center block-column margin-5">
		<h1 class="block block-100 block-center margin-1">Голоден?</h1>
		<span class="block block-100 block-center margin-1">Всемирная онлайн-платформа для купле/продажи еды.</span>
	</div>
	<div class="block block-100 block-center block-column">
		<span  class="block block-100" id="nota"></span>
		<div class="block block-100 block-center padding-1">
			<input type="text" id="suggest" class="input" placeholder="Адрес" name="address">
			<button id="save"><i class="fas fa-map-marker-alt"></i> Запомнить</button>
		</div>
	</div>
</div>