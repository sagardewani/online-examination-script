<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header('content-Type:application/json', true);
	
	if(isset($_POST['user']) && $user->is_logged_in())
	{
		$data = $_POST['user'];
		$username = $data['user'];
		$password = $data['pass'];
		$response = 0;
		$error[] = "none";
		if($user->verify_user_access($username,$password))
		{
			$response = 1;
		}
		else
		{
			$response = -1;
		}	
		echo json_encode(array("response" => $response,$error));
	}
	exit;
?>	