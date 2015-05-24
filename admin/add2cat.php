<?
require "secure/session.inc.php";
?>
<html>
<head>
	<title>Форма добавления товара в каталог</title>
</head>
<body>
	<form action="save2cat.php" method="post">
		<p>Наименование: <input type="text" name="name" size="100">
		<p>Категория: <input type="text" name="category" size="50">
		<p>Описание: <input type="text" name="description" size="500">
		<p>Адрес фото: <input type="text" name="imgurl" size="500">
		<p>Цена: <input type="text" name="price" size="6"> руб.
		<p><input type="submit" value="Добавить">
	</form>
</body>
</html>