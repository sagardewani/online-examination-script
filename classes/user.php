<?php
include(dirname(__FILE__).DIRECTORY_SEPARATOR.'password.php');
class User extends Password{

    private $_db;

    function __construct($db){
    	parent::__construct();

    	$this->_db = $db;
    }

	
	private function get_user_hash($username){

		try {
			$stmt = $this->_db->prepare('SELECT * FROM hetrotec_exams.admins WHERE username = :username');
			$stmt->execute(array('username' => $username));

			return $stmt->fetch();

		} catch(PDOException $e) {
		    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
		}
	}
	
	public function verify_user_access($username,$password)
	{
		$row = $this->get_user_hash($username);

		if($this->password_verify($password,$row['password']) == 1)
		{
			return true;
		}
	}
	public function get_user_browser()
	{
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
			$browser = 'Internet explorer';
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
		$browser = 'Internet explorer';
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
		   $browser= 'Mozilla Firefox';
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
		   $browser= 'Google Chrome';
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
		   $browser= "Opera Mini";
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
		   $browser= "Opera";
		elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
		  $browser= "Safari";
		else
		  $browser= "Something else";
		return $browser;
	}
	public function login($username,$password){

		$row = $this->get_user_hash($username);

		if($this->password_verify($password,$row['password']) == 1){

		    $_SESSION['loggedin'] = true;
		    $_SESSION['username'] = $row['username'];
			$_SESSION['firstname'] = $row['firstname'];
			$_SESSION['lastname'] = $row['lastname'];
			$_SESSION['email'] = $row['email'];
		    $_SESSION['adminID'] = $row['id'];
			$_SESSION['blocked'] = $row['is_blocked'];
			$_SESSION['admin'] = $row['is_admin'];
			return true;
		}
	}
	public function ulogin($username,$id,$islogged,$status = false){
		if($status)
		{
			$_SESSION['user'] = $username;
			$_SESSION['uID'] = $id;
			$_SESSION['islogged'] = $islogged;
			$_SESSION['status'] = $status;
		}
		return $status;
	}

	public function logout(){
		session_destroy();
	}
	
	public function is_blocked(){
		if(isset($_SESSION['blocked']) && $_SESSION['blocked'] == true){
			return true;
		}
	}
	
	public function is_admin(){
		if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){
			return true;
		}
	}
	
	public function is_logged_in(){
		if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
			return true;
		}
	}
	
	public function is_user_logged(){
		if(isset($_SESSION['islogged']) && $_SESSION['islogged'] == true){
			return true;
		}
	}



	public function verify_user($id,$ip)
	{
	// If Returned user . update the user record	
			try 
			{	
				$query = "UPDATE hetrotec_exams.admins SET IP=:ip,last_login=now(),browser_used=:browser WHERE id=:id";
				$stmt = $this->_db->prepare($query);
				$stmt->execute(array(
				':ip' => $ip,
				':browser' => $this->get_user_browser(),
				':id' => $id
				));
				$_SESSION['IP'] = $ip;
				return true;
				
			}
			catch(PDOException $e){ echo '<p style="color:red">'.$e->getMessage().'</p>'; }
	}
	

}


?>