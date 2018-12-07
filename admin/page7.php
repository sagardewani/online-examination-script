<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
				$query = 'SELECT * FROM hetrotec_exams.admins ORDER BY id DESC';
				$ptmt = $db->prepare($query);
				$ptmt->execute();
				$ptmt->setFetchMode(PDO::FETCH_ASSOC);
				$count = 1;
			
				echo '<div class="container table-responsive">
						<table id ="admin_entry" class="table table-bordered">
							<thead>
								<tr class="info">
									<th>#</th>
									<th>Username</th>
									<th>Firstname</th>
									<th>Lastname</th>
									<th>Email</th>
									<th>Last Login</th>
									<th>Browser Used</th>
									<th>IP</th>
									<th>Status</th>
								</tr>
							</thead>';
								while($r = $ptmt->fetch())
								{
									$username = $r['username'];
									$id = $r['id'];
									$fname = $r['firstname'];
									$lname = $r['lastname'];
									$email = $r['email'];
									$login = $r['last_login'];
									$browser = $r['browser_used'];
									$ip = $r['IP'];
									if($r['is_blocked'])
									{
										$status = "<input type=button class='btn btn-primary btn-block' onClick=unblockAdmin(this,$id);  value=Unblock >";
									}
									else
									{
										$status = "<input type=button class='btn btn-danger btn-block' onClick=blockAdmin(this,$id);  value=Block >";
									}
									echo '<tbody><tr>
									<th>'.$count.'</th><th>'.$username.'</th><th>'.$fname.'</th><th>'.$lname.'</th><th>'.$email.'</th><th>'.$login.'</th><th>'.$browser.'</th>
									<th>'.$ip.'</th><th>'.$status.'</th>
									</tr></tbody>';
									$count = $count+1;
								}
							
				echo '</table></div>';
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
?>	