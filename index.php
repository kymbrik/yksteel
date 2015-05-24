<?php
	// подключение библиотек
require "inc/lib.inc.php";
require "inc/db.inc.php";
session_start();

?>
<!doctype html>
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
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
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
<div class="search">
	<form name="searchForm" action="index.php" method="post">
		<input type="text" name="searchBox" placeholder="Search product..."/>
		<input type="submit" name="search" value="Go" />
	</form>
	
</div>
<div class="category">

	<figure >
		<img src="images/procImg.jpg" width="401" height="232" alt="" class="fst">
		<figcaption>Processors<span>Intel, AMD</span></figcaption>
	</figure>
	<figure>
		<img src="images/video.png" width="401" height="232" alt="" >
		<figcaption>Video Cards<span>Asus, Gigabyte, MSI</span></figcaption>
	</figure>
	<figure>
		<img src="images/msi.jpg" width="401" height="232" alt="">
		<figcaption>Motherboards<span>Asus,Gigabyte, ASRock</span></figcaption>
	</figure>
</div>
<section>
	<h2>

		POPULAR PRODUCTS
		<a href="index.php">wtf</a>
		<? echo $_GET['id']."sdgsdg";?>
	
	</h2>

	<div class="popularProducts">
		<div class="allProducts">
			
			<?php
			global $link;


			$ids = selectAllProductId();
		
			
foreach($ids as $productId){
	
	$goods = selectAllItems($productId['product_id']);
	
			if(!is_array($goods)){
				echo 'Произошла ошибка при выводе товаров';
				exit;
			}
			if(!$goods){
				echo $productId['product_id'];
				echo 'На  сегодня товаров нет.';
				exit;
			}
			
			$product_id=$productId['product_id'];
			$imgurl;
			$category;
			$brand;
			
			$attributes = array();
			
			
				
			foreach($goods as $item){
				array_push($attributes, $item['attribute_name']);
				if($item['attribute_name']=='imgurl') $imgurl=$item['attribute_value'];
				if($item['attribute_name']=='category') $category=trim($item['attribute_value']);
				if($item['attribute_name']=='Brand Name')$brand=$item['attribute_value'];
			}
			
			$attributes_unique = array_unique($attributes);
			
			if(isset($_POST['search'])){
				
			$searchTerm=$_POST['searchBox'];
	if($category == $searchTerm ||  $brand == $searchTerm){?>
				<a href="index.php?id=<?=$product_id?>">
				<figure id="<?=$product_id ?>" class="products">
					<img src="<?=$imgurl?>" width="270" height="270" alt="" class="fst">
					<figcaption><?=$brand?><span><?=$category?></span><span class="descr"><?=$item['description']?>AMD FX-6300 — это процессор, который основанный на микроархитектуре Piledriver и изготовленный по 32 нм техпроцессу. Частота процессора, оснащенного ядрами Vishera, — 3.5 ГГц. Имеется поддержка режима Turbo, повышающая частоту до 4.1 ГГц. Процессор имеет 6 МБ кеша второго уровня и 8 МБ кеша третьего уровня и оснащен новыми энергосберегающими технологиями. Тепловыделение процессора составляет 95 Вт.</span></figcaption>
					<div class="figDescr">
						<td><a href="add2basket.php?id=<?=$item['id']?>">В корзину </a></td>
					
					</div>
					
				</figure>
				</a>
				
				
			<?} 
	}
	
	if(isset($_GET['search'])){
				
			$searchTerm=$_POST['searchBox'];
	if($category == $searchTerm ||  $brand == $searchTerm){?>
				<a href="index.php?id=<?=$product_id?>">
				<figure id="<?=$product_id ?>" class="products">
					<img src="<?=$imgurl?>" width="270" height="270" alt="" class="fst">
					<figcaption><?=$brand?><span><?=$category?></span><span class="descr"><?=$item['description']?>AMD FX-6300 — это процессор, который основанный на микроархитектуре Piledriver и изготовленный по 32 нм техпроцессу. Частота процессора, оснащенного ядрами Vishera, — 3.5 ГГц. Имеется поддержка режима Turbo, повышающая частоту до 4.1 ГГц. Процессор имеет 6 МБ кеша второго уровня и 8 МБ кеша третьего уровня и оснащен новыми энергосберегающими технологиями. Тепловыделение процессора составляет 95 Вт.</span></figcaption>
					<div class="figDescr">
						<td><a href="add2basket.php?id=<?=$item['id']?>">В корзину </a></td>
					
					</div>
					
				</figure>
				</a>
				
				
			<?} 
	}
	
	if(isset($_GET['id'])){?>
				
		<table>
			<?php 
			if($product_id == $_GET['id']){
				foreach($goods as $item){
					foreach($attributes_unique as $attribute)
					{
						if($attribute == $item['attribute_name'])
						{	
							if($item['attribute_name'] == 'imgurl'){
								echo "<tr><td><img src='".$item['attribute_value']."'></td></tr>";
							}else{
								echo "<tr><td>".$attribute.": ".$item['attribute_value']."</td></tr>"; 
							}
							?> 
							
					<?	
						}
					}
				}
			}
			?>
		</table>
				
				
			<?} 
	
	
	
	
	
		
			
			if(!isset($_POST['search']) and $_POST['searchBox']=="" and !isset($_GET['id'])){
		
				?>
	
				<a href="index.php?id=<?=$product_id?>">
				<figure id="<?=$product_id ?>" class="products">
					<img src="<?=$imgurl?>" width="270" height="270" alt="" class="fst">
					<figcaption><?=$brand?><span><?=$category?></span><span class="descr"><?=$item['description']?>AMD FX-6300 — это процессор, который основанный на микроархитектуре Piledriver и изготовленный по 32 нм техпроцессу. Частота процессора, оснащенного ядрами Vishera, — 3.5 ГГц. Имеется поддержка режима Turbo, повышающая частоту до 4.1 ГГц. Процессор имеет 6 МБ кеша второго уровня и 8 МБ кеша третьего уровня и оснащен новыми энергосберегающими технологиями. Тепловыделение процессора составляет 95 Вт.</span></figcaption>
					<div class="figDescr">
						<td><a href="add2basket.php?id=<?=$item['id']?>">В корзину </a></td>
						
					</div>
					
				</figure>
				</a>
				<?
			}
}
			?>
		</div>

		
