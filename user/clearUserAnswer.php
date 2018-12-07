<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header("Content-Type: application/json", true); 
	if(isset($_POST['data']))
	{
		$data = $_POST['data'];
		$id = $data['q_id'];
		$course = $data['course'];
		$elapsed = $data['elapsed'];
		$lang = $data['lang'];
		$response = 0;
		
		$obtained = 0;
		$option_selected = 0;
		$is_answered = 0;
		$is_correct = 0;
		$error = null;	
		
		$query = "SELECT id,question_id FROM user_answers_english WHERE question_id=:a";
		try{
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a' => $id));
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
			$query = "UPDATE hetrotec_exams.user_answers_english SET obtained=:b,opt_select=:d,elapsed=elapsed+:e,is_answered=:f,is_correct=:g,is_marked=:h WHERE question_id=:a";
			try{
				$pstmt = $db->prepare($query);
				$pstmt->execute(array(
					':a' => $id,
					':b'=>$obtained,
					':d'=>$option_selected,
					':e'=>$elapsed,
					':f'=>$is_answered,
					':g'=>$is_correct,
					':h'=>false
				));
				$response = 1;
			}
			catch(PDOException $e)
			{
				$error[] = $e->getMessage();
				$response = -1;
			}			
		}
		echo json_encode(array("response"=>$response,"error"=> $error));
	}
	exit;		