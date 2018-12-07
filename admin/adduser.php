<?php 
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header("Content-Type: application/json", true);
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{	
				if(isset($_POST['user']))
				{
					$data = $_POST['user'];
					$user = $data['name'];
					$pass = $data['password'];
					$email = $data['email'];
					//$t_slot = $data['slot'];
					//$slot = date('H:i:s', strtotime($t_slot));
					$dob = $data['dob'];
					//$package = $data['pack'];
					$contact = $data['contact'];
					//$course = $data['category'];
					//$u_id = -1;
					//$c_id = -1;
					$response = -1;
					if(strlen($user) < 4)
					{
						$error[] = "Username is too short";
					}
					else
					{
						$stmt = $db->prepare('SELECT Username FROM hetrotec_exams.users WHERE Username = :username');
						$stmt->execute(array(':username' => $user));
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						if(!empty($row['Username'])){
						$error[] = 'Username already exists !.';
						}
					}
					if(!filter_var($email, FILTER_VALIDATE_EMAIL))
					{
						$error[] = "Email inserted is not valid";
					}
					else
					{
						$stmt = $db->prepare('SELECT Email FROM hetrotec_exams.users WHERE Email = :email');
						$stmt->execute(array(':email' => $email));
						$row = $stmt->fetch(PDO::FETCH_ASSOC);
						if(!empty($row['Email'])){
						$error[] = 'Email already exists !.';
						}
					}
					if(!isset($error))
					{	
						$query = "INSERT INTO hetrotec_exams.users (Username,Password,Email,Contact,DOB) VALUES (:a,:b,:c,:d,:e)";
						try{
							$stmt = $db->prepare($query);
							$stmt->execute(array(':a' => $user,':b' => $pass,':c' => $email,':d' => $contact, ':e' => $dob));
							$u_id = $db->lastInsertId('id');
							$response = 1;
							$error[] = "Success";
						}
						catch(PDOException $e)
						{
							$error[] = $e->getMessage();
							$response = 0;
						}
					}
					/*if($u_id != -1)
					{	
						$c_query = "INSERT INTO hetrotec_exams.course (users_id,category_id,slot,package) VALUES (:a,:b,:c,:d)";
						try{
						$stmt = $db->prepare($c_query);
						$stmt->execute(array(
							':a' => $u_id,
							':b' => $course,
							':c' => $slot,
							':d' => $package
						));
						$response = 1;
						}
						catch(PDOException $e)
						{
							$error[] = $e->getMessage();
							$response = 8;
						}
					}*/
					echo json_encode(array("response" => $response,$error));
					
				}
				exit;
			}
			else
			{
				echo '<h1 style="color:red !important; font-size:3em;">You are blocked. Please contact Server Administarator</h1>';
			}
		}
		else
		{
			header('Location: user_area.php');
		}
	}
	else
	{
		header('Location: index.php');
	}
	exit;
?>