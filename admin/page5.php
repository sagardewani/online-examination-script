<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
				//$query = 'SELECT C.id,CL.category_name FROM hetrotec_exams.category_list CL INNER JOIN hetrotec_exams.category C ON C.category_id = CL.id ORDER BY CL.id ASC';
				$query = 'SELECT CL.id,CL.category_name FROM hetrotec_exams.category_list CL ORDER BY CL.id ASC';
				$stmt=$db->prepare($query);
				$stmt->execute(array());
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				//$option_id = 0;
			
			echo '	<form id="form" class="form-horizontal text-center bg-color-light-grey">
					<legend>ADD USER COURSES</legend>
								   <div class="form-group margin-top-10">
										<label class="col-sm-3 control-label" for="username">Username*</label>
										<div class="col-lg-6 col-md-6 col-sm-9">
											<input id="username" class="form-control" placeholder="username" type="text" required="">
										</div>
								  </div>
									<div class="form-group margin-top-10">
										<label class="col-sm-3 control-label" for="category">Category:</label>
										<div class=" col-lg-6 col-md-6 col-sm-9">
											<select id="category" class ="form-control" form="paper_details" autofocus required>
												<option selected value="0">none</option>';
												while($r = $stmt->fetch())
												{
													$option_id = $r['id'];
													$option_text = $r["category_name"];
													echo '<option value='.$option_id.'>'.$option_text.'</option>';
													
												}
												echo '</select>
										</div>
									</div>
									<div class="form-group margin-top-10">
										<label class="col-sm-3 control-label" for="timing">Slot</label>
										<div class="col-lg-6 col-md-6 col-sm-9">
											<input id="timing" class="form-control" placeholder="timing" type="time" required="">
										</div>
									</div>
									<div class="form-group margin-top-10">
										<label class="col-sm-3 control-label" for="package">Package</label>
										<div class="col-lg-6 col-md-6 col-sm-9">
											<input type="number" id="package" class="form-control" required="">
										</div>
									</div>
									<div class="clearfix"></div>
									</br>
									<div class="form-gruop margin-top-10">
										<div class="col-lg-4 col-md-4 col-sm-10 col-xs-12 col-md-offset-4">
											<button type="button" onClick=addUserCourse(); class="btn btn-primary btn-block">ADD USER COURSE</button>
										</div>
									</div>
	
			</form>';
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