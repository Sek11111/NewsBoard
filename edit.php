<?php
require_once 'config.php';
require_once 'functions.php';
if (!isLoggedIn() || !in_array($_SESSION['role'], ['teacher', 'admin'])) die('Доступ запрещён');

$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM announcements WHERE id = ?");
$stmt->execute([$id]);
$ann = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$ann) die('Не найдено');
// Проверка прав: автор или админ
if ($_SESSION['role'] != 'admin' && $ann['author_id'] != $_SESSION['user_id']) die('Нет прав');

$categories = getCategories($pdo);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$title = trim($_POST['title']);
	$excerpt = trim($_POST['excerpt']);
	$body = trim($_POST['body']);
	$category_id = (int)$_POST['category_id'];
	if (strlen($title) < 5) $errors[] = 'Заголовок короткий';
	if (strlen($body) < 10) $errors[] = 'Текст короткий';
	if (!$category_id) $errors[] = 'Выберите категорию';
	if (empty($errors)) {
		$stmt = $pdo->prepare("UPDATE announcements SET title=?, excerpt=?, body=?, category_id=? WHERE id=?");
		$stmt->execute([$title, $excerpt, $body, $category_id, $id]);
		header("Location: announcement.php?id=$id");
		exit;
	}
}

$page_title = 'Редактирование';
include 'header.php';
?>
<main class="main-content" style="max-width: 800px;">
	<div class="content-form-card">
		<h2>Редактирование объявления</h2>
		<?php if ($errors): ?><div style="color:red;"><?= implode('<br>', $errors) ?></div><?php endif; ?>
		<form method="POST">
			<div class="form-group">
				<label class="form-label">Категория</label>
				<select name="category_id" class="select-input" style="width:100%;" required>
					<?php foreach ($categories as $cat): ?>
						<option value="<?= $cat['id'] ?>" <?= $cat['id'] == $ann['category_id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label class="form-label">Заголовок</label>
				<input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($_POST['title'] ?? $ann['title']) ?>">
			</div>
			<div class="form-group">
				<label class="form-label">Краткое описание</label>
				<input type="text" name="excerpt" class="form-control" required value="<?= htmlspecialchars($_POST['excerpt'] ?? $ann['excerpt']) ?>">
			</div>
			<div class="form-group">
				<label class="form-label">Текст</label>
				<textarea name="body" class="form-textarea" required><?= htmlspecialchars($_POST['body'] ?? $ann['body']) ?></textarea>
			</div>
			<div class="form-actions-row" style="justify-content: space-between;">
				<button type="button" class="btn btn-danger-outline" onclick="if(confirm('Удалить?')) location.href='delete.php?id=<?= $id ?>'">Удалить</button>
				<div>
					<a href="profile.php" class="btn btn-secondary">Отмена</a>
					<button type="submit" class="btn btn-primary">Сохранить</button>
				</div>
			</div>
		</form>
	</div>
</main>
<?php include 'footer.php'; ?>