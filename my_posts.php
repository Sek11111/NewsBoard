<?php
require_once 'config.php';
require_once 'functions.php';
if (!isLoggedIn() || !in_array($_SESSION['role'], ['teacher', 'admin'])) {
	die('Доступ запрещён');
}

$user_id = $_SESSION['user_id'];
$isAdmin = ($_SESSION['role'] == 'admin');

// Если админ – видит все объявления, если преподаватель – только свои
if ($isAdmin) {
	$stmt = $pdo->prepare("SELECT a.*, c.name as category_name, u.name as author_name 
                           FROM announcements a
                           JOIN categories c ON a.category_id = c.id
                           JOIN users u ON a.author_id = u.id
                           ORDER BY a.created_at DESC");
	$stmt->execute();
} else {
	$stmt = $pdo->prepare("SELECT a.*, c.name as category_name, u.name as author_name 
                           FROM announcements a
                           JOIN categories c ON a.category_id = c.id
                           JOIN users u ON a.author_id = u.id
                           WHERE a.author_id = ?
                           ORDER BY a.created_at DESC");
	$stmt->execute([$user_id]);
}
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'Мои публикации';
include 'header.php';
?>

<main class="main-content">
	<div class="admin-table-card" style="max-width: 1200px; margin: 0 auto;">
		<h2>Мои публикации</h2>
		<?php if (count($posts) === 0): ?>
			<p style="color: #64748b; margin-top: 1rem;">Вы ещё не создали ни одного объявления.</p>
			<a href="create.php" class="btn btn-primary" style="margin-top: 1rem;">Создать первое объявление</a>
		<?php else: ?>
			<table class="admin-responsive-table">
				<thead>
					<tr>
						<th>Заголовок</th>
						<th>Категория</th>
						<th>Автор</th>
						<th>Дата</th>
						<th>Действия</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($posts as $post): ?>
						<tr>
							<td><a href="announcement.php?id=<?= $post['id'] ?>" style="color: #0c2e4e; font-weight: 600;"><?= htmlspecialchars($post['title']) ?></a></td>
							<td><span class="badge <?= $post['color_class'] ?? 'badge-info' ?>"><?= htmlspecialchars($post['category_name']) ?></span></td>
							<td><?= htmlspecialchars($post['author_name']) ?></td>
							<td><?= date('d.m.Y', strtotime($post['created_at'])) ?></td>
							<td>
								<a href="edit.php?id=<?= $post['id'] ?>" class="btn btn-table-action" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">Редактировать</a>
								<a href="delete.php?id=<?= $post['id'] ?>" class="btn btn-table-action btn-table-danger" onclick="return confirm('Удалить объявление?')">Удалить</a>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>
</main>

<?php include 'footer.php'; ?>