<?php
require "../inc/lib.inc.php";
require "../inc/db.inc.php";
/*** begin our session ***/
session_start();
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
if(!isset( $_POST['username'], $_POST['password'], $_POST['birthday'], $_POST['form_token']))
{
	$error="err";
    echo 'Please enter a valid username and password'. '</br>';
	
}
/*** check the form token is valid ***/
if( $_POST['form_token'] != $_SESSION['form_token'])
{
	$error="err";
    echo $message = 'Invalid form submission'. '</br>';
}
/*** check the username is the correct length ***/
if (strlen( $_POST['username']) > 20 || strlen($_POST['username']) < 4)
{
	$error="err";
    echo $message = 'Incorrect Length for Username'. '</br>';
}
/*** check the password is the correct length ***/
if (strlen( $_POST['password']) > 20 || strlen($_POST['password']) < 4)
{
	$error="err";
    echo $message = 'Incorrect Length for Password'. '</br>';
}
/*** check the username has only alpha numeric characters ***/
if (ctype_alnum($_POST['username']) != true)
{
	$error="err";
    /*** if there is no match ***/
    echo $message = "Username must be alpha numeric". '</br>';
}
/*** check the password has only alpha numeric characters ***/
if (ctype_alnum($_POST['password']) != true)
{
	$error="err";
        /*** if there is no match ***/
        echo $message = "Password must be alpha numeric". '</br>';
}
/*** check the valid entered birthday (must be in format dd.mm.yyyy)***/
if(calculateYearsOld()>80){
	$error="err";
	echo "Too old". '</br>';
}

/*** check the age must be more than 5 years and less than 80 years ***/
if(calculateYearsOld()<5){
	$error="err";
	echo "Too young". '</br>';
}
if(empty($error))
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
<title>PHPRO Login</title>
</head>
<body>
<p><?php 


 ?>
</p>

<a href="basic-auth.php">Register Form</a>

</body>
</html>