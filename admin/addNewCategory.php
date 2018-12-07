<?php 
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
header("Content-Type: application/json", true); 
if(isset($_POST['data']))
{
	$data = $_POST['data'];
	$category = $data['category_name'];
	$query = 'INSERT INTO hetrotec_exams.category_list (category_name) VALUES(:a)';
	$response = 0;
	$error[]= null;
	try{
		$stmt = $db->prepare($query);
		$stmt->execute(array(':a' => $category));
		$response = 1;
	}
	catch(PDOException $e)
	{
		$error[] = $e->getMessage();
	}
	echo json_encode(array("response"=> $response,"error"=>$error));
}
exit;
?>	