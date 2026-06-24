<?php
require_once 'config.php';

function isLoggedIn()
{
	return isset($_SESSION['user_id']);
}

function getUser($pdo, $id)
{
	$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
	$stmt->execute([$id]);
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getCategories($pdo)
{
	$stmt = $pdo->query("SELECT * FROM categories ORDER BY name");
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAnnouncements($pdo, $category = null, $search = '', $page = 1, $perPage = 3)
{
	$offset = ($page - 1) * $perPage;
	$params = [];
	$sql = "SELECT a.*, u.name as author_name, c.name as category_name, c.color_class 
            FROM announcements a
            JOIN users u ON a.author_id = u.id
            JOIN categories c ON a.category_id = c.id
            WHERE 1=1";
	if ($category && $category !== '') {
		$sql .= " AND c.slug = ?";
		$params[] = $category;
	}
	if ($search) {
		$sql .= " AND (a.title LIKE ? OR a.body LIKE ?)";
		$params[] = "%$search%";
		$params[] = "%$search%";
	}
	$perPage = (int)$perPage;
	$offset = (int)$offset;
	$sql .= " ORDER BY a.created_at DESC LIMIT $perPage OFFSET $offset";
	$stmt = $pdo->prepare($sql);
	$stmt->execute($params);
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function countAnnouncements($pdo, $category = null, $search = '')
{
	$params = [];
	$sql = "SELECT COUNT(*) FROM announcements a
            JOIN categories c ON a.category_id = c.id
            WHERE 1=1";
	if ($category && $category !== '') {
		$sql .= " AND c.slug = ?";
		$params[] = $category;
	}
	if ($search) {
		$sql .= " AND (a.title LIKE ? OR a.body LIKE ?)";
		$params[] = "%$search%";
		$params[] = "%$search%";
	}
	$stmt = $pdo->prepare($sql);
	$stmt->execute($params);
	return $stmt->fetchColumn();
}

function getComments($pdo, $announcementId)
{
	$stmt = $pdo->prepare("SELECT c.*, u.name, u.role FROM comments c
                           JOIN users u ON c.user_id = u.id
                           WHERE c.announcement_id = ?
                           ORDER BY c.created_at ASC");
	$stmt->execute([$announcementId]);
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
