<?php
require_once 'config.php';
require_once 'functions.php';
$page_title = 'Контакты | Кафедра математики СОГУ';
include 'header.php';
?>

<main class="main-content">
	<div class="contacts-container">
		<section class="contacts-info-block">
			<h2>Контактная информация</h2>

			<div class="contact-item">
				<span class="contact-label">Адрес кафедры</span>
				<span class="contact-value">362025, РСО-Алания, г. Владикавказ, ул. Ватутина, д. 44-46. Корпус факультета математики и компьютерных наук (ФМКН).</span>
			</div>

			<div class="contact-item">
				<span class="contact-label">Телефон</span>
				<span class="contact-value"><a href="tel:+78672000000">+7 (8672) 00-00-00</a> (Внутренний: 123)</span>
			</div>

			<div class="contact-item">
				<span class="contact-label">Электронная почта</span>
				<span class="contact-value"><a href="mailto:math@nosu.ru">math@nosu.ru</a></span>
			</div>

			<div class="contact-item">
				<span class="contact-label">Часы работы приема</span>
				<span class="contact-value">Понедельник — Пятница: с 09:00 до 17:00<br>Суббота: с 09:00 до 13:00<br>Воскресенье: выходной</span>
			</div>

			<div class="contact-item">
				<span class="contact-label">Расположение</span>
				<span class="contact-value">3 этаж, кабинет №305 (Кабинет заведующего кафедрой) и №307 (Лаборантская).</span>
			</div>
		</section>

		<section class="contacts-map-block">
			<div class="map-wrapper">
				<div style="position:relative;overflow:hidden;height: 100%;">

					<iframe src="https://yandex.ru/map-widget/v1/?ll=44.691653%2C43.023008&mode=poi&poi%5Bpoint%5D=44.691362%2C43.026099&poi%5Buri%5D=ymapsbm1%3A%2F%2Forg%3Foid%3D120729333568&z=16" width="560" height="620" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>
				</div>
			</div>
		</section>
	</div>
</main>

<?php include 'footer.php'; ?>