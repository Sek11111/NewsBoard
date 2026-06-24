<?php
require_once 'config.php';
require_once 'functions.php';
if (!isLoggedIn() || $_SESSION['role'] != 'admin') die('Доступ запрещён');

// Статистика
$usersCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$annCount = $pdo->query("SELECT COUNT(*) FROM announcements")->fetchColumn();
$commCount = $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();

// Логи (последние действия) - здесь для простоты возьмём последние комментарии и объявления
$logs = [];
$logsStmt = $pdo->query("SELECT 'comment' as type, c.created_at, u.name, c.content as text 
                         FROM comments c JOIN users u ON c.user_id = u.id 
                         ORDER BY c.created_at DESC LIMIT 3");
$logs = array_merge($logs, $logsStmt->fetchAll(PDO::FETCH_ASSOC));
$logsStmt2 = $pdo->query("SELECT 'announcement' as type, a.created_at, u.name, a.title as text 
                          FROM announcements a JOIN users u ON a.author_id = u.id 
                          ORDER BY a.created_at DESC LIMIT 3");
$logs = array_merge($logs, $logsStmt2->fetchAll(PDO::FETCH_ASSOC));
usort($logs, function ($a, $b) {
	return strtotime($b['created_at']) - strtotime($a['created_at']);
});
$logs = array_slice($logs, 0, 5);

$page_title = 'Панель администратора';
include 'header.php';
?>
<main class="main-content">
	<div class="admin-grid-layout">
		<aside class="admin-sidebar">
			<p class="admin-menu-title">Навигация</p>
			<ul class="profile-menu">
				<li><a href="admin_dashboard.php" class="active">Дашборд</a></li>
				<li><a href="admin_users.php">Пользователи</a></li>
				<li><a href="admin_categories.php">Категории</a></li>
				<li><a href="profile.php">Вернуться в профиль</a></li>
			</ul>
		</aside>
		<section>
			<div class="stats-cards-grid">
				<div class="stat-card blue-top">
					<p class="stat-card-title">Пользователи</p>
					<p class="stat-card-number"><?= $usersCount ?></p>
				</div>
				<div class="stat-card purple-top">
					<p class="stat-card-title">Объявления</p>
					<p class="stat-card-number"><?= $annCount ?></p>
				</div>
				<div class="stat-card green-top">
					<p class="stat-card-title">Комментарии</p>
					<p class="stat-card-number"><?= $commCount ?></p>
				</div>
			</div>
			<div class="admin-logs-card">
				<h3>Последние действия</h3>
				<?php foreach ($logs as $log): ?>
					<div class="log-item">
						<div class="log-text-block">
							<?= htmlspecialchars($log['name']) ?>
							<?= $log['type'] == 'comment' ? 'оставил комментарий: ' : 'создал объявление: ' ?>
							<span class="log-user-ref"><?= htmlspecialchars($log['text']) ?></span>
						</div>
						<span class="log-time-badge"><?= date('d.m.Y, H:i', strtotime($log['created_at'])) ?></span>
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</div>
</main>
<?php include 'footer.php'; ?>