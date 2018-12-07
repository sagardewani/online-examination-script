<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{	
				$query = 'SELECT * FROM hetrotec_exams.users ORDER BY created DESC';
				$ptmt = $db->prepare($query);
				$ptmt->execute();
				$ptmt->setFetchMode(PDO::FETCH_ASSOC);
				$count = 1;
				
				echo '<div class="container table-responsive">
							<table id ="user_entry" class="table table-bordered">
								<thead>
									<tr class="info">
										<th>#</th>
										<th>Username</th>
										<th>Email</th>
										<th>Contact</th>
										<th>Password</th>
										<th>Date Registered</th>
										<th>DOB</th>
										<th>Status</th>
									</tr>
								</thead>';
									while($r = $ptmt->fetch())
									{
										$dtf = new DateTime($r['Created']);
										$date = $dtf->format('Y-m-d');
										$username = $r['Username'];
										if($r['is_active'])
										{
											$status = "<button type=button class='btn btn-danger btn-block' onClick=deactivateUser(this,'".$username."'); >deactivate</button>";
										}
										else
										{
											$status = "<button type=button class='btn btn-primary btn-block' onClick=activateUser(this,'".$username."'); >activate</button>";
										}
										echo '<tbody><tr>
										<th>'.$count.'</th><th>'.$r["Username"].'</th><th>'.$r["Email"].'</th><th>'.$r["Contact"].'</th><th>'.$r["Password"].'</th><th>'.$date.'</th><th>'.$r["DOB"].'</th>
										<th>'.$status.'</th>
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