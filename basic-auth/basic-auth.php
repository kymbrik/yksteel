<?php
require "../inc/lib.inc.php";
require "../inc/db.inc.php";
/*** begin our session ***/
//Стартовать сессию только тем, кто ввел пароль, или тем, у кого уже стартовала сессия.
	//if (isset($_REQUEST[session_name()])) 
	
		session_start();

echo session_id($_COOKIE['PHPSESSID']);
/*** set a form token ***/
$form_token = md5( uniqid('auth', true) );

/*** set the session form token ***/
$_SESSION['form_token'] = $form_token;

$error="";
function calculateYearsOld(){
	$curdate=date("m.d.y");
	$d1 = strtotime($curdate);
	$d2 = strtotime($_POST['birthday']);
	$diff = $d1-$d2;
	$diff = $diff/(60*60*24*365);
	$years = floor($diff);
	return $years;
}
/*** Split entered birthday in array and return the validation result ***/
function checkValidBirthday(){
	$explo = preg_split('/[-.,:\\\\\/;]/', $_POST['birthday'], 3, PREG_SPLIT_NO_EMPTY);
	$error="err";
	return checkdate ($explo[0], $explo[1], $explo[2] );
}
/*** first check that both the username, password and form token have been sent ***/
if(!isset($_SESSION['count'])  AND !isset( $_POST['username'], $_POST['password'], $_POST['birthday'], $_POST['form_token']))
{
	$error="err";
    echo 'Please enter a valid username and password'. '</br>';
	
}

/*** check the form token is valid ***/
/*
if(session_status() == PHP_SESSION_NONE AND $_SERVER["REQUEST_METHOD"]=="POST" AND $_POST['form_token'] != $_SESSION['form_token'])
{
	$error="err";
    echo $message = 'Invalid form submission'. '</br>';
}
*/
/*** check the username is the correct length ***/
if (!isset($_SESSION['count']) AND $_SERVER["REQUEST_METHOD"]=="POST" AND strlen( $_POST['username']) > 20 || strlen($_POST['username']) < 4)
{
	$error="err";
    echo $message = 'Incorrect Length for Username'. '</br>';
}
/*** check the password is the correct length ***/
if (!isset($_SESSION['count']) AND $_SERVER["REQUEST_METHOD"]=="POST" AND strlen( $_POST['password']) > 20 || strlen($_POST['password']) < 4)
{
	$error="err";
    echo $message = 'Incorrect Length for Password'. '</br>';
}
/*** check the username has only alpha numeric characters ***/
if (!isset($_SESSION['count']) AND $_SERVER["REQUEST_METHOD"]=="POST" AND ctype_alnum($_POST['username']) != true)
{
	$error="err";
    /*** if there is no match ***/
    echo $message = "Username must be alpha numeric". '</br>';
}
/*** check the password has only alpha numeric characters ***/
if (!isset($_SESSION['count']) AND $_SERVER["REQUEST_METHOD"]=="POST" AND ctype_alnum($_POST['password']) != true)
{
	$error="err";
        /*** if there is no match ***/
        echo $message = "Password must be alpha numeric". '</br>';
}
/*** check the valid entered birthday (must be in format dd.mm.yyyy)***/
if(!isset($_SESSION['count']) AND $_SERVER["REQUEST_METHOD"]=="POST" AND calculateYearsOld()>80){
	$error="err";
	echo "Too old". '</br>';
}

/*** check the age must be more than 5 years and less than 80 years ***/
if(!isset($_SESSION['count']) AND $_SERVER["REQUEST_METHOD"]=="POST" AND calculateYearsOld()<5){
	$error="err";
	echo "Too young". '</br>';
}
if(!isset($_SESSION['count']) AND $_SERVER["REQUEST_METHOD"]=="POST" AND empty($error))
{
    /*** if we are here the data is valid and we can insert it into database ***/
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

    /*** now we can encrypt the password ***/
    $password = sha1( $password );
    
    /*** connect to database ***/
    /*** mysql hostname ***/
    $mysql_hostname = 'localhost';

    /*** mysql username ***/
    $mysql_username = 'mysql_username';

    /*** mysql password ***/
    $mysql_password = 'mysql_password';

    /*** database name ***/
    $mysql_dbname = 'phpro_auth';

    try
    {
        
        /***
		$dbh = new PDO("mysql:host=DB_HOST;dbname=DB_NAME", DB_LOGIN, DB_PASSWORD);
		$message = a message saying we have connected 
		***/
		global $link;
		

        /*** set the error mode to exceptions 
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		***/
		$sql = "INSERT INTO users (username, password ) VALUES (?,?)";
		
        /*** prepare the insert 
		$stmt = $dbh->prepare("INSERT INTO users (username, password ) VALUES (:username, :password)");
		***/
        

        /*** bind the parameters 
		   $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR, 40);
		***/
     
		
		

        /*** execute the prepared statement 
		 $stmt->execute();
		***/
       
		if (!$stmt = mysqli_prepare($link, $sql))
		return false;
	mysqli_stmt_bind_param($stmt, "ss", $username, $password);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_close($stmt);

        /*** unset the form token session variable
		unset( $_SESSION['form_token'] );
		***/
        
		// Все ок, то стартуем сессию
			session_start();
			$_SESSION['count'] = 0;
		
        /*** if all is done, say thanks ***/
        $message = 'New user added';
    }
    catch(Exception $e)
    {
        /*** check if the username already exists ***/
        if( $e->getCode() == 23000)
        {
            $message = 'Username already exists';
        }
        else
        {
            /*** if we are here, something has gone wrong with the database ***/
            $message = 'We are unable to process your request. Please try again later"';
        }
    }
}
?>

<html>
<head>

<meta http-equiv="Content-type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>PHPRO Login</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script type="text/javascript" src="js/drop.js"></script>
	<script src="js/common.js" > </script>
<script type="text/javascript">
    function submitForm(action)
    {
        document.getElementById('registration').action = action;
        document.getElementById('registration').submit();
    }
</script>
</head>

<body>
<h2>Add user</h2>
<form id="registration" action="basic-auth.php" method="post">
<fieldset>
<?php   if (!isset($_SESSION['username'])) {
  ?>
<p>
<label for="username">Username</label>
<input type="text" id="username" name="username" value="" maxlength="20" />
</p>
<p>
<label for="phpro_password">Password</label>
<input type="text" id="password" name="password" value="" maxlength="20" />
</p>
<p>
<label for="birthday">Birthday</label>
<input type="text" id="birthday" name="birthday" value="" maxlength="20" />
</p>
<p>
<input type="hidden" name="form_token" value="<?php echo $form_token; ?>" />
<input type="submit" value="&rarr; Register" />

</p>
<?php }else {
	
?>
<p style="font-size: 60px"> <?php echo $_SESSION['username'];?>
</p>
<p>

 <input name="logOut" type="button" onclick="submitForm('log_out.php')" value="Log out" />
  <input name="increment" type="submit" onclick="<?php  $_SESSION['count']++;?>" value="+1" />

</p>
<?php }?>


</fieldset>
</form>
<a href="login.php">Login</a>
</body>
</html>