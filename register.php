<?php
require_once 'config.php';
require_once 'functions.php';
if (isLoggedIn()) {
	header("Location: profile.php");
	exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$name = trim($_POST['name']);
	$email = trim($_POST['email']);
	$group = trim($_POST['group']);
	$password = $_POST['password'];
	if (strlen($password) < 6) $error = 'Пароль должен быть не менее 6 символов';
	else {
		$hash = password_hash($password, PASSWORD_DEFAULT);
		try {
			$stmt = $pdo->prepare("INSERT INTO users (name, email, `group`, password_hash, role) VALUES (?, ?, ?, ?, 'student')");
			$stmt->execute([$name, $email, $group, $hash]);
			header("Location: login.php?registered=1");
			exit;
		} catch (PDOException $e) {
			if ($e->errorInfo[1] == 1062) $error = 'Этот email уже зарегистрирован';
			else $error = 'Ошибка регистрации';
		}
	}
}
$page_title = 'Регистрация';
include 'header.php';
?>
<main class="main-content">
	<div class="auth-wrapper">
		<h2 class="auth-title">Регистрация студента</h2>
		<?php if ($error): ?><div style="color:red; margin-bottom:1rem;"><?= $error ?></div><?php endif; ?>
		<form method="POST">
			<div class="form-group">
				<label class="form-label">ФИО</label>
				<input type="text" name="name" class="form-control" required>
			</div>
			<div class="form-group">
				<label class="form-label">Группа</label>
				<input type="text" name="group" class="form-control" required>
			</div>
			<div class="form-group">
				<label class="form-label">Email</label>
				<input type="email" name="email" class="form-control" required>
			</div>
			<div class="form-group">
				<label class="form-label">Пароль</label>
				<input type="password" name="password" class="form-control" required minlength="6">
			</div>
			<button type="submit" class="btn btn-primary" style="width:100%;">Создать аккаунт</button>
		</form>
		<div class="auth-redirect">
			Уже зарегистрированы? <a href="login.php">Войти</a>
		</div>
	</div>
</main>
<?php include 'footer.php'; ?>