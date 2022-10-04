<nav>
	<div id="btn-menu" class="nav-left">
		<a href="#" id="btn-menu"><i class="fas fa-bars"></i></a>
	</div>
	<div class="nav-mid">
		<a href="/driver/routes"><i class="logo norm"></i>Driver</a>
	</div>
	<div class="nav-right">
		<a href="#" id="btn-profile"><i class="fas fa-user"></i></a>
	</div>
</nav>


<!-- Menu -->
	<div id="menu" class="menu">
		<div class="menu-top">
			<div class="divider">
				<a href="/driver/routes"><i class="fas fa-compass"></i> Маршруты</a>
			</div>

		</div>
		<div class="menu-bottom">
			<div class="divider">
				<a href="/about"><i class="fa fa-hashtag"></i> О платформе</a>
				<a href="/agreements"><i class="fas fa-passport"></i> Соглашения</a>
			</div>
		</div>
	</div>

	<div id="profile" class="menu">
		<div class="menu-top">

			<div class="divider">
				<a href="/driver/<?php echo $_SESSION['user']['id']; ?>"><i class="fa fa-home"></i> Моя страница </a>
			</div>

			<div class="divider">
				<a href="/driver/way"><i class="fa fa-list-alt"></i> Мои маршруты</a>
			</div>
			<div class="divider">
				<a href="/driver/executed"><i class="fas fa-money-check-alt"></i> Выполнение маршруты</a>
			</div>
		</div>

		<div class="menu-bottom">
			<div class="divider">
				<a href="/settings/<?php echo $_SESSION['user']['id']; ?>"><i class="fa fa-cog"></i> Настройки</a>
			</div>

			<div class="divider">
				<a href="/exit"><i class="fa fa-power-off"></i> Выйти</a>
			</div>
		</div>
	</div>