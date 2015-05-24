<header>
	<div class="logo">

		YK STEEL
 <?php if(isset($_GET['username']))
{?>
	
	<p>Hello, <?= $_GET['username']?></p>
	<?php
	}
	?>



	</div>
	<div class="contact">
		<div class="phoneSection">
			<img  src="images/phoneTop.png" alt="phone" class="phone">8 499 123 22 333

		</div>
		<div class="mailSection">
			<img src="images/mailTop.png" alt="" class="mail">
			<a href="mailto:yermakov.kirill@gmail.com">YERMAKOV.KIRILL@GMAIL.COM</a>
		</div>
		<div class="basketAndCheckout">
			<?php
			$goods = myBasket();
			if(!is_array($goods)){
				echo 'Произошла ошибка при выводе товаров';
				exit;
			}
			$i=1; $sum=0;
			foreach($goods as $item){
				$i++;
				$sum += $item['price'] * $item['quantity'];
			}
			$basketImg = "images/basketTop.png";
			if($sum>0){
				$basketImg="images/basketloadedTop.png";
			}
			
			
			?>
			<img src="<?= $basketImg?>" alt='<?= $basketImg?>' class="basket"><div class="sum">$ <?= $sum?></div>
			<div class="checkout">
				CHECKOUT &nbsp <nav id="productsBasket">
				<ul id="productsInBasket">
					<li>
						<a class="fst" href="#"
						onmouseover="mopen('allProductsInBasket')"
						onmouseout="mclosetime()" ><img src="images/checkoutTop.png" alt="" class=""></a>
						<div id="allProductsInBasket" class="prodinB" onmouseover="mcancelclosetime()"
							onmouseout="mclosetime()">	
						<?php

						$i=1; $sum=0;
						foreach($goods as $item){
							?>
							
							
							
						
							
						
							<table class="productsToCheckout">
								<tr>
									<td class="firstTD"><p><?= $item['name']?></p> </td>
									<td><img src="<?= $item['imgurl']?>" width="100" height="100" alt="" ></td>
								</tr>
							</table>
							
							
							

							<?
						}
						?>	

					</div>
				</li>
				
			</ul>
			<div style="clear:both"></div>
		</nav>
	</div>
</div>
</div>
<hr class="style-six">
<nav id="main">
	<ul id="sddm">
		<li ><a class="fst" href="#"
			onmouseover="mopen('m1')"
			onmouseout="mclosetime()" >Home</a>
			<div id="m1"
			onmouseover="mcancelclosetime()"
			onmouseout="mclosetime()">
			<a href="#">HTML Drop Down</a>
			<a href="#">DHTML Menu</a>
			<a href="#">JavaScript DropDown</a>
			<a href="#">Cascading Menu</a>
			<a href="#">CSS Horizontal Menu</a>
		</div>
	</li>
	<li><a href="#"
		onmouseover="mopen('m2')"
		onmouseout="mclosetime()">Download</a>
		<div id="m2"
		onmouseover="mcancelclosetime()"
		onmouseout="mclosetime()">
		<a href="#">ASP Dropdown</a>
		<a href="#">Pulldown menu</a>
		<a href="#">AJAX Drop Submenu</a>
		<a href="#">DIV Cascading Menu</a>
	</div>
</li>
<li><a href="basic-auth/login.php">Sign IN</a></li>
<li><a href="#">Help</a></li>
<li><a href="#">Contact</a></li>
</ul>
<div style="clear:both"></div>
</nav>




</header>