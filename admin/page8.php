<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
				$query = 'SELECT C.*,CL.category_name FROM hetrotec_exams.category C INNER JOIN hetrotec_exams.category_list CL ON CL.id = C.category_id ORDER BY id DESC';
				$ptmt = $db->prepare($query);
				$ptmt->execute();
				$ptmt->setFetchMode(PDO::FETCH_ASSOC);
				$count = 1;
			
				echo '<div class="container table-responsive">
						<table id ="category_entry" class="table table-bordered">
							<thead>
								<tr class="info">
									<th>#</th>
									<th>Paper Title</th>
									<th>Paper Category</th>
									<th>Total Questions</th>
									<th>Paper Duration(in Min.)</th>
									<th>Status</th>
									<th>Edit Paper</th>
									<th>View Paper</th>
								</tr>
							</thead>';
								while($r = $ptmt->fetch())
								{
									$title = $r['title'];
									$category = $r['category_name'];
									$questions = $r['questions'];
									$time = $r['time']/60;
									$id =  $r['id'];
									if($r['is_active'])
									{
										$status = "<input type=button class='btn btn-danger btn-block' onClick=deactivatePaper(this,$id);  value=deactivate >";
									}
									else
									{
										$status = "<input type=button class='btn btn-primary btn-block' onClick=activatePaper(this,$id);  value=activate >";
									}	
									echo '<tbody><tr>
									<th>'.$count.'</th><th>'.$title.'</th><th>'.$category.'</th><th>'.$questions.'</th><th>'.$time.'</th><th>'.$status.'</th><th><a href=javascript:void(0); onClick=editPaper('.$id.'); title="edit paper">edit</a></th>
									<th><a href=javascript:void(0); onClick=viewPaper('.$id.'); title="view paper">view</a></th>
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