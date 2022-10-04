<div class="page max-page font-arial">
	<form class="form block-60 classic-form margin-4" action="/create/route" method="POST">
		<div class="block block-center block-70 margin-2">
			<h3>Добавить маршрут</h3>
		</div>
		<div class="block block-center block-70 margin-2">
			<div id="map" class="block block-100"></div>
		</div>
		<div class="block block-center block-70 margin-2">
			<p id="notice">Адрес не найден</p>
			<input type="text" id="suggest" class="input" placeholder="Адрес - Откуда">
			<button type="submit" id="button">Проверить</button>
			<div id="messageHeader"></div>
			<div id="message"></div>
		</div>
		<div class="block block-center block-70 margin-2 block-column">
			<input type="text" name="route_from" placeholder="Откуда" readonly required id="addressFirst">
			<input type="text" name="route_to" placeholder="Куда" readonly required id="addressSecond">
			<button type="button" id="clear">Сбросить</button>
		</div>
		<div class="block block-center block-70 margin-2">
			<textarea name="description" cols="60" rows="10" placeholder="Допольнительное информация, номер подъезда"></textarea>
		</div>
		<div class="block block-center block-70 margin-2">
			<input type="number" name="cost" placeholder="Укажите цену" min="1" max="1000000">
		</div>
		<div class="block block-centerblock-70 margin-3">
			<div class="block margin-1 block-center block-column"><span>15 минут</span><input type="radio" name="date_end" value="15"></div>
			<div class="block margin-1 block-center block-column"><span>30 минут</span><input type="radio" name="date_end" value="30"></div>
			<div class="block margin-1 block-center block-column"><span>1 час</span><input type="radio" name="date_end" value="60"></div>
			<div class="block margin-1 block-center block-column"><span>2 часа</span><input type="radio" name="date_end" value="120"></div>
		</div>
		<div class="block block-center block-100 text-center margin-2">
			<button type="submit" class="block block-center block-100  text-center font-arial">
				Создать маршрут
			</button>
		</div>
	</form>
</div>


<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script src="/public/js/map.js"></script>