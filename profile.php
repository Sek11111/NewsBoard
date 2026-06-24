<?php
require_once 'config.php';
require_once 'functions.php';

// Проверка авторизации
if (!isLoggedIn()) {
	header("Location: login.php");
	exit;
}

$user = getUser($pdo, $_SESSION['user_id']);
$page_title = 'Личный кабинет';
include 'header.php';
?>

<main class="main-content">
	<div class="profile-container">
		<!-- Боковая панель -->
		<aside class="profile-sidebar">
			<div class="profile-sidebar-avatar">
				<?= mb_substr($user['name'], 0, 2, 'UTF-8') ?>
			</div>
			<h3 class="profile-user-name"><?= htmlspecialchars($user['name']) ?></h3>
			<span class="profile-user-role role-<?= $user['role'] ?>-badge">
				<?php
				$roleNames = [
					'student' => 'Студент',
					'teacher' => 'Преподаватель',
					'admin'   => 'Администратор'
				];
				echo $roleNames[$user['role']] ?? $user['role'];
				?>
			</span>

			<ul class="profile-menu">
				<li><a href="profile.php" class="active">Мой профиль</a></li>
				<li><a href="index.php">Просмотр доски</a></li>
				<?php if (in_array($user['role'], ['teacher', 'admin'])): ?>
					<li><a href="create.php">Создать объявление</a></li>
					<li><a href="my_posts.php">Мои публикации</a></li>
				<?php endif; ?>
				<?php if ($user['role'] == 'admin'): ?>
					<li><a href="admin_dashboard.php">Администрирование</a></li>
				<?php endif; ?>
				<li><a href="logout.php" class="logout-link">Выйти</a></li>
			</ul>
		</aside>

		<!-- Основной контент -->
		<section class="profile-main-panel">
			<?php if ($user['role'] == 'student'): ?>
				<!-- Блок для студента -->
				<h2>Личный кабинет студента</h2>
				<p style="margin-bottom: 0.5rem;"><strong>Группа:</strong> <?= htmlspecialchars($user['group'] ?? 'Не указана') ?></p>
				<p style="color: #64748b; margin-top: 1rem;">
					Добро пожаловать! Вы можете просматривать объявления и оставлять комментарии.
				</p>
				<div style="margin-top: 2rem; background: #f8fafc; padding: 1.5rem; border-radius: 8px;">
					<h4 style="color: #0c2e4e; margin-bottom: 0.5rem;">Последняя активность</h4>
					<p style="color: #64748b;">Вы пока не оставили ни одного комментария.</p>
				</div>

			<?php elseif ($user['role'] == 'teacher'): ?>
				<!-- Блок для преподавателя -->
				<h2>Панель преподавателя</h2>
				<p style="margin-bottom: 1.5rem; color: #64748b;">
					Здравствуйте, <?= htmlspecialchars($user['name']) ?>! Вам доступны расширенные функции публикации учебных, научных и организационных материалов.
				</p>
				<div class="dashboard-actions-grid">
					<a href="create.php" class="action-item-card">
						<h4>Создать объявление</h4>
						<p>Опубликовать новость, расписание или запустить семинар.</p>
					</a>
					<a href="my_posts.php" class="action-item-card">
						<h4>Мои публикации</h4>
						<p>Просмотреть и отредактировать ваши текущие карточки на доске.</p>
					</a>
				</div>

			<?php elseif ($user['role'] == 'admin'): ?>
				<!-- Блок для администратора -->
				<h2>Панель администратора</h2>
				<p style="margin-bottom: 1.5rem; color: #64748b;">
					Добро пожаловать, <?= htmlspecialchars($user['name']) ?>! Вам доступен полный контроль над структурой базы данных, пользователями факультета и категориями объявлений.
				</p>
				<div class="dashboard-actions-grid">
					<a href="admin_dashboard.php" class="action-item-card">
						<h4>Дашборд</h4>
						<p>Общие графики, просмотры, логи системы и новые записи.</p>
					</a>
					<a href="admin_users.php" class="action-item-card">
						<h4>Пользователи</h4>
						<p>Список студентов/преподавателей, смена ролей, блокировка.</p>
					</a>
					<a href="admin_categories.php" class="action-item-card">
						<h4>Категории (CRUD)</h4>
						<p>Создание, чтение, обновление и удаление категорий объявлений.</p>
					</a>
					<a href="my_posts.php" class="action-item-card">
						<h4>Все публикации</h4>
						<p>Просмотр и модерация всех объявлений (включая созданные другими пользователями).</p>
					</a>
				</div>
			<?php endif; ?>
		</section>
	</div>
</main>

<?php include 'footer.php'; ?>