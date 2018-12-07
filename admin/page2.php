<?php 
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
	$query = 'SELECT distinct(category_name) FROM hetrotec_exams.category_list ORDER BY id ASC';
	$stmt=$db->prepare($query);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$option_id = 0;
	
	echo '	<div class="container">
		<form class="form-horizontal bg-color-light-grey" name="paper_details" id="paper_details">
			<fieldset>
				<div class="form-group text-center">	
					<h3><b>ADD NEW CATEGORY</b></h3>
				</div>	
				<div class="form-control-group margin-top-10">
					<label class="control-label col-lg-3 col-md-3 col-sm-4 col-xs-4" for="category">Category:</label>
					<div class="input-group col-lg-4 col-md-6 col-sm-8 col-xs-8">
						<select id="category" class ="form-control" form="paper_details" autofocus required>
							<option selected value="0">none</option>';
								while($r = $stmt->fetch())
								{
									$option_id = $option_id +1;
									$option_text = $r["category_name"];
									echo '<option value='.$option_id.'>'.$option_text.'</option>';
								}
							echo '</select>
						<span class="input-group-addon" style="cursor:pointer; margin-left:5px;" onClick=addCategory();><i class="fa fa-plus"></i></span>
					</div>
				</div>
				<div class="form-group hide margin-top-10" id="new_category_box">
					<label class="control-label col-lg-3 col-md-3 col-sm-4 col-xs-4" for="duration">New Category:</label>
					<div class="form-group col-lg-5 col-md-5 col-sm-6 col-xs-6">
						<textarea name="new_category_name" id="new_category_name" placeholder="write new category name here..." rows="3" cols="50" class="form-control"></textarea>
						<span class="help-block margin-left">
							<a href=javascript:void(0); style="color:green" title="add" onClick=addBtn()>
								<i class="fa fa-plus"></i></a>
							<a href=javascript:void(0); class="margin-left" style="color:red" title="cancel" onClick=cancelBtn();>
								<i class="fa fa-times"></i></a>
						</span>
					</div>
				</div>
				<div class="form-group margin-top-10">
				<label class="control-label col-lg-3 col-md-3 col-sm-4 col-xs-4" for="language">Language:</label>
					<div class="col-lg-5 col-md-5 co-sm-8 col-xs-8">
						<select id="language" class="form-control" required>
							<option selected value="0">English</option>
							<!-- <option value="1">Hindi</option> -->
						</select>
					</div>
				</div>
				<div class="form-group margin-top-10">
					<label class="control-label col-lg-3 col-md-3 col-sm-4 col-xs-4" for="duration">Time:</label>
					<div class="input-group col-lg-5 col-md-5 col-sm-8 col-xs-8" id="duration">
						<label class="control-label" for="minutes">(in minutes)</label>
						<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
							<input type="text" name="minutes" id="minutes" class="form-control" value="000" required/>
						</div>
					</div>
				</div>
				<div class="form-group margin-top-10">
					<label class="control-label col-lg-3 col-md-3 col-sm-4 col-xs-4" for="paper_questions">No. of Questions:</label>
					<div class="col-lg-1 col-md-2 co-sm-8 col-xs-8">
						<input type="text" class="form-control" style="width:70%;" id="paper_questions" required/>
					</div>
				</div>
				<div class="form-group margin-top-10 ">
				<label class="control-label col-lg-3 col-md-3 col-sm-4 col-xs-4" for="paper_title">Title:</label>
				<div class="col-lg-5 col-md-5 co-sm-8 col-xs-8">
					<textarea id="paper_title" placeholder="write your paper title here..." rows="4" style="width:70%;" class="form-control"></textarea>
				</div>
			</div>
			</fieldset>
		</form>
		<div class="clearfix"></div>
		<div class="form-group margin-top-10">
			<input type="button" class="btn btn-success col-lg-2 col-md-2 col-sm-6 col-xs-4" onClick=selectNext(); value="next"/>
			<input type="button" class="btn btn-danger col-lg-2 col-md-2 col-sm-6 col-xs-4 margin-left-5" onClick=selectCancel(); value="cancel"/>
		</div>';
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