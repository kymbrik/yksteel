<?php
require "../inc/lib.inc.php";
require "../inc/db.inc.php";
session_start(); //Запускаем сессии

/** 
 * Класс для авторизации
 * @author yk
 */ 
class AuthClass {
    private $username = ""; //Устанавливаем логин
    private $password = ""; //Устанавливаем пароль

    /**
     * Проверяет, авторизован пользователь или нет
     * Возвращает true если авторизован, иначе false
     * @return boolean 
     */
    public function isAuth() {
        if (isset($_SESSION["username"])) { //Если сессия существует
            return $_SESSION["username"]; //Возвращаем значение переменной сессии is_auth (хранит true если авторизован, false если не авторизован)
        }
        else return false; //Пользователь не авторизован, т.к. переменная is_auth не создана
    }
   
    /**
     * Авторизация пользователя
     * @param string $username
     * @param string $password 
     */
    public function auth($username, $password) {
     
		global $link;
		$sql = 'SELECT user_id, username, password FROM users WHERE username = "'. $username .'" AND password="' .sha1($password).'"';
			if(!$result = mysqli_query($link, $sql))
				return false;
		$item = mysqli_fetch_row($result);
		mysqli_free_result($result);
				$user_id = $item[0];
				$username = $item[1];
        /*** check for a result $user_id = $stmt->fetchColumn(); ***/
        /*** if we have no result then fail boat ***/
        if($user_id == false)
        {
               return false;
        }
        /*** if we do have a result, all is well ***/
        else
        {
			return true;
        }


    }
  
    
    
    /**
     * Метод возвращает логин авторизованного пользователя 
     */
    public function getLogin() {
        if ($this->isAuth()) { //Если пользователь авторизован
            return $_SESSION["login"]; //Возвращаем логин, который записан в сессию
        }
    }
     
    public function out() {
        $_SESSION = array(); //Очищаем сессию
        session_destroy(); //Уничтожаем
    }
}




?>