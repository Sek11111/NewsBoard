<?php
require_once 'config.php';
require_once 'functions.php';
if (!isLoggedIn() || $_SESSION['role'] != 'admin') die('Доступ запрещён');

// Обработка смены роли или блокировки
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
	$uid = (int)$_POST['user_id'];

	// Запрещаем изменять себя
	if ($uid == $_SESSION['user_id']) {
		header("Location: admin_users.php?error=Нельзя изменять свои данные");
		exit;
	}

	$role = $_POST['role'] ?? '';
	$status = $_POST['status'] ?? '';
	if ($role) {
		$stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
		$stmt->execute([$role, $uid]);
	}
	if ($status) {
		$stmt = $pdo->prepare("UPDATE users SET status = ? WHERE id = ?");
		$stmt->execute([$status, $uid]);
	}
	header("Location: admin_users.php");
	exit;
}

// Запрос пользователей, исключая текущего
$stmt = $pdo->prepare("SELECT * FROM users WHERE id != ? ORDER BY id");
$stmt->execute([$_SESSION['user_id']]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$page_title = 'Управление пользователями';
include 'header.php';
?>
<main class="main-content">
	<div class="admin-grid-layout">
		<aside class="admin-sidebar">
			<p class="admin-menu-title">Навигация</p>
			<ul class="profile-menu">
				<li><a href="admin_dashboard.php">Дашборд</a></li>
				<li><a href="admin_users.php" class="active">Пользователи</a></li>
				<li><a href="admin_categories.php">Категории</a></li>
				<li><a href="profile.php">Вернуться в профиль</a></li>
			</ul>
		</aside>
		<section class="admin-table-card">
			<h3>Список пользователей</h3>
			<?php if (isset($_GET['error'])): ?>
				<div style="color: red; margin-bottom: 1rem;"><?= htmlspecialchars($_GET['error']) ?></div>
			<?php endif; ?>
			<table class="admin-responsive-table">
				<thead>
					<tr>
						<th>ФИО</th>
						<th>Email</th>
						<th>Группа</th>
						<th>Роль</th>
						<th>Статус</th>
						<th>Действия</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $u): ?>
						<tr>
							<td><strong><?= htmlspecialchars($u['name']) ?></strong></td>
							<td><?= htmlspecialchars($u['email']) ?></td>
							<td><?= htmlspecialchars($u['group'] ?? '—') ?></td>
							<td>
								<form method="POST" style="display:inline;">
									<input type="hidden" name="user_id" value="<?= $u['id'] ?>">
									<select name="role" class="admin-select-sm" onchange="this.form.submit()">
										<option value="student" <?= $u['role'] == 'student' ? 'selected' : '' ?>>Студент</option>
										<option value="teacher" <?= $u['role'] == 'teacher' ? 'selected' : '' ?>>Преподаватель</option>
										<option value="admin" <?= $u['role'] == 'admin' ? 'selected' : '' ?>>Админ</option>
									</select>
								</form>
							</td>
							<td>
								<span class="status-badge <?= $u['status'] == 'active' ? 'status-active' : 'status-blocked' ?>">
									<?= $u['status'] == 'active' ? 'Активен' : 'Забанен' ?>
								</span>
							</td>
							<td>
								<form method="POST" style="display:inline;">
									<input type="hidden" name="user_id" value="<?= $u['id'] ?>">
									<input type="hidden" name="status" value="<?= $u['status'] == 'active' ? 'blocked' : 'active' ?>">
									<button type="submit" class="btn btn-table-action <?= $u['status'] == 'active' ? 'btn-table-danger' : '' ?>" style="background:<?= $u['status'] == 'active' ? '#fef2f2' : '#e2e8f0' ?>; color:<?= $u['status'] == 'active' ? '#ef4444' : '#1e293b' ?>;">
										<?= $u['status'] == 'active' ? 'Заблокировать' : 'Разблокировать' ?>
									</button>
								</form>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</section>
	</div>
</main>
<?php include 'footer.php'; ?>