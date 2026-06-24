<?php
require_once 'config.php';
require_once 'functions.php';
if (!isLoggedIn() || $_SESSION['role'] != 'admin') die('Доступ запрещён');

// CRUD категорий
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_POST['add'])) {
		$name = trim($_POST['name']);
		$slug = trim($_POST['slug']);
		$color = trim($_POST['color']);
		if ($name && $slug && $color) {
			$pdo->prepare("INSERT INTO categories (name, slug, color_class) VALUES (?, ?, ?)")->execute([$name, $slug, $color]);
		}
		header("Location: admin_categories.php");
		exit;
	}
	if (isset($_POST['update'])) {
		$id = (int)$_POST['id'];
		$name = trim($_POST['name']);
		$slug = trim($_POST['slug']);
		$color = trim($_POST['color']);
		if ($name && $slug && $color) {
			$pdo->prepare("UPDATE categories SET name=?, slug=?, color_class=? WHERE id=?")->execute([$name, $slug, $color, $id]);
		}
		header("Location: admin_categories.php");
		exit;
	}
	if (isset($_POST['delete'])) {
		$id = (int)$_POST['id'];
		$pdo->prepare("DELETE FROM categories WHERE id = ?")->execute([$id]);
		header("Location: admin_categories.php");
		exit;
	}
}

$categories = getCategories($pdo);
$page_title = 'Управление категориями';
include 'header.php';
?>
<main class="main-content">
	<div class="admin-grid-layout">
		<aside class="admin-sidebar">
			<p class="admin-menu-title">Навигация</p>
			<ul class="profile-menu">
				<li><a href="admin_dashboard.php">Дашборд</a></li>
				<li><a href="admin_users.php">Пользователи</a></li>
				<li><a href="admin_categories.php" class="active">Категории</a></li>
				<li><a href="profile.php">Вернуться в профиль</a></li>
			</ul>
		</aside>
		<section style="display:flex; flex-direction:column; gap:2rem;">
			<div class="admin-table-card">
				<h3>Добавить категорию</h3>
				<form method="POST" style="display:flex; gap:1rem; flex-wrap:wrap; align-items:flex-end;">
					<div><label class="form-label">Название</label><input type="text" name="name" class="form-control" required></div>
					<div><label class="form-label">Slug</label><input type="text" name="slug" class="form-control" required></div>
					<div><label class="form-label">Цвет (класс)</label><input type="text" name="color" class="form-control" placeholder="badge-news" required></div>
					<button type="submit" name="add" class="btn btn-primary">Создать</button>
				</form>
			</div>
			<div class="admin-table-card">
				<h3>Существующие категории</h3>
				<table class="admin-responsive-table">
					<thead>
						<tr>
							<th>Название</th>
							<th>Slug</th>
							<th>Цвет</th>
							<th>Действия</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($categories as $cat): ?>
							<tr>
								<form method="POST" style="display:contents;">
									<input type="hidden" name="id" value="<?= $cat['id'] ?>">
									<td><input type="text" name="name" value="<?= htmlspecialchars($cat['name']) ?>" class="form-control" style="padding:0.4rem;"></td>
									<td><input type="text" name="slug" value="<?= htmlspecialchars($cat['slug']) ?>" class="form-control" style="padding:0.4rem;"></td>
									<td><input type="text" name="color" value="<?= htmlspecialchars($cat['color_class']) ?>" class="form-control" style="padding:0.4rem;"></td>
									<td>
										<button type="submit" name="update" class="btn btn-table-action" style="background:#e0f2fe; color:#0369a1;">Обновить</button>
										<button type="submit" name="delete" class="btn btn-table-action btn-table-danger" onclick="return confirm('Удалить?')">Удалить</button>
									</td>
								</form>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</section>
	</div>
</main>
<?php include 'footer.php'; ?>