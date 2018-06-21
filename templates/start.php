<div>
<form action="" method="POST">
	<input type="hidden" name="act" value="search">
	<input type="text" name="search_text">
	<input type="submit" value="Найти">
</form>
</div>
<div>
<?php 
	if (count($context) == 0)
	{
		echo '<p>Ничего не найдено по вашему запросу.</p>';
	}
	else {
?>
<?php for($i=0;$i<count($context);$i++): ?>
	<video src="<?=$context[$i]['video']?>" width="400" height="300" controls ></video>
	<p>Наименование: <?=$context[$i]['name']?></p>
	<p>Описание: <?=$context[$i]['description']?></p>
	<p>Дата загрузки: <?=$context[$i]['date']?></p>
<?php endfor; }?>
</div>