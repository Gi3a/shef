<nav>
	<div id="btn-menu" class="nav-left">
		<a href="#" id="btn-menu"><i class="fas fa-bars"></i></a>
		<a href="/search"><i class="fa fa-search"></i></a>
	</div>
	<div class="nav-mid">
		<a href="/"><i class="logo norm"></i>Company</a>
	</div>
	<div class="nav-right">
		<a href="#" id="btn-profile"><i class="fas fa-user"></i></a>
	</div>
</nav>


<!-- Menu -->
	<div id="menu" class="menu">
		<div class="menu-top">
			<div class="divider">
				<a href="/recomended"><i class="fas fa-thumbs-up"></i> Рекомендации</a>
				<a href="/hot"><i class="fas fa-fire"></i> В топе</a>
			</div>
			<div class="divider">
				<a href="/add/advert"><i class="fa fa-plus"></i> Добавить объявление</a>
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
				<a href="/company/<?php echo $_SESSION['user']['id']; ?>"><i class="fa fa-home"></i> Моя страница </a>
			</div>

			<div class="divider">
				<a href="/company/adverts"><i class="fa fa-bullhorn"></i> Мои объявления</a>
				<a href="/profile/routes"><i class="fas fa-compass"></i> Моя доставка</a>
			</div>
			<div class="divider">
				<a href="/company/chart/<?php echo $_SESSION['user']['id']; ?>"><i class="fas fa-chart-line"></i> График</a>
			</div>
			<div class="divider">
				<a href="/messages"><i class="fa fa-envelope"></i> Сообщения</a>
			</div>
			<div class="divider">
				<a href="/liked"><i class="fas fa-heart"></i> Понравившиеся</a>
			</div>
		</div>

		<div class="menu-bottom">
			<div class="divider">
				<a href="balance/<?php echo $_SESSION['user']['id']; ?>"><i class="fas fa-wallet"></i> Баланс</a>
			</div>
			<div class="divider">
				<a href="/settings/<?php echo $_SESSION['user']['id']; ?>"><i class="fa fa-cog"></i> Настройки</a>
			</div>
			<div class="divider">
				<a href="/exit"><i class="fa fa-power-off"></i> Выйти</a>
			</div>
		</div>
	</div>