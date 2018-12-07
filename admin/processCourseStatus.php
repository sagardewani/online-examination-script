<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header('content-Type:application/json', true);
	
	if(isset($_POST['status']))
	{
		$data = $_POST['status'];
		$course = $data['course'];
		$status = $data['c_status'];
		$response = 0;
		$query = 'SELECT is_active FROM hetrotec_exams.course WHERE id=:a';
		$stmt = $db->prepare($query);
		$stmt->execute(array(':a'=>$course));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$error[] = 0;
		if($row['is_active'])
		{
			$error[] = 'User Course is already activated !.';
		}
		$query = 'UPDATE hetrotec_exams.course SET is_active=:a WHERE id=:b';
		try{
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a'=>$status,':b'=>$course));
			$response = 1;
		}
		catch(PDOException $e)
		{
			$error[] = $e->getMessage();
		}
		echo json_encode(array("response"=>$response,$error));
	}
?>