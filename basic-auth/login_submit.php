<?php

require "auth_class.php";
require "check_login_form_class.php";


	

		$check_fields = new check_login_form_class;
	$check_fields->check_username($_POST['username']);
	$check_fields->check_password($_POST['password']);
	setcookie('cookie', serialize($check_fields->get_error_messages()), time()+3600);



if(isset( $_POST['username'], $_POST['password']) AND count($check_fields->get_error_messages())==0){
		$auth = new AuthClass();
			if($auth->auth($_POST['username'], $_POST['password'])==true){
				session_start();
				$_SESSION['username'] = $_POST['username'];
			}
}

header("location:login.php");
	exit;

?>

