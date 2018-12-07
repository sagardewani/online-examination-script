<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	if(isset($_POST['data']))
	{
		$data = $_POST['data'];
		$set = $data['set'];
		$error[] =null;
		$left_relations = 0;
		$paragraph_id = 0;
		$paragraph_text = null;
		$total_questions = 0;
		$response = 0;
		
		$query = "SELECT paragraph_id,rel_number,question_category,P.paragraph_text,P.total FROM hetrotec_exams.english_questions
		INNER JOIN hetrotec_exams.paragraph_english P ON P.id = paragraph_id
		WHERE category_id = :a ORDER BY question_id DESC LIMIT 1 ";	
		try
		{
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a' => $set));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($row['rel_number'] > 1)
			{$left_relations = ($row['rel_number'] - 1); $paragraph_id = $row['paragraph_id'];
			
			$paragraph_text = $row['paragraph_text'];
			$total_questions = $row['total'];}else{$left_relations =0;}
			$question_category = $row['question_category'];
			$response = 1;
		}
		catch(PDOException $e)
		{
			$error[] = $e->getMessage();
		}
		echo json_encode(array("response" => $response,"para_id" => $paragraph_id,"question_category"=>$question_category,"left_relations" => $left_relations,"p_text"=>$paragraph_text,"total"=>$total_questions,"error" => $error));
	}
	exit;
?>	