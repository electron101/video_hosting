<?php
session_start();

function loadBasePage($mysqli)
{ 
	$row = $mysqli->query(" SELECT * FROM video ");

	$context = array();
	
	while($video = $row->fetch_array())
	{
		array_push($context, $video);
	}

	$render = new Render("templates\\start.php", $context);
	return $render -> renderPage();
}

function delete()
{
	
}

function search($mysqli)
{
	if (isset($_POST['search_text']))
	{
		$search_text = $_POST['search_text'];
		if ($search_text == "")
		{
			loadBasePage($mysqli);
			return;
		}
		
		$row = $mysqli->query(" SELECT * FROM video WHERE name like '%".$search_text."%'");

		$context = array();
	
		while($video = $row->fetch_array())
		{
			array_push($context, $video);
		}

		$render = new Render("templates\\start.php", $context);
		return $render -> renderPage();
	}
}

function enter()
{	
	$render = new Render("templates\\enter.php");
	return $render -> renderPage();
}

function register()
{	
	$render = new Render("templates\\register.php");
	return $render -> renderPage();
}

function login($mysqli)
{
	if (isset($_POST['log']) && isset($_POST['pass']))
	{
		$log = $_POST['log'];
		$pass = $_POST['pass'];
		
		if ($log != 'admin')
			$pass = sha1($pass);
		
		$row = $mysqli->query("	SELECT * FROM users WHERE name = '$log' 
								AND pass = '$pass'");

		if ($row->num_rows == 0) 
		{
			$row->close();
			$mysqli->close();
			$context = "Пользователя с таким именем нет в базе";
			$render = new Render("templates\\reg_errors.php", $context);
			return $render -> renderPage();
		}
		else
		{
			$user = $row->fetch_array();


			$_SESSION['log'] = $user['name'];

			
			$row->close();
			$mysqli->close();
			
			$render = new Render("templates\\start.php");
			return $render -> renderPage();
		}
	}
}

function logout()
{
	unset($_SESSION['log']);
	session_destroy();
	
	$render = new Render("templates\\start.php");
	return $render -> renderPage();
}

function lk($mysqli)
{
	$log = $_SESSION['log'];
	$row = $mysqli->query("SELECT users.name, users.datereg, video.id, video.name as 'name_video', video.date
				FROM users
				Inner Join video On video.user_id = users.id
				WHERE users.name = '$log'");
	$user_info = array();
	while ($user = $row->fetch_array())
	{
		array_push($user_info, $user);
	}
	
	$context = $user_info;
	
	$render = new Render("templates\\lk.php", $context);
	return $render -> renderPage();
}

function upload($mysqli)
{
	if (isset($_POST['name']) && isset($_POST['desc']))
	{
		$name = $_POST['name'];
		$desc = $_POST['desc'];
		$log = $_SESSION['log'];
		
		$row = $mysqli->query("SELECT id FROM users WHERE name = '$log'");
		$user_id = $row->fetch_array();
		$id = $user_id['id'];
		
		//Путь
		$uploaddir = 'downloads/';
			
		$file_name = time().translit($_FILES['video']['name']);
			
		$uploadfile = $uploaddir . basename($file_name);
			
		if (move_uploaded_file($_FILES['video']['tmp_name'], $uploadfile)){
		}
		else
		{
			$context = "Ошибка при загрузке видео 1";
			$render = new Render("templates\\reg_errors.php", $context);
			return $render -> renderPage();
		}
			
		$video = 'downloads/' . $file_name;
		$sql = "INSERT INTO video (name, description, video, user_id) 
							VALUES ('".$name."', '".$desc."', '".$video."', ".$id.")";
											

		if ($mysqli->query($sql) === FALSE)
		{
			$context = "Ошибка при загрузке видео 2";
			$render = new Render("templates\\reg_errors.php", $context);
			return $render -> renderPage();
		}
		
		$mysqli->close();
		
		$render = new Render("templates\\upload_success.php");
		return $render -> renderPage();
	}
}

function do_register($mysqli)
{
	if (isset($_POST['login']) && isset($_POST['pass']) && isset($_POST['pass2']))
	{
		$login = $_POST['login'];
		$pass = $_POST['pass'];
		$pass2 = $_POST['pass2'];
		
		if ($pass != $pass2)
		{
			$context = "Пароли не совпадают";
			$render = new Render("templates\\reg_errors.php", $context);
			return $render -> renderPage();
		}
		else
		{
			$row = $mysqli->query("SELECT * FROM users WHERE name = '$login'");

			if ($row->num_rows != 0) 
			{
				$context = "Пользователь с таким именем уже есть в базе";
				$render = new Render("templates\\reg_errors.php", $context);
				return $render -> renderPage();
			}
			
			$row->close();
			
			if (!($stmt = $mysqli->prepare("INSERT INTO users (name, pass, datereg, stat) 
										VALUES (?, ?, CURRENT_DATE, 2)")))
			{
				$context = "Ошибка при подготовке запроса";
				$render = new Render("templates\\reg_errors.php", $context);
				return $render -> renderPage();
			}
	
			/*******************************************************************************************/

								/****************************
								 *	ПРИВЯЗКА ДАННЫХ			*
								 ****************************/

			if (!$stmt->bind_param('ss', $login, sha1($pass)))
			{
				$context = "Ошибка при привязке параметров";
				$render = new Render("templates\\reg_errors.php", $context);
				return $render -> renderPage();
			}
	
		

								/****************************
								 *	ВЫПОЛНЕНИЕ ЗАПРОСА		*
								 ****************************/

			if (!$stmt->execute())
			{
				$context = "Ошибка при выполнении запроса";
				$render = new Render("templates\\reg_errors.php", $context);
				return $render -> renderPage();
			}
	
			/*******************************************************************************************/
	
			/* закрываем запрос */
			$stmt->close();
			/* закрываем открытое соединение */
			$mysqli->close(); 
			
			$render = new Render("templates\\enter.php");
			return $render -> renderPage();
		}
	}
}

function translit($str) {
	$rus = array('А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я', 'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я');
	$lat = array('A', 'B', 'V', 'G', 'D', 'E', 'E', 'Gh', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'C', 'Ch', 'Sh', 'Sch', 'Y', 'Y', 'Y', 'E', 'Yu', 'Ya', 'a', 'b', 'v', 'g', 'd', 'e', 'e', 'gh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'sch', 'y', 'y', 'y', 'e', 'yu', 'ya');
    return str_replace($rus, $lat, $str);
}
?>