<!-- 
	<figure class="products">
			<img src="images/video.png" width="270" height="270" alt="" >
			<figcaption>Video Cards<span>Asus, Gigabyte, MSI</span>
				<span class="descr">Asus, Gigabyte, MSI</span></figcaption>
			</figure>
			<figure class="products">
				<img src="images/msi.jpg" width="270" height="270" alt="">
				<figcaption>Motherboards<span>Asus,Gigabyte, ASRock</span><span class="descr">Asus, Gigabyte, MSI</span></figcaption>
			</figure>
			<figure class="products">
				<img src="images/msi.jpg" width="270" height="270" alt="">
				<figcaption>Motherboards<span>Asus,Gigabyte, ASRock</span><span class="descr">Asus, Gigabyte, MSI</span></figcaption>
			</figure>
			 -->

		
		</div>


	</section>
<div class="clear"></div>
<div class="signUp"><p><span>SIGN UP</span> FOR EXCLUSIVE SALES AND PRODUCT NEWS</p>
<form name="search" action="#" method="get">
					<input type="text" name="q" placeholder="Your Email">
					<button class="sendMessage" type="submit">SIGN UP</button>
				</form>
</div>
	<footer>
		<div class="footer1"><h3>
			
			OUR STORES

		</h3>
	
		<p>Feel free to visit our stores or contact us.</p>
		<p>1401 South Grand Avenue</p>
		<p>Los Angeles, CA 90015</p>
		<p>(213) 748-2411</p>
			
		<span class="sprite facebook"><a class="linkSprite" href="http://facebook.com"></a></span>
		<span class="sprite twitter"><a class="linkSprite" href="http://twitter.com"></a></span>
		<span class="sprite google"><a class="linkSprite" href="http://google.com"></a></span>
		<span class="sprite vimeo"><a class="linkSprite" href="http://vimeo.com"></a></span>
		<span class="sprite rss"><a class="linkSprite" href="http://rss.com"></a></span>
		</div>
		
		
		<div class="footer2">
			<h3>BLOG POSTS</h3>
		<p class="white">
			Justin Bieber confirmed that he is gay
		</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
			Donec sed auctor elit.</p>
		</div>
		<div class="footer3">
			<h3>SUPPORT</h3>
			<ul>
				<li><a href="#">Terms & Conditions</a></li>
				<li><a href="#">FAQ</a></li>
				<li><a href="#">Payment</a></li>
				<li><a href="#">Refunds</a></li>
				<li><a href="#">Track Order</a></li>
				<li><a href="#">Services</a></li>
				<li><a href="#">Prvacy & Security</a></li>
				<li><a href="#">Careers</a></li>
				<li><a href="#">Press</a></li>
				<li><a href="#">Corporate Information</a></li>

			</ul>

			<ul class="ulSecond">
				<li><a href="#">Sizing</a></li>
				<li><a href="#">Ordering</a></li>
				<li><a href="#">Shipping</a></li>
				<li><a href="#">Return Policy</a></li>
				<li><a href="#">Affiliates</a></li>
				<li><a href="#">Find A Store</a></li>
				<li><a href="#">Site Map</a></li>
				<li><a href="#">Sign Up & Save</a></li>
			</ul>

		</div>
		<div class="footer4"><h3>CONTACT US</h3>

<form name="contactUs" action="#" method="get">
					<input type="text" name="footerEmail" placeholder="Your Email">
					<input type="text" name="footerText" placeholder="Your Text">
					<button class="sendFooterMessage" type="submit">SEND MESSAGE</button>
				</form>
		</div>
	</footer>
</div>
</body>
</html>