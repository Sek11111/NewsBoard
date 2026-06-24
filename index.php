<?php
require_once 'config.php';
require_once 'functions.php';

$page_title = 'Доска объявлений';
$category = $_GET['category'] ?? '';
$search = $_GET['search'] ?? '';
$page = (int)($_GET['page'] ?? 1);
$perPage = 3;

$announcements = getAnnouncements($pdo, $category, $search, $page, $perPage);
$total = countAnnouncements($pdo, $category, $search);
$totalPages = ceil($total / $perPage);
$categories = getCategories($pdo);

include 'header.php';
?>
<section class="hero-section">
	<div class="hero-container">
		<h2>Доска объявлений кафедры</h2>
		<p>Актуальные новости, научные мероприятия и учебные материалы для студентов и преподавателей факультета математики и компьютерных наук</p>
	</div>
</section>

<main class="main-content">
	<section class="filter-panel">
		<form method="GET" action="index.php" style="display: flex; gap: 1rem; width: 100%; flex-wrap: wrap;">
			<input type="text" name="search" class="search-input" placeholder="Поиск объявлений..." value="<?= htmlspecialchars($search) ?>">
			<select name="category" class="select-input">
				<option value="">Все категории</option>
				<?php foreach ($categories as $cat): ?>
					<option value="<?= $cat['slug'] ?>" <?= $category == $cat['slug'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
				<?php endforeach; ?>
			</select>
			<button type="submit" class="btn btn-primary">Найти</button>
		</form>
	</section>

	<section class="announcements-grid" id="announcements-container">
		<?php if (empty($announcements)): ?>
			<p style="grid-column: 1/-1; text-align: center; color: #64748b;">Ничего не найдено</p>
		<?php else: ?>
			<?php foreach ($announcements as $ann): ?>
				<a href="announcement.php?id=<?= $ann['id'] ?>" class="card">
					<div class="card-img-wrapper"><img src="images/indexzagl.png" alt="Изображение"></div>
					<div class="card-body">
						<span class="badge <?= $ann['color_class'] ?>"><?= htmlspecialchars($ann['category_name']) ?></span>
						<h3 class="card-title"><?= htmlspecialchars($ann['title']) ?></h3>
						<p class="card-text"><?= htmlspecialchars($ann['excerpt']) ?></p>
						<div class="card-meta">
							<span><?= date('d.m.Y', strtotime($ann['created_at'])) ?></span>
							<span><?= $ann['views'] ?></span>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		<?php endif; ?>
	</section>

	<?php if ($totalPages > 1): ?>
		<div class="pagination">
			<?php if ($page > 1): ?>
				<a href="?page=<?= $page - 1 ?>&category=<?= urlencode($category) ?>&search=<?= urlencode($search) ?>" class="page-link">«</a>
			<?php else: ?>
				<span class="page-link disabled">«</span>
			<?php endif; ?>

			<?php for ($i = 1; $i <= $totalPages; $i++): ?>
				<a href="?page=<?= $i ?>&category=<?= urlencode($category) ?>&search=<?= urlencode($search) ?>" class="page-link <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
			<?php endfor; ?>

			<?php if ($page < $totalPages): ?>
				<a href="?page=<?= $page + 1 ?>&category=<?= urlencode($category) ?>&search=<?= urlencode($search) ?>" class="page-link">»</a>
			<?php else: ?>
				<span class="page-link disabled">»</span>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</main>
<?php include 'footer.php'; ?>