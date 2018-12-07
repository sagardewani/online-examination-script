<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header("Content-Type: application/json", true); 
	if(isset($_POST['data']))
	{
		$data = $_POST['data'];
		//$category_wise = $data['category_wise'];
		$id = $data['id'];
		$category = $data['category'];
		//$option_selected = $data['option_selected'];
		$option_selected = 0;
		$elapsed = $data['elapsed'];
		$lang = $data['lang'];
		$user = $data['user'];

		$response = 0;
		$answered =false;
		$error = null;
		

		$obtained = 0;
		$is_answered = 0;
		$is_correct = 0;	
		$query = "SELECT id,question_id FROM user_answers_english WHERE question_id=:a AND users_id=:b";
		try{
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a' => $id,':b'=>$user));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$response = 1;
		}
		catch(PDOException $e)
		{
			$error[] = $e->getMessage();
			$response = -1;
		}

		if(!empty($row['question_id']))
		{
			$query = "UPDATE user_answers_english SET elapsed=elapsed+:e WHERE question_id=:a  AND users_id=:h";
			try{
				$stmt = $db->prepare($query);
				$stmt->execute(array(':a' => $id,':e'=>$elapsed,':h'=>$user));
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
			$query = "INSERT INTO user_answers_english (question_id,category_id,obtained,opt_select,elapsed,is_answered,is_correct,users_id) VALUES(:a,:b,:c,:d,:e,:f,:g,:h)";
			try{
				$stmt = $db->prepare($query);
				$stmt->execute(array(':a' => $id,':b'=>$category,':c'=>$obtained,':d'=>$option_selected,':e'=>$elapsed,':f'=>$is_answered,':g'=>$is_correct,':h'=>$user));
				$response = 1;
			}	
			catch(PDOException $e)
			{
				$error[] = $e->getMessage();
				$response = 1;
			}			
		}
		echo json_encode(array("response"=>$response,"error"=>$error));		
		
	}
	exit;