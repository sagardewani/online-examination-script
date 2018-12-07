<?php 
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
header("Content-Type: application/json", true); 
if(isset($_POST['paper']))
{
	//convert JSON to php associative
	$data = $_POST['paper'];
	$total = $data['total'];
	$marks = $data['marks'];
	$category_id = $data['category'];
	$response = 0;
	$url = "#";
	$error = null;
	$query = "UPDATE hetrotec_exams.category SET questions=:a,marks=marks+:b WHERE id=:c";
	try{
		$stmt=$db->prepare($query);
		$stmt->execute(array(':a'=>$total,':b'=>$marks,':c'=>$category_id));
		$response = 1;
		$url = "mainpanel.php";
	}
	catch(PDOException $e)
	{
		$error[] = $e->getMessage();
	}
	exit(json_encode(array("response"=>$response,"url"=>$url,"error"=>$error)));
}
exit;
?>	