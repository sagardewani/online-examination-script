<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header("Content-Type: application/json", true); 
	if(isset($_POST['edit']))
	{
		$data = $_POST['edit'];
		$lang = $data['lang'];
		$question = $data['question'];
		if(lang == "English")
		{	
		$query= 'SELECT * FROM hetrotec_exam.english_questions WHERE id= :a';
		try{
			$stmt = $db->prepare($query);
			$stmt->execute(array((':a' => $question));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$error[] = $e->getMessage();
		}
		}
		
		echo json_encode($error);
	}
	exit;
?>