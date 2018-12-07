<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header("Content-Type: application/json", true); 
	if(isset($_POST['paper']))
	{
		$data = $_POST['paper'];
		$question_id = $data['question'];
		$question = $data['question_text'];
		$negative = $data['negative'];
		$positive = $data['positive'];
		$opt_1 = $data['option_1'];
		$opt_2 = $data['option_2'];
		$opt_3 = $data['option_3'];
		$opt_4 = $data['option_4'];
		$opt_flag = $data['opt_flag'];
		if($opt_flag >= 1)
		$opt_5 = $data['option_5'];
		if($opt_flag == 2)
		$opt_6 = $data['option_6'];
		$lang = $data['language'];
		$set = $data['set'];
		$img = $data['img'];
		$solution = $data['solution'];
		//$category = $data['paper_category'];
		$answer = $data['answer'];
		$question_type = $data['type'];//Like paragraph
		$category_type = strtoupper($data['category']); //Like Reasoning
		$direction = $data['directions'];
		$para_count = $data['para_count'];//represent there is no paragraphical question(initially, we assume it , maybe you could find better approach to do this.)
		$p_response = 0;
		//$rel_number = $data[''];
		$error[] = null;
		if($question_type >= 2)
		{
			$paragraph_text = $data['paragraph'];
			$paragraph_questions = $data['paragraph_questions'];
			$paragraph_id = $data['paragraph_id'];
		}
		else
		{
			$paragraph_id = 0;
		}
		$response = 1;
		$p_id = 0;
		
		if($lang == "English")
		{
			$lang = 0;
			if($question_type == 1)// Question type - normal
			{
				if($opt_flag == 1) //Option - 5
				{
					$query = 'INSERT INTO hetrotec_exams.english_questions (question_id,category_id,question,question_type,
					opt_1,opt_2,opt_3,opt_4,opt_5,question_category,correct_opt,question_direction,img,solution) VALUES (:a,:b,:c,:d,:e,:f,:g,:h,:i,:j,:k,:l,:m,:n)';
					try
					{
						$stmt = $db->prepare($query);
						$stmt->execute(array(
						':a' => $question_id,
						':b' => $set,
						':c' => $question,
						':d' => $question_type,
						':e' => $opt_1,
						':f' => $opt_2,
						':g' => $opt_3,
						':h' => $opt_4,
						':i' => $opt_5,
						':j' => $category_type,
						':k' => $answer,
						':l' => $direction,
						':m' => $img,
						':n' => $solution
						));
						$id = $db->lastInsertId('id');
						$response = 11;
					}
					catch(PDOException $e)
					{
						$error[] = $e->getMessage();
						$response = -3;
					}
					if($response == 11)
					{
						$query = 'INSERT INTO hetrotec_exams.english_marks (question_id,positive,negative) VALUES (:a,:b,:c)';
						try
						{
							$stmt = $db->prepare($query);
							$stmt->execute(array(
								':a' => $id,
								':b' => $positive,
								':c' => $negative
							));
							$response = 11;
						}
						catch(PDOException $e)
						{
							$error[] = $e->getMessage();
							$response = -4;
						}
					}
					
				}	
				else if($opt_flag == 2)//Option - 6
				{
					$query = 'INSERT INTO hetrotec_exams.english_questions (question_id,category_id,question,question_type,
					opt_1,opt_2,opt_3,opt_4,opt_5,opt_6,question_category,correct_opt,question_direction,img,solution) VALUES(:a,:b,:c,:d,:e,:f,:g,:h,:i,:j,:k,:l,:m,:n,:o)';
					try
					{
						$stmt = $db->prepare($query);
						$stmt->execute(array(
						':a' => $question_id,
						':b' => $set,
						':c' => $question,
						':d' => $question_type,
						':e' => $opt_1,
						':f' => $opt_2,
						':g' => $opt_3,
						':h' => $opt_4,
						':i' => $opt_5,
						':j' => $opt_6,
						':k' => $category_type,
						':l' => $answer,
						':m' => $direction,
						':n' => $img,
						':o' => $solution
						));
						$id = $db->lastInsertId('id');
						$response = 11;
					}
					catch(PDOException $e)
					{
						$error[] = $e->getMessage();
						$response = -3;
					}
					if($response == 11)
					{
						$query = 'INSERT INTO hetrotec_exams.english_marks (question_id,positive,negative) VALUES (:a,:b,:c)';
						try
						{
							$stmt = $db->prepare($query);
							$stmt->execute(array(
								':a' => $id,
								':b' => $positive,
								':c' => $negative
							));
							$response = 11;
						}
						catch(PDOException $e)
						{
							$error[] = $e->getMessage();
							$response = -4;
						}
					}
				}
				else // Option -4
				{
					$query = 'INSERT INTO hetrotec_exams.english_questions (question_id,category_id,question,question_type,
					opt_1,opt_2,opt_3,opt_4,question_category,correct_opt,question_direction,img,solution) VALUES(:a,:b,:c,:d,:e,:f,:g,:h,:i,:j,:k,:l,:m)';
					try
					{
						$stmt = $db->prepare($query);
						$stmt->execute(array(
						':a' => $question_id,
						':b' => $set,
						':c' => $question,
						':d' => $question_type,
						':e' => $opt_1,
						':f' => $opt_2,
						':g' => $opt_3,
						':h' => $opt_4,
						':i' => $category_type,
						':j' => $answer,
						':k' => $direction,
						':l' => $img,
						':m' => $solution
						));
						$id = $db->lastInsertId('id');
						$response = 11;
					}
					catch(PDOException $e)
					{
						$error[] = $e->getMessage();
						$response = -3;
					}
					if($response == 11)
					{
						$query = 'INSERT INTO hetrotec_exams.english_marks (question_id,positive,negative) VALUES (:a,:b,:c)';
						try
						{
							$stmt = $db->prepare($query);
							$stmt->execute(array(
								':a' => $id,
								':b' => $positive,
								':c' => $negative
							));
							$response = 11;
						}
						catch(PDOException $e)
						{
							$error[] = $e->getMessage();
							$response = -4;
						}
					}	
				}	

			}
			else if($question_type >= 2) //Paragraph or Others
			{
				if($paragraph_id == 0)//Initally paragraph insert in table
				{	
					$query = 'INSERT INTO hetrotec_exams.paragraph_english (paragraph_text,total) VALUES (:a,:b)';
					try{
						$stmt = $db->prepare($query);
						$stmt->execute(array(
							':a' => $paragraph_text,
							':b' => $paragraph_questions
						));
						$paragraph_id = $db->lastInsertId('id'); //updating paragraph_id to indicate paragraph is inserted
						$para_count = $paragraph_questions; //updating number of paragraph questions
						$p_response = 9; //this response indicate that paragraph is inserted successfully!!!
						$rel_number = $para_count; 
					}
					catch(PDOException $e)
					{
						$error[] = $e->getMessage();
						$response = -5;
					}
				}
				//this is a bit complicated, above we are just pushing the paragraph first into database,
				//now the logic is if this is the paragraphical question then always the first part is executed first
				//then we would move to next conditions, here check if options are 5 and this is next turn or further turn of inserting the paragraphical questions.
				//$p_response = 9 while paragraph will be inserted & paragraph_id is not 0 while last paragraph id is fetched from the database
				if($opt_flag == 1 && ($p_response == 9 || $paragraph_id != 0)) //option -5
				{
					$query = 'INSERT INTO hetrotec_exams.english_questions (question_id,category_id,question,question_type,
					opt_1,opt_2,opt_3,opt_4,opt_5,paragraph_id,question_category,correct_opt,question_direction,img,solution,rel_number) VALUES (:a,:b,:c,:d,:e,:f,:g,:h,:i,:j,:k,:l,:m,:n,:o,:p)';
					try
					{
						$stmt = $db->prepare($query);
						$stmt->execute(array(
						':a' => $question_id,
						':b' => $set,
						':c' => $question,
						':d' => $question_type,
						':e' => $opt_1,
						':f' => $opt_2,
						':g' => $opt_3,
						':h' => $opt_4,
						':i' => $opt_5,
						':j' => $paragraph_id,
						':k' => $category_type,
						':l' => $answer,
						':m' => $direction,
						':n' => $img,
						':o' => $solution,
						':p' => $para_count
						));
						$id = $db->lastInsertId('id');
						$p_response = 9;
						$response = 11;
					}
					catch(PDOException $e)
					{
						$error[] = $e->getMessage();
						$response = -3;
					}
					if($response == 11)
					{
						$query = 'INSERT INTO hetrotec_exams.english_marks (question_id,positive,negative) VALUES (:a,:b,:c)';
						try
						{
							$stmt = $db->prepare($query);
							$stmt->execute(array(
								':a' => $id,
								':b' => $positive,
								':c' => $negative
							));
							$response = 11;
						}
						catch(PDOException $e)
						{
							$error[] = $e->getMessage();
							$response = -4;
						}
					}
					
				}
				else if($opt_flag == 2 && ($p_response == 9 || $paragraph_id != 0)) //option -6
				{
					$query = 'INSERT INTO hetrotec_exams.english_questions (question_id,category_id,question,question_type,
					opt_1,opt_2,opt_3,opt_4,opt_5,opt_6,paragraph_id,question_category,correct_opt,question_direction,img,solution,rel_number) VALUES (:a,:b,:c,:d,:e,:f,:g,:h,:i,:j,:k,:l,:m,:n,:o,:p,:q)';
					try
					{
						$stmt = $db->prepare($query);
						$stmt->execute(array(
						':a' => $question_id,
						':b' => $set,
						':c' => $question,
						':d' => $question_type,
						':e' => $opt_1,
						':f' => $opt_2,
						':g' => $opt_3,
						':h' => $opt_4,
						':i' => $opt_5,
						':j' => $opt_6,
						':k' => $paragraph_id,
						':l' => $category_type,
						':m' => $answer,
						':n' => $direction,
						':o' => $img,
						':p' => $solution,
						':q' => $para_count
						));
						$id = $db->lastInsertId('id');
						$p_response = 9;
						$response = 11;
					}
					catch(PDOException $e)
					{
						$error[] = $e->getMessage();
						$response = -3;
					}
					if($response == 11)
					{
						$query = 'INSERT INTO hetrotec_exams.english_marks (question_id,positive,negative) VALUES (:a,:b,:c)';
						try
						{
							$stmt = $db->prepare($query);
							$stmt->execute(array(
								':a' => $id,
								':b' => $positive,
								':c' => $negative
							));
							$response = 11;
						}
						catch(PDOException $e)
						{
							$error[] = $e->getMessage();
							$response = -4;
						}
					}
					
				}
				else if($opt_flag == 0 && ($p_response == 9 || $paragraph_id != 0)) //option -4
				{
					$query = 'INSERT INTO hetrotec_exams.english_questions (question_id,category_id,question,question_type,
					opt_1,opt_2,opt_3,opt_4,paragraph_id,question_category,correct_opt,question_direction,img,solution,rel_number) VALUES (:a,:b,:c,:d,:e,:f,:g,:h,:i,:j,:k,:l,:m,:n,:o)';
					try
					{
						$stmt = $db->prepare($query);
						$stmt->execute(array(
						':a' => $question_id,
						':b' => $set,
						':c' => $question,
						':d' => $question_type,
						':e' => $opt_1,
						':f' => $opt_2,
						':g' => $opt_3,
						':h' => $opt_4,
						':i' => $paragraph_id,
						':j' => $category_type,
						':k' => $answer,
						':l' => $direction,
						':m' => $img,
						':n' => $solution,
						':o' => $para_count
						));
						$id = $db->lastInsertId('id');
						$p_response = 9;
						$response = 11;
					}
					catch(PDOException $e)
					{
						$error[] = $e->getMessage();
						$response = -3;
					}
					if($response == 11)
					{
						$query = 'INSERT INTO hetrotec_exams.english_marks (question_id,positive,negative) VALUES (:a,:b,:c)';
						try
						{
							$stmt = $db->prepare($query);
							$stmt->execute(array(
								':a' => $id,
								':b' => $positive,
								':c' => $negative
							));
							$response = 11;
						}
						catch(PDOException $e)
						{
							$error[] = $e->getMessage();
							$response = -4;
						}
					}
					
				}			
			}	
		}
		echo json_encode(array($lang,"response" => $response,"para_id" => $paragraph_id,"p_response" => $p_response,"para_count" => $para_count,"error" => $error));
	}
	exit;
?>