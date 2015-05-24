<?php
	// подключение библиотек
	require "secure/session.inc.php";
	require "../inc/lib.inc.php";
	require "../inc/db.inc.php";

	
	$name = clearStr($_POST['name']);
	$category = clearStr($_POST['category']);
	$description = clearStr($_POST['description']);
	$imgurl = clearStr($_POST['imgurl']);
	$price = clearInt($_POST['price']);
	
	if(!addItemToCatalog($name, $category, $description, $imgurl, $price)){
		echo 'Произошла ошибка при добавлении товара в каталог';
	}else{
		createRss();
		header("Location: add2cat.php");
		exit;
	}
	
?>