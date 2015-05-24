<?php
header('Content-Type:text/html;charset=utf-8');
define('DB_HOST','localhost');
define('DB_LOGIN','root');
define('DB_PASSWORD','');
define('DB_NAME','yksteel');
define('ORDERS_LOG','orders.log');
define('RSS_NAME','rss.xml');
define('RSS_TITLE','Товары');
define('RSS_LINK','http://mysite.local/yksteel/index.php');
$basket = array();
$count = 0;
$link  = mysqli_connect(DB_HOST, DB_LOGIN,DB_PASSWORD, DB_NAME) or die(mysqli_connect_error());
basketInit();