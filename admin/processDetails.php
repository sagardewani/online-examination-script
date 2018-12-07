<?php 
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
header("Content-Type: application/json", true); 
if(isset($_POST['form']))
{
	//convert JSON to php associative
	$data = $_POST['form'];
	$category_name = $data['category'];
	$language = $data['language'];
	$time = $data['time']*60;
	$title = $data['title'];
	$questions = $data['questions'];
	//$set = $data['set'];
	
	$query = 'SELECT id,category_name FROM hetrotec_exams.category_list WHERE category_name=:a';
	$stmt = $db->prepare($query);
	$stmt->execute(array(':a' => $category_name));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	$c_id = $row['id'];
	$url = "#";
	$response = 0;
	
	$query = 'SELECT title FROM hetrotec_exams.category WHERE title=:a';
	$stmt = $db->prepare($query);
	$stmt->execute(array(':a' => $title));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	if(!empty($row['title']))
	{
		$error[] = "The paper with same title in same category already exist.";
	}
	
	if(!isset($error))
	{	
		$query = 'INSERT INTO hetrotec_exams.category (category_id,time,title,questions) VALUES (:a,:b,:c,:d)';
		try{
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a' => $c_id,
			':b'=>$time,
			':c'=>$title,
			':d'=>$questions
			));
			$set = $db->lastInsertId('id');
			$error[] = "<p>Paper Added Successfully!</br>Redirecting Please Do Not Refresh!!!</p>";
			$response = 10;
			$url = "questionlayout.php?c=".$c_id."&lang=".$language."&set=".$set;
		}
		catch(PDOException $e)
		{
			$error[] = $e->getMessage();
			$response = -2;
		}
		echo json_encode(array($error,"response" => $response,"url" => $url));
	}
	else
	{
		echo json_encode(array($error,"response" => $response,"url" => $url));
	}
	
}

exit;
?>