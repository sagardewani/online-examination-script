<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header('content-Type:application/json', true);
	
	if(isset($_POST['status']))
	{
		$data = $_POST['status'];
		$user = $data['username'];
		$status = $data['u_status'];
		$response = 0;
		$query = 'SELECT is_active FROM hetrotec_exams.users WHERE Username=:b';
		$stmt = $db->prepare($query);
		$stmt->execute(array(':b'=>$user));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$error[] = 0;
		if($row['is_active'])
		{
			$error[] = 'User is already activated !.';
		}
		$query = 'UPDATE hetrotec_exams.users SET is_active=:a WHERE Username=:b';
		try{
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a'=>$status,':b'=>$user));
			$response = 1;
		}
		catch(PDOException $e)
		{
			$error[] = $e->getMessage();
		}
		echo json_encode(array("response"=>$response,$error));
	}
?>