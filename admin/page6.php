<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
				$query = 'SELECT U.Username,Cl.category_name,C.category_id,Co.* FROM hetrotec_exams.course Co 
				INNER JOIN hetrotec_exams.users U ON U.id = Co.users_id 
				INNER JOIN hetrotec_exams.category C ON C.category_id = Co.category_id
				INNER JOIN hetrotec_exams.category_list Cl ON Cl.id = C.category_id ORDER BY Co.id DESC';
				$ptmt = $db->prepare($query);
				$ptmt->execute();
				$ptmt->setFetchMode(PDO::FETCH_ASSOC);
				$count = 1;
				
				echo '<div class="container table-responsive">
							<table id ="course_entry" class="table table-bordered">
								<thead>
									<tr class="info">
										<th>#</th>
										<th>Username</th>
										<th>Category</th>
										<th>Slot</th>
										<th>Package</th>
										<th>Stauts</th>
									</tr>
								</thead>';
									while($r = $ptmt->fetch())
									{
										$username = $r['Username'];
										$category = $r['category_name'];
										$slot = $r['slot'];
										$package = $r['package'];
										$c_id = $r['id'];
										if($r['is_active'])
										{
											$status = "<input type=button class='btn btn-danger btn-block' onClick=deactivateCourse(this,$c_id);  value=deactivate >";
										}
										else
										{
											$status = "<input type=button class='btn btn-primary btn-block' onClick=activateCourse(this,$c_id);  value=activate >";
										}
										echo '<tbody><tr>
										<th>'.$count.'</th><th>'.$username.'</th><th>'.$category.'</th><th>'.$slot.'</th><th>'.$package.'</th><th>'.$status.'</th>
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