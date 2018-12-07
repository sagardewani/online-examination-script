<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header("Content-Type: application/json", true); 
	if(isset($_POST['submit']))
	{
		
		
		$data = $_POST['submit'];
		$user = $data['user'];
		$category = $data['category'];
		$is_attempted = $data['attempted'];
		//$time_stamp = $data['timestamp'];
		if(isset($data['time'])) $time = $data['time'];
		$query = "SELECT id FROM hetrotec_exams.user_paper WHERE users_id =:a AND category_id=:b";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':a' => $user,':b'=>$category));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$response = 0;
		$error = null;
		if(!empty($row['id']))
		{
			if(isset($data['finish']))
			{
				$finish = $data['finish'];
				try{
					$query = "UPDATE hetrotec_exams.user_paper SET is_attempted=:c,finish=:d,time_taken=:e WHERE users_id =:a AND category_id=:b";
					$stmt = $db->prepare($query);
					$stmt->execute(array(':a' => $user,':b'=>$category,':c'=>$is_attempted,':d'=>$finish,':e'=>$time));
					$response = 1;
				}
				catch(PDOException $e)
				{
					$error[] = $e->getMessage();
					$response = -1;
				}
			}
			else
			{
				try{
					$query = "UPDATE hetrotec_exams.user_paper SET is_attempted=:c WHERE users_id =:a AND category_id=:b";
					$stmt = $db->prepare($query);
					$stmt->execute(array(':a' => $user,':b'=>$category,':c'=>$is_attempted));
					$response = 1;
				}
				catch(PDOException $e)
				{
					$error[] = $e->getMessage();
					$response = -1;
				}				
			}			
		}	
		else
		{
			if(isset($data['finish']))
			{
				try{
					$finish = $data['finish'];
					$query = "INSERT INTO hetrotec_exams.user_paper (users_id,category_id,is_attempted,finish,time_taken) VALUES(:a,:b,:c,:d,:e)";
					$stmt = $db->prepare($query);
					$stmt->execute(array(':a' => $user,':b'=>$category,':c'=>$is_attempted,':d'=>$finish,':e'=>$time));
					$response = 1;
				}
				catch(PDOException $e)
				{
					$error[] = $e->getMessage();
					$response = -1;
				}				
			}
			else
			{
				try{
					$query = "INSERT INTO hetrotec_exams.user_paper (users_id,category_id,is_attempted) VALUES(:a,:b,:c)";
					$stmt = $db->prepare($query);
					$stmt->execute(array(':a' => $user,':b'=>$category,':c'=>$is_attempted));
					$response = 1;					
				}
				catch(PDOException $e)
				{
					$error[] = $e->getMessage();
					$response = -1;
				}				
			}
		}	
		echo json_encode(array("response" =>$response,"error"=>$error,"attempted" => $is_attempted));
	
	}	
	exit;