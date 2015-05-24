<?php
require "../inc/lib.inc.php";
require "../inc/db.inc.php";
session_start(); //��������� ������

/** 
 * ����� ��� �����������
 * @author yk
 */ 
class AuthClass {
    private $username = ""; //������������� �����
    private $password = ""; //������������� ������

    /**
     * ���������, ����������� ������������ ��� ���
     * ���������� true ���� �����������, ����� false
     * @return boolean 
     */
    public function isAuth() {
        if (isset($_SESSION["username"])) { //���� ������ ����������
            return $_SESSION["username"]; //���������� �������� ���������� ������ is_auth (������ true ���� �����������, false ���� �� �����������)
        }
        else return false; //������������ �� �����������, �.�. ���������� is_auth �� �������
    }
   
    /**
     * ����������� ������������
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
     * ����� ���������� ����� ��������������� ������������ 
     */
    public function getLogin() {
        if ($this->isAuth()) { //���� ������������ �����������
            return $_SESSION["login"]; //���������� �����, ������� ������� � ������
        }
    }
     
    public function out() {
        $_SESSION = array(); //������� ������
        session_destroy(); //����������
    }
}




?>