<!-- Base -->
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Video</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">	
		
		<link rel="stylesheet" href="static/style.css">
	</head>
		<body>
			<header class="main_header">
				<a href="index.php" class="logo">
					<span><b>V</b>ideo<b>H</b>osting</span>
				</a>
				<?php if (!isset($_SESSION['log'])): ?>
				<a href="?act=enter" class="auth">
					<span>Авторизация/Вход</span>
				</a>
				<?php endif; ?>
				<?php if (isset($_SESSION['log'])): ?>
				<a href="?act=logout" class="auth">
					<span>Выход</span>
				</a>
				<a href="?act=lk" class="auth">
					<span><?=$_SESSION['log']?></span>
				</a>
				<?php endif; ?>
			</header>
			<section class="main_content">
				<?php if ($CONTENT != "") require $CONTENT;	?>
			</section>
			<footer>
			</footer>
		</body>
</html>