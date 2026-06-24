<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $page_title ?? 'Кафедра математики СОГУ' ?></title>
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<header class="main-header">
		<div class="header-container">
			<div class="logo-block">
				<div class="logo-text">
					<img src="images/logo.png" class="header_logo-img" alt="СОГУ">
					<h1>Кафедра Математики</h1>
					<p>СОГУ им. К. Л. Хетагурова</p>
				</div>
			</div>
			<nav class="main-nav">
				<ul>
					<li><a href="index.php">Главная</a></li>
					<li><a href="about.php">О кафедре</a></li>
					<li><a href="rules.php">Правила</a></li>
					<li><a href="contacts.php">Контакты</a></li>
				</ul>
			</nav>
			<div class="auth-buttons">
				<?php if (isLoggedIn()): ?>
					<a href="profile.php" class="btn btn-outline">Личный кабинет</a>
					<a href="logout.php" class="btn btn-primary">Выйти</a>
				<?php else: ?>
					<a href="login.php" class="btn btn-outline">Вход</a>
					<a href="register.php" class="btn btn-primary">Регистрация</a>
				<?php endif; ?>
			</div>
		</div>
	</header>