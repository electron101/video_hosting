<div>
<p>Личная информация:</p>
<?php echo $context['name'].'<br>'; ?>
<?php echo $context['datereg']; ?>

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
</div>