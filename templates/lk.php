<div>
<p>Личная информация:</p>
<?php echo $context[0]['name'].'<br>'; ?>
<?php echo $context[0]['datereg']; ?>

<p>Добавить видео</p>
<form action="" method="Post" enctype="multipart/form-data">
	<input type="hidden" name="act" value="upload">
	<label for="video">Загрузить видео</label>
    <input type="file" name="video" id="video" required>
	<br>
	<label for="name">Наименование</label>
    <input type="text" name="name" id="name" required>
	<br>
	<label for="desc">Описание</label>
    <input type="text" name="desc" id="desc">
	<br>
	<input type="submit" value="Загрузить">
</form>

<p>Видео загруженное пользователем:</p>
<?php for($i=0;$i<count($context);$i++): ?>
	<p>Наименование: <?=$context[$i]['name_video']?></p>
	<p>Дата загрузки: <?=$context[$i]['date']?></p>
	<form action="" method="POST">
		<input type="hidden" name="act" value="delete">
		<input type="hidden" name="id" value="<?=$context[$i]['id']?>">
		<input type="submit" value="Удалить">
	</form>
<?php endfor; ?>

</div>