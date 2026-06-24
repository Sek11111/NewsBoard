<?php
require_once 'config.php';
require_once 'functions.php';
if (!isLoggedIn() || !in_array($_SESSION['role'], ['teacher', 'admin'])) {
	die('Доступ запрещён');
}
$categories = getCategories($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$title = trim($_POST['title']);
	$excerpt = trim($_POST['excerpt']);
	$body = trim($_POST['body']);
	$category_id = (int)$_POST['category_id'];
	$errors = [];
	if (strlen($title) < 5) $errors[] = 'Заголовок слишком короткий';
	if (strlen($body) < 10) $errors[] = 'Текст слишком короткий';
	if (!$category_id) $errors[] = 'Выберите категорию';
	if (empty($errors)) {
		$stmt = $pdo->prepare("INSERT INTO announcements (title, excerpt, body, category_id, author_id) VALUES (?, ?, ?, ?, ?)");
		$stmt->execute([$title, $excerpt, $body, $category_id, $_SESSION['user_id']]);
		header("Location: index.php");
		exit;
	}
}
$page_title = 'Создание объявления';
include 'header.php';
?>
<main class="main-content" style="max-width: 800px;">
	<div class="content-form-card">
		<h2>Создание нового объявления</h2>
		<?php if (!empty($errors)): ?>
			<div style="color: red; margin-bottom: 1rem;"><?= implode('<br>', $errors) ?></div>
		<?php endif; ?>
		<form method="POST">
			<div class="form-group">
				<label class="form-label" for="category_id">Категория</label>
				<select id="category_id" name="category_id" class="select-input" style="width: 100%;" required>
					<option value="">Выберите</option>
					<?php foreach ($categories as $cat): ?>
						<option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label class="form-label" for="title">Заголовок</label>
				<input type="text" id="title" name="title" class="form-control" required minlength="5" maxlength="200" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>">
			</div>
			<div class="form-group">
				<label class="form-label" for="excerpt">Краткое описание</label>
				<input type="text" id="excerpt" name="excerpt" class="form-control" required minlength="10" maxlength="300" value="<?= htmlspecialchars($_POST['excerpt'] ?? '') ?>">
			</div>
			<div class="form-group">
				<label class="form-label" for="body">Полный текст</label>
				<textarea id="body" name="body" class="form-textarea" required minlength="10"><?= htmlspecialchars($_POST['body'] ?? '') ?></textarea>
			</div>
			<div class="form-actions-row">
				<a href="profile.php" class="btn btn-secondary">Отмена</a>
				<button type="submit" class="btn btn-primary">Опубликовать</button>
			</div>
		</form>
	</div>
</main>
<?php include 'footer.php'; ?>