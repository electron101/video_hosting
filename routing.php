<?php
//Маршрутизация
	$act = "";
	if (isset($_POST['act']))
		$act = isset($_POST['act']) ? $_POST['act'] : "";
	else if (isset($_GET['act']))
		$act = isset($_GET['act']) ? $_GET['act'] : "";
	
	switch($act)
	{
		case "enter":
			enter();
			break;
		case "register":
			register();
			break;
		case "login":
			login($mysqli);
			break;
		case "logout":
			logout();
			break;
		case "lk":
			lk($mysqli);
			break;
		case "upload":
			upload($mysqli);
			break;
		case "do_register":
			do_register($mysqli);
			break;
		default:
			loadBasePage($mysqli);
			break;
	}
?>