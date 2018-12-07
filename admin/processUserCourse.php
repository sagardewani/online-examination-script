<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header('Content-type:application/json',true);
	if(isset($_POST['course']))
	{
		$data = $_POST['course'];
		$user = $data['user'];
		$category = $data['category'];
		$package = $data['pack'];
		$t_slot = $data['slot'];
		//$t_slot = $data['slot'];
		$slot = date('H:i:s', strtotime($t_slot));
		$response = 0;
		$id = 0;
		$error[] = 0;
		$query = "SELECT id,Username FROM hetrotec_exams.users WHERE Username=:a";
		try
		{
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a' => $user));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$id = $row['id'];
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
			if($id !=0)
			{	
				$query = "SELECT * FROM hetrotec_exams.course WHERE users_id = :a AND category_id=:b";
				try{
					$stmt = $db->prepare($query);
					$stmt->execute(array(':a' => $id,':b' => $category));
					$row = $stmt->fetch(PDO::FETCH_ASSOC);
				}
				catch(PDOException $e)
				{
					$error[] = $e->getMessage();
				}
				if(!empty($row['users_id']) && !empty($row['category_id']))
				{	
					$response = -3;
				}
				else
				{	
					$query = "INSERT INTO hetrotec_exams.course (users_id,category_id,slot,package) VALUES(:a,:b,:c,:d)";
					try{
						$stmt = $db->prepare($query);
						$stmt->execute(array(':a' => $id,':b' => $category,':c' => $slot, ':d' => $package));
						$response = 1;
					}
					catch(PDOException $e)
					{
						$error[] = $e->getMessage();
					}
				}
			}
		}
		echo json_encode(array("id" => $id,"response" => $response,"error" => $error));
	}	
	exit;
?>