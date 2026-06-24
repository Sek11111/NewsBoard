<?php
require_once 'config.php';
require_once 'functions.php';
if (isLoggedIn()) {
	header("Location: profile.php");
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = trim($_POST['email']);
	$password = $_POST['password'];
	$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND status = 'active'");
	$stmt->execute([$email]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($user && password_verify($password, $user['password_hash'])) {
		$_SESSION['user_id'] = $user['id'];
		$_SESSION['role'] = $user['role'];
		$_SESSION['name'] = $user['name'];
		header("Location: profile.php");
	} else {
		$error = 'Неверный email или пароль, либо аккаунт заблокирован.';
	}
}
$page_title = 'Вход';
include 'header.php';
?>
<main class="main-content">
	<div class="auth-wrapper">
		<h2 class="auth-title">Авторизация</h2>
		<?php if ($error): ?><div style="color:red; margin-bottom:1rem;"><?= $error ?></div><?php endif; ?>
		<form method="POST">
			<div class="form-group">
				<label class="form-label">Email</label>
				<input type="email" name="email" class="form-control" required>
			</div>
			<div class="form-group">
				<label class="form-label">Пароль</label>
				<input type="password" name="password" class="form-control" required>
			</div>
			<button type="submit" class="btn btn-primary" style="width:100%;">Войти</button>
		</form>
		<div class="auth-redirect">
			Нет аккаунта? <a href="register.php">Зарегистрироваться</a>
		</div>
	</div>
</main>
<?php include 'footer.php'; ?>