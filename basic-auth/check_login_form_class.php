<?php
	/** 
 * Класс для проверки полей авторизации
 * @author yk
 */ 
class check_login_form_class {
	private $error_messages = array();
	
	
	/**
     * Проверка имени пользователя 
     * @param string $username
     * return array of errors if not, returns blank array
     */
	public function check_username($username){
		if (strlen($username) > 20 || strlen($username) < 4)
			{
				array_push($this->error_messages,'Incorrect Length for Username');
			}
		if(ctype_alnum($username) != true)
			{
				array_push($this->error_messages,'Username must be alpha numeric');
			}
			return $error_messages;
	}
	
	public function check_password($password){
		if (strlen($password) > 20 || strlen($password) < 4)
			{
				array_push($this->error_messages,'Incorrect Length for Password');
			}
		if(ctype_alnum($password) != true)
			{
				array_push($this->error_messages,'Password must be alpha numeric');
			}
			return $error_messages;
	}
	
	public function get_error_messages(){
		return $this->error_messages;
	
	}

}
?>