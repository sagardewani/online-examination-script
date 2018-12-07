<?php
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	header('content-Type:application/json', true);
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{	
	if(isset($_POST['admin_data']))
	{
		$data = $_POST['admin_data'];
		$username = $data['username'];
		$email = $data['email'];
		$f_name = $data['f_name'];
		$l_name = $data['l_name'];
		$password = $data['pass'];
		
		if(strlen($username) < 4){
			$error[] = 'Username is too short. It should be more than 3 characters';
		} else {
			$stmt = $db->prepare('SELECT username FROM hetrotec_exams.admins WHERE username = :username');
			$stmt->execute(array(':username' => $username));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if(!empty($row['username']))
			{
			$error[] = 'Username already exists !.';
			}
		}	
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error[] = 'Please enter a valid email address';
		} else
		{
			$stmt = $db->prepare('SELECT email FROM hetrotec_exams.admins WHERE email = :email');
			$stmt->execute(array(':email' => $email));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if(!empty($row['email']))
			{
			$error[] = 'Email provided is already in use.';
			}

		}
			
		if(!isset($error))
		{
			$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);
			
			try
			{
				$IP = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
				$query = 'INSERT INTO hetrotec_exams.admins (username,firstname,lastname,password,email) VALUES (:a,:b,:c,:d,:e)';
				$stmt = $db->prepare($query);
				$stmt->execute(array(
					':a' => $username,
					':b' => $f_name,
					':c' => $l_name,
					':d' => $hashedpassword,
					':e' => $email,
				));
				$id = $db->lastInsertId('id');
				$error[] = 'Admin has been added successfully.';
			}
			catch(PDOException $e)
			{
				$error[] = $e->getMessage();
			}
		}
		echo json_encode($error);
	}
			}
			else
			{
				echo '<h1 style="color:red !important; font-size:3em;">You are blocked. Please contact Server Administarator</h1>';
			}
			exit;
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

?>