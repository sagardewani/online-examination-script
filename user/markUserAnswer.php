<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header("Content-Type: application/json", true); 
	if(isset($_POST['data']))
	{
		$data = $_POST['data'];
		$id = $data['q_id'];
		$course = $data['course'];
		$option_selected = $data['option_selected'];
		$elapsed = $data['elapsed'];
		$lang = $data['lang'];
		$user = $data['user'];
		$response = 0;
		$is_marked = 1;
		$question_number = 0;
		$answered =false;

		
		$is_answered = false;
		if($option_selected != -1)
		{	
			$query ="SELECT Q.correct_opt,Q.id,M.positive,M.negative FROM english_questions Q
				INNER JOIN english_marks M ON M.question_id = Q.id
				WHERE Q.id=:a";
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
			$answer = $row['correct_opt'];
			$positive = $row['positive'];
			$negative = -($row['negative']);
		}
		$obtained = 0;
		$is_answered = 0;
		$is_correct = 0;
		$error = null;
		if($option_selected != -1)
		{
			switch($answer)
			{
				case 1: /*$answer = $row['opt_1']*/ if($answer == $option_selected){$obtained = $positive; $is_correct = 1;} else {$obtained = $negative;} $is_answered = 1;  break;
				case 2: /*$answer = $row['opt_2']*/ if($answer == $option_selected){$obtained = $positive; $is_correct = 1;} else {$obtained = $negative;} $is_answered = 1;  break;
				case 3: /*$answer = $row['opt_3']*/ if($answer == $option_selected){$obtained = $positive; $is_correct = 1;} else {$obtained = $negative;} $is_answered = 1;  break;
				case 4: /*$answer = $row['opt_4']*/ if($answer == $option_selected){$obtained = $positive; $is_correct = 1;} else {$obtained = $negative;} $is_answered = 1;  break;
				case 5: /*$answer = $row['opt_5']*/ if($answer == $option_selected){$obtained = $positive; $is_correct = 1;} else {$obtained = $negative;} $is_answered = 1; break;
				case 6: /*$answer = $row['opt_6']*/ if($answer == $option_selected){$obtained = $positive; $is_correct = 1;} else {$obtained = $negative;} $is_answered = 1; break;
				default: $answer = -1;
			}
		}
		else if( $option_selected == -1)
		{
			$option_selected = 0;
		}		
		
		/*$query = "SELECT UA.*,C.* FROM user_answeres_english UA
				INNER JOIN course C ON C.id = UA.category_id  WHERE question_id=:a";*/
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
			$query = "UPDATE user_answers_english SET obtained=:b, opt_select=:d, elapsed=elapsed+:e, is_answered=:f,is_correct=:g,is_marked=:h WHERE question_id=:a  AND users_id=:i";
			try{
				$stmt = $db->prepare($query);
				$stmt->execute(array(':a' => $id,':b'=>$obtained,':d'=>$option_selected,':e'=>$elapsed,':f'=>$is_answered,':g'=>$is_correct,':h'=>$is_marked,':i'=>$user));
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
			$query = "INSERT INTO user_answers_english (question_id,category_id,obtained,opt_select,elapsed,is_answered,is_correct,is_marked,users_id) VALUES(:a,:b,:c,:d,:e,:f,:g,:h,:i)";
			try{
				$stmt = $db->prepare($query);
				$stmt->execute(array(':a' => $id,':b'=>$course,':c'=>$obtained,':d'=>$option_selected,':e'=>$elapsed,':f'=>$is_answered,':g'=>$is_correct,':h'=>$is_marked,':i'=>$user));
				$response = 1;
			}	
			catch(PDOException $e)
			{
				$error[] = $e->getMessage();
				$response = 1;
			}			
		}
		//if question is attempted then select the time elapsed
		
		echo json_encode(array("response"=>$response,"error"=>$error));		
		
	}
	exit;