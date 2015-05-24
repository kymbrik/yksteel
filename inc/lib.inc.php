<?php
function clearInt($data){
	return abs((int)$data);
}

function clearStr($data){
	global $link;
	return mysqli_real_escape_string($link, trim(strip_tags($data)));
	
}

function saveBasket(){
	global $basket;
	$basket = base64_encode(serialize($basket));
	setcookie('basket', $basket, 0x7FFFFFFF);
}

function basketInit(){
	global $basket, $count;
	if(!isset($_COOKIE['basket'])){
		$basket = array('orderid' => uniqid());
		saveBasket();
	}else{
		$basket = unserialize(base64_decode($_COOKIE['basket']));
		//print_r($basket); exit;
		$count = count($basket) - 1;
	}
}
function add2Basket($id, $q){
	global $basket;
	$basket[$id] = 1;
	saveBasket();
}



function addItemToCatalog($name, $category, $description, $imgurl, $price){
	global $link;
	$sql = "INSERT INTO products(
								name,
								category,
								description,
								imgurl,
								price)
								 VALUES(?, ?, ?, ?, ?)";
	if (!$stmt = mysqli_prepare($link, $sql))
		return false;
	mysqli_stmt_bind_param($stmt, "ssssi", $name, $category, $description, $imgurl, $price);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);
	return true;
}

function saveOrder($dt){
	global $link, $basket;
	$goods = myBasket();
	$stmt = mysqli_stmt_init($link);
	$sql = 'INSERT INTO orders(
								title,
								author,
								pubyear,
								price,
								quantity,
								orderid,
								datetime) 
								VALUES(?,?,?,?,?,?,?)';
	if(!mysqli_stmt_prepare($stmt, $sql))
		return false;
	foreach($goods as $item){
		mysqli_stmt_bind_param($stmt, 'ssiiisi', $item['title'],
		$item['author'], $item['pubyear'], 
		$item['price'], $item['quantity'], $basket['orderid'], $dt);
		mysqli_stmt_execute($stmt);
	}
	mysqli_stmt_close($stmt);
	setcookie('basket', '', time()-3600);
	return true;
	
}

function selectAllItems($productId){
	global $link;
	$sql = "SELECT ProductEntity.product_id, ProductAttribute.attribute_name, AttributeValue.attribute_value  
FROM ProductEntity
JOIN ProductAttribute on ProductAttribute.product_id = ProductEntity.product_id
JOIN AttributeValue on AttributeValue.attribute_id =  ProductAttribute.attribute_id
			and AttributeValue.product_id = ProductEntity.product_id
			WHERE ProductEntity.product_id = '{$productId}' ";
		
	if(!$result = mysqli_query($link, $sql))
		return false;
	$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
	mysqli_free_result($result);
	return $items;
}


function selectAllProductId(){
	global $link;
	$sql = "SELECT ProductEntity.product_id
FROM ProductEntity";
	if(!$result = mysqli_query($link, $sql))
		return false;
	$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
	mysqli_free_result($result);
	return $items;
}

function objectToarray($data)
   {
       $array = (array)$data;
       foreach($array as $key => &$field){
           if(is_object($field))$field = objectToarray($field);
       }
       return $array;
   }



function myBasket(){
	global $link, $basket;
	$goods = array_keys($basket);
	array_shift($goods);
	if(count($goods))
		$ids = implode(",", $goods);
	else
		$ids = 0;
	$sql = "SELECT id, name, category, description, imgurl, price FROM products WHERE id IN ($ids)";
	if(!$result = mysqli_query($link, $sql))
		return false;
	$items = result2Array($result);
	mysqli_free_result($result);
	return $items;
	
}

function result2Array($data)
{
	global $basket;
	$arr = array();
	while($row = mysqli_fetch_assoc($data)){
		$row['quantity'] = $basket[$row['id']];
		$arr[] = $row;
	}
	return $arr;
}

function deleteItemFromBasket($id){
	global $basket;
	unset($basket[$id]);
	saveBasket();
	
}

function getOrders(){
	global $link;
	if(!is_file(ORDERS_LOG))
		return false;
	$orders = file(ORDERS_LOG);
	
	$allorders = array();
	
	foreach ($orders as $order){
		list($n, $e, $p, $a, $oid, $dt) = explode("|", $order);
		$orderinfo = array();
		
		$orderinfo['name'] = $n;
		$orderinfo['email'] = $e;
		$orderinfo['phone'] = $p;
		$orderinfo['address'] = $a;
		$orderinfo['orderid'] = $oid;
		$orderinfo['dt'] = $dt;
		
		$sql = "SELECT title, author, pubyear, price, quantity
								FROM orders
								WHERE orderid = '$oid'";
								
		if(!$result = mysqli_query($link, $sql))
			return false;
		$items = mysqli_fetch_all($result, MYSQLI_ASSOC);
		mysqli_free_result($result);
		
		$orderinfo['goods'] = $items;
		
		$allorders[] = $orderinfo;
			
}
return $allorders;
}

function createRss(){
		
	$RSS_NAME = 'rss.xml';
	$RSS_TITLE = 'Товары';
	$RSS_LINK = 'http://mysite.local/yksteel/index.php';
	$dom = new DomDocument('1.0', 'utf-8');
	
	$dom->formatOutput = true;
	$dom->preserveWhiteSpace = false;
	
	$rss = $dom->createElement('rss');
	$dom->appendChild($rss);
	
	$channel = $dom->createElement('channel');
	$dom->appendChild($channel);
	
	$t = $dom->createElement('title', RSS_TITLE);
	$l = $dom->createElement('link', RSS_LINK);
	$channel->appendChild($t);
	$channel->appendChild($l);
	
	$lenta = selectAllItems();
	if(!$lenta) return false;
	foreach($lenta as $news){
		$i = $dom->createElement('item');
		$t = $dom->createElement('title', $news['title']);
		$n = $dom->createElement('name', $news['name']);
		$c = $dom->createElement('category', $news['category']);
		$d = $dom->createElement('description', $news['description']);
		$img = $dom->createElement('imgurl', $news['imgurl']);
		$p = $dom->createElement('price', $news['price']);
		$txt = $RSS_LINK.'?id='.$news['id'];
		
		$l = $dom->createElement('link', $txt);
		$dt = date('r', $news['datetime']);
		$pd = $dom->createElement('pubDate', $dt);
		$i->appendChild($t);
		$i->appendChild($l);
		$i->appendChild($n);
		$i->appendChild($d);
		$i->appendChild($pd);
		$i->appendChild($c);
		$i->appendChild($img);
		$i->appendChild($p);
		$channel->appendChild($i);
	}
	$dom->save(RSS_NAME);
	
}




