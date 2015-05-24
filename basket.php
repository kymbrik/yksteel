<?php
	// подключение библиотек
	require "inc/lib.inc.php";
	require "inc/db.inc.php";
?>
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>YK STEEL</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<link rel="stylesheet" href="css/styles.css" type="text/css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">
	<link rel="stylesheet"  href="css/drop.css" type="text/css"/>
	<script type="text/javascript" src="js/drop.js"></script>
	<script src="js/common.js" > </script>
	<link rel="stylesheet" type="text/css" href="css/viewport.css" >
	<title>Корзина пользователя</title>
</head>
<body>
	<div id="wrapper">
		
		

<!-- Верхняя часть страницы -->
			<?php
				include "inc/top.inc.php";
	
			?>
			<!-- Верхняя часть страницы -->

<!-- ViewPort -->
			<?php
				include "inc/viewport.inc.php";
	
			?>
			<!-- ViewPort-->
			
			
			
			<h1>Ваша корзина</h1>
<?php
$goods = myBasket();
if(!is_array($goods)){
	echo 'Произошла ошибка при выводе товаров';
	exit;
}
if($goods){
	echo '<p>Вернуться в <a href="index.php">каталог</a></p>';
}else
{
	echo '<p>Корзина пуста! Вернитесь в <a href="catalog.php">каталог</a></p>';
}
?>
<table border="1" cellpadding="5" cellspacing="0" width="100%">
<tr>
	<th>N п/п</th>
	<th>Наименование</th>
	<th>Категория</th>
	<th>Описание</th>
	<th>Цена</th>
	<th>Количество</th>
	<th>Удалить</th>
</tr>
<?php

	$i=1; $sum=0;
	foreach($goods as $item){
	?>
	<tr>
		<td><?= $i?></td>
		<td><?= $item['name']?></td>
		<td><?= $item['category']?></td>
		<td><?= $item['description']?></td>
		<td><?= $item['price']?></td>
		<td><?= $item['quantity']?></td>
		<td><a href="delete_from_basket.php?id=<?=$item['id']?>">Удалить</a></td>
		</tr>
		<?
		$i++;
		$sum += $item['price'] * $item['quantity'];
	}
?>

</table>

<p>Всего товаров в корзине на сумму: <?= $sum?> руб.</p>

<div align="center">
	<input type="button" value="Оформить заказ!"
                      onClick="location.href='orderform.php'" />
</div>
			</div>
	

</body>
</html>







