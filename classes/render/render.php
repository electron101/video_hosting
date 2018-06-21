<?php
//Отрисовка страницы
class Render
{
	//контекст данных
	var $CONTEXT;
	//Страница, которая будет загружена
	var $CONTENT;
	
	function __construct ()
	{
		$a = func_get_args();
		$i = func_num_args();
		switch($i)
		{
			case 0:
				$this -> CONTENT = "";
				$this -> CONTEXT = null;
				break;
			case 1:
				$this -> CONTENT = $a[0];
				$this -> CONTEXT = null;
				break;
			case 2:
				$this -> CONTENT = $a[0];
				$this -> CONTEXT = $a[1];
				break;
		}
	}
	
	function renderPage()
	{
		$CONTENT = $this -> CONTENT;
		
		//Контекст данных
		$context = null;
		if ($this -> CONTEXT != null)
			$context =  $this -> CONTEXT;
		
		//Подлючение базового файла шаблона и подгрузка основного контента
		$FILENAME = "templates/".$GLOBALS["BASE_FILE"];
		if (file_exists($FILENAME))
			include ("templates/".$GLOBALS["BASE_FILE"]);
		else
			include ("service_files/start_project.php");
	}
}
?>