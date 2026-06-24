<?php
require_once 'config.php';
require_once 'functions.php';
if (!isLoggedIn()) die('Требуется авторизация');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$ann_id = (int)$_POST['announcement_id'];
	$content = trim($_POST['content']);
	if ($content && $ann_id) {
		$stmt = $pdo->prepare("INSERT INTO comments (announcement_id, user_id, content) VALUES (?, ?, ?)");
		$stmt->execute([$ann_id, $_SESSION['user_id'], $content]);
		header("Location: announcement.php?id=$ann_id");
		exit;
	}
}
header("Location: index.php");
