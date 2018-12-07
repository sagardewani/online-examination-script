<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header('content-Type:application/json', true);
	if(isset($_POST['login']))
	{
		$data = $_POST['login'];
		$username = $data['user'];
		$pass = $data['pass'];
		$response = 0;
		//$category = 0;
		$error[] = 0;
		$id = 0;
		$status = 0;
		$query = "SELECT id,Username,Password,is_active FROM hetrotec_exams.users WHERE Username=:a";
		$url = "#";
		$msg = null;
		$post = 0;
		try
		{
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a' => $username));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
			$status = $row['is_active'];
			$response = 1;
		}
		catch(PDOException $e)
		{
			$error[] = $e->getMessage();
		}
		if(empty($row['Username']))
		{
			$response = 2;
		}
		else
		{
			if($pass != $row['Password'])
			{
				$response = 3;
			}	
		}
		if($response == 1)
		{
			$url = "user/user_area.php";
			$is_logged = true;
			$user_id = $id;
			if(!$user->ulogin($username,$user_id,$is_logged,$status))
			{
				$msg ="<h1 style='color:RED'>YOUR ACCOUNT IS NOT ACTIVATED.</br>PLEASE CONTACT SITE ADMINISTRATOR.</h1>";
			}
			$msg = "<p style=color:green>Login Successful !!!Please Wait,We're Redirecting You<p>";
				
		}
		echo json_encode(array("response"=>$response,"msg"=>$msg,"url"=>$url));
	}
	exit;
?>	