<?php
require "auth_class.php";
session_start();
?>

<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<title>PHPRO Login</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<link rel="stylesheet" href="../css/styles.css" type="text/css">
	<link rel="stylesheet" href="../css/login.css" type="text/css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,300" type="text/css">
<script type="text/javascript">
    function submitForm(action)
    {
        document.getElementById('logIn').action = action;
        document.getElementById('logIn').submit();
    }
</script>
	</head>

<body>
<div id="wrapper">
<header>
<div class="logo">

		YK STEEL
	</div>
	</header>
	
<form id="logIn" action="login_submit.php" method="post">
<fieldset>

<h3>Sign in</h3>
<?php session_start(); if (isset($_SESSION['username'])) {
	
	
	
	echo $_SESSION['username']." are now Logged In".'</br>';
	
}  
		$data = unserialize($_COOKIE['cookie']);
		foreach($data as $errmsg){
			echo $errmsg. '</br>';
			
		}

 ?>
 
 <?php if (!isset($_SESSION['username'])) {?>
<p>
<label for="phpro_username">Username</label>
<input type="text" id="username" name="username" value="" maxlength="20" />
</p>
<p>
<label for="phpro_password">Password</label>
<input type="text" id="password" name="password" value="" maxlength="20" />
</p>
<p>
<input name="login" type="submit" value="> Login" />
</p>
 <?php }?>
<p>
<input name="register" type="button" onclick="submitForm('basic-auth.php')" value="Register" />
 </p>
<p> 
  <input name="Logout" type="button" onclick="submitForm('log_out.php')" value="Logout" />
</p>
</fieldset>

</form>

</div>
</body>
</html>