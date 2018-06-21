<?php

$mysqli = new mysqli("localhost", "root", "", "video"); 
// кодировка по умолчанию
if (!$mysqli->set_charset("utf8")) {
    printf("Ошибка при загрузке набора символов utf8: %s\n", $mysqli->error);
}
// устанавливает/получает внутреннюю кодировку символов
mb_internal_encoding('UTF-8');

if (mysqli_connect_errno()) 
{ 
    printf("Подключение невозможно: %s\n", mysqli_connect_error()); 
    exit(); 
}

/*
Объявляем глобальные переменные, если они нужны
Последовательно подключаем файл настроек, файл рендеринга страниц,
файл с функциями, файл маршрутизации
*/
//Имя шаблона
$TEMPLATE_NAME = "";
//Соединение с бд
$CONN = null;

include ("settings.php");
include ("classes/render/render.php");
include ("functions.php");
include ("routing.php");
?>