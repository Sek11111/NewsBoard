<?php
require_once 'config.php';
require_once 'functions.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) die('Неверный ID');

// Увеличиваем просмотры
$pdo->prepare("UPDATE announcements SET views = views + 1 WHERE id = ?")->execute([$id]);

$stmt = $pdo->prepare("SELECT a.*, u.name as author_name, c.name as category_name, c.color_class 
                       FROM announcements a
                       JOIN users u ON a.author_id = u.id
                       JOIN categories c ON a.category_id = c.id
                       WHERE a.id = ?");
$stmt->execute([$id]);
$ann = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$ann) die('Объявление не найдено');

$comments = getComments($pdo, $id);
$page_title = $ann['title'];
include 'header.php';
?>
<main class="main-content">
	<article class="announcement-single">
		<div class="announcement-header">
			<span class="badge <?= $ann['color_class'] ?>"><?= htmlspecialchars($ann['category_name']) ?></span>
			<h2 class="announcement-title"><?= htmlspecialchars($ann['title']) ?></h2>
			<div class="card-meta" style="border: none; padding: 0; margin: 0;">
				<span><?= date('d.m.Y', strtotime($ann['created_at'])) ?></span>
				<span><?= $ann['views'] ?></span>
				<span>Автор: <?= htmlspecialchars($ann['author_name']) ?></span>
				<?php if (isLoggedIn() && ($_SESSION['user_id'] == $ann['author_id'] || $_SESSION['role'] == 'admin')): ?>
					<span><a href="edit.php?id=<?= $ann['id'] ?>" class="btn btn-outline" style="padding: 0.2rem 0.5rem;">Редактировать</a></span>
				<?php endif; ?>
			</div>
		</div>
		<div class="announcement-body">
			<?= nl2br(htmlspecialchars($ann['body'])) ?>
		</div>
	</article>

	<section class="comments-section">
		<h3>Комментарии (<?= count($comments) ?>)</h3>
		<?php foreach ($comments as $comm): ?>
			<div class="comment-card">
				<div class="comment-header">
					<span class="comment-author"><?= htmlspecialchars($comm['name']) ?>
						<span class="comment-author-rank" style="color: #64748b;"><?= $comm['role'] == 'teacher' ? 'Преподаватель' : ($comm['role'] == 'admin' ? 'Админ' : 'Студент') ?></span>
					</span>
					<span class="comment-date"><?= date('d.m.Y, H:i', strtotime($comm['created_at'])) ?></span>
				</div>
				<div class="comment-text"><?= nl2br(htmlspecialchars($comm['content'])) ?></div>
			</div>
		<?php endforeach; ?>

		<?php if (isLoggedIn()): ?>
			<form class="comment-form" method="POST" action="add_comment.php">
				<input type="hidden" name="announcement_id" value="<?= $ann['id'] ?>">
				<h4 style="color: #0c2e4e; margin-bottom: 1rem; font-weight: 700;">Оставить комментарий</h4>
				<textarea name="content" placeholder="Напишите ваш комментарий..." required></textarea>
				<button type="submit" class="btn btn-primary">Отправить</button>
			</form>
		<?php else: ?>
			<p style="color: #64748b;"><a href="login.php">Войдите</a>, чтобы оставить комментарий.</p>
		<?php endif; ?>
	</section>
</main>
<?php include 'footer.php'; ?>