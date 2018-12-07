<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{	
				$response = 0;
				$error[] = null;
				if(isset($_POST['data']))
				{	
					$data = $_POST['data'];
					$question_id = $data['question'];
					$lang = $data['lang'];
					if($lang == 0)
					{
						$lang = 'English';
						$query = "SELECT EQ.*,P.paragraph_text FROM hetrotec_exams.english_questions EQ
								LEFT JOIN hetrotec_exams.paragraph_english P ON P.id=EQ.paragraph_id WHERE EQ.id=:a";
						try{
							$pstmt = $db->prepare($query);
							$pstmt->execute(array(
							':a' => $question_id
							));
							$response =1;
						}
						catch(PDOException $e)
						{
							$error[] = $e->getMessage();
						}
						$r = $pstmt->fetch(PDO::FETCH_ASSOC);
						

					}
					else
					{
						$lang = 'Hindi';
						$query = "SELECT EQ.*,P.paragraph_text FROM hetrotec_exams.hindi_questions EQ
								LEFT JOIN hetrotec_exams.paragraph_hindi P ON P.id=EQ.paragraph_id WHERE EQ.id=:a";
						try{
							$pstmt = $db->prepare($query);
						$pstmt->execute(array(
						':a' => $question_id
						));
						$resposne =1;
						}
						catch(PDOException $e)
						{
							$error = $e->getMessage();
						}
						$r = $pstmt->fetch(PDO::FETCH_ASSOC);
					}
					$directions = $r['question_direction'];
					$paragraph = $r['paragraph_text'];
					$question = $r['question'];
					$type = $r['question_type'];

					$opt_1 = $r['opt_1'];
					$opt_2 = $r['opt_2'];
					$opt_3 = $r['opt_3'];
					$opt_4 = $r['opt_4'];
					$opt_5 = $r['opt_5'];
					$opt_6 = $r['opt_6'];
					$correct = $r['correct_opt'];
					$img = $r['img'];
					$paragraph_id = $r['paragraph_id'];
					$question_num = $r['question_id'];

					$solution = $r['solution'];
					$id =  $r['id'];
					echo json_encode(array("response" => $response,"error"=> $error, "directions"=>$directions,"paragraph"=>$paragraph,"question"=>$question,"opt_1"=>$opt_1,"opt_2"=>$opt_2,"opt_3"=>$opt_3,"opt_4"=>$opt_4,"opt_5"=>$opt_5,"opt_6"=>$opt_6,"solution"=>$solution,));
					}			
			}	
			else
			{
				echo '<h1 style="color:red !important; font-size:3em;">You are blocked. Please contact Server Administarator</h1>';
			}
		}
		else
		{
			header('Location: logout.php');
		}
	}
	else
	{
		header('Location: ../index.php');
	}	
	exit;				