<?php
require_once 'config.php';
require_once 'functions.php';
if (!isLoggedIn() || !in_array($_SESSION['role'], ['teacher', 'admin'])) die('Доступ запрещён');
$id = (int)$_GET['id'];
$stmt = $pdo->prepare("SELECT author_id FROM announcements WHERE id = ?");
$stmt->execute([$id]);
$ann = $stmt->fetch();
if (!$ann) die('Не найдено');
if ($_SESSION['role'] != 'admin' && $ann['author_id'] != $_SESSION['user_id']) die('Нет прав');
$pdo->prepare("DELETE FROM announcements WHERE id = ?")->execute([$id]);
header("Location: index.php");
exit;
