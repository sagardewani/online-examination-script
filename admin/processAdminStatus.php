<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header('content-Type:application/json', true);
	
	if(isset($_POST['status']))
	{
		$data = $_POST['status'];
		$aID = $data['user_id'];
		$status = $data['a_status'];
		$response = 0;
		$query = 'SELECT is_blocked FROM hetrotec_exams.admins WHERE id=:a';
		$stmt = $db->prepare($query);
		$stmt->execute(array(':a'=>$aID));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$error[] = 0;
		if($row['is_blocked'])
		{
			$error[] = 'User is already blocked !.';
		}
		$query = 'UPDATE hetrotec_exams.admins SET is_blocked=:a WHERE id=:b';
		try{
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a'=>$status,':b'=>$aID));
			$response = 1;
		}
		catch(PDOException $e)
		{
			$error[] = $e->getMessage();
		}
		echo json_encode(array("response"=>$response,$error));
	}
?>