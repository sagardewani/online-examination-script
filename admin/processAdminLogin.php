<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header('content-Type:application/json', true);
	if(isset($_POST['login']) && !$user->is_logged_in())
	{
		$data = $_POST['login'];
		$username = $data['user'];		
		$password = $data['pass'];
		$ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
		$url="#";
		$response = 0;
		if($user->login($username,$password))
		{
			if($user->verify_user($_SESSION['adminID'],$ip))
			{
				$response = 1;
				$url = "mainpanel.php";
			}	
		}
		else
		{
			$response = -1;
		}
		echo json_encode(array("response"=>$response,"url"=>$url));
	}
	exit;
?>	