<?php

require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
			$query = 'SELECT * FROM hetrotec_exams.category WHERE id=:a';
			$stmt = $db->prepare($query);
			$stmt->execute(array(
				':a' => $_POST['c'],
				':b' => $_POST['lang'],
				':c' => $_POST['set']
			));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($_POST['lang'] == 0)
			{
				$lang = 'English';
			}
			else
			{
				$lang = 'Hindi';
			}
					echo '<div class="container">
						<div class="row block-content">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<label class="control-label" for="paper_language">Language
									<input type="text" id="paper_language" value='.$lang.' class="form-control" disabled /></label>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<label class="control-label form-control-textarea" for="question_paper">PAPER
								<textarea id="question_paper" class="form-control form-control-textarea" rows="5" disabled>'.$row["title"].'</textarea></label>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<label class="control-label" for="paper_time">Time Duration
									<input type="text" value='.$row["time"].'"(min)" id="paper_time" class="form-control" disabled /></label>
							</div>
						</div>
						<div class="row">
							<label class="control-label" for="question_marks">Marks:
								<span class="glyphicon glyphicon-plus"><input type="text" value="1" id="question_positive" class="form-control" disabled /></span> 
								<span class="glyphicon glyphicon-minus"><input type="text" value="0.25" id="question_negative" class="form-control" disabled /></span> 
							</label>
						</div>
					</div>		
					</br>
					<div class="clearfix"></div>
					<div class="container">	
						<div class="row hide" id="paragraph">
							<div class="form-group form-control-textarea-3">
								<label class="control-label" for="paragraph_text">Paragraph</label>
								<textarea name="paragraph" id="paragraph_text" placeholder="write your paragraph here..." rows="20" class="form-control form-control-textarea-2"></textarea>
							</div>
						</div>
						</br>
					</div>	
					<form name="question_paper" role="form" class="container form-inline">	
						<div class="clearfix"></div>
						<div class="row">
							<div class="form-group form-control-textarea-3">
								<label class="control-label" for="question_no">Q.</label>
								<select id="question_no" class="form-control" disabled>
									<option value="1">1</option>
								</select>
								<textarea name="question" id="question_text" placeholder="write your question here..." rows="5" class="form-control form-control-textarea-2"></textarea>
							</div>
						</div>
						</br>
						<div class="clearfix"></div>
						<div class="row">
							<div class="form-group form-control-textarea-2">
								<label class="control-label radio"><input type="radio" name="option" id="opt_1">	</label>
								<input type="text" id="option_text_1" placeholder="write your 1st option here..." class="form-control form-control-textarea-2"/>
							</div>
						</div>
						</br>
						<div class="clearfix"></div>
						<div class="row">
							<div class="form-group form-control-textarea-2">
								<label class="control-label radio"><input type="radio" name="option" id="opt_2">	</label>
								<input type="text" id="option_text_2" placeholder="write your 2nd option here..." class="form-control form-control-textarea-2"/>
							</div>
						</div>
						</br>
						<div class="clearfix"></div>
						<div class="row">
							<div class="form-group form-control-textarea-2">
								<label class="control-label radio"><input type="radio" name="option" id="opt_3">	</label>
								<input type="text" id="option_text_3" placeholder="write your 3rd option here..." class="form-control form-control-textarea-2"/>
							</div>
						</div>
						</br>
						<div class="clearfix"></div>
						<div class="row">
							<div class="form-group form-control-textarea-2">
								<label class="control-label radio"><input type="radio" name="option" id="opt_4">	</label>
								<input type="text" id="option_text_4" placeholder="write your 4th option here..." class="form-control form-control-textarea-2"/>
							</div>
						</div>
						</br>
						<div class="clearfix"></div>
						<div class="row hide" id="option_5">
							<div class="form-group form-control-textarea-2">
								<label class="control-label radio"><input type="radio" name="option" id="opt_5">	</label>
								<input type="text" id="option_text_5" placeholder="write your 5th option here..." class="form-control form-control-textarea-2"/>
							</div>
						</div>
						</br>
						<div class="clearfix"></div>
						<div class="row hide" id="option_6">
							<div class="form-group form-control-textarea-2">
								<label class="control-label radio"><input type="radio" name="option" id="opt_6">	</label>
								<input type="text" id="option_text_6" placeholder="write your 6th option here..." class="form-control form-control-textarea-2"/>
							</div>
						</div>
						</br>
						<div class="clearfix"></div>
					</form>
					</br>
					<div class="clearfix"></div>
					<form name="question_paper_2" class="container">
						<div class="row block-content">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<label class="control-label" for="options">Options
								<select id="options" class="form-control">
									<option selected value="4">4</option>
									<option value="5">5</option>
									<option value="6">6</option>
								</select></label>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<label class="control-label" for="question_category_type">Question Type
								<select id="question_category_type" class="form-control">
									<option value="-1">Other(Specified)</option>
									<option selected value="General">General</option>
									<option value="Reasoning">Reasoning</option>
									<option value="Logical Reasoning">Logical Reasoning</option>
								</select></label>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<label class="control-label" for="question_type">Type</label>
								<select id="question_type" class="form-control">
									<option selected value="1">Normal</option>
									<option value="2">Paragraphical</option>
									<option value="3">Others</option>
								</select>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 hide" id="special_questions">
								<label class="control-label" for="question_related">Paragraph Questions
								<input class="form-control" id="question_related" type="text" placeholder="insert here..." /></label>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label class="control-label" for="paper_set">Paper Set
								<input class="form-control" id="paper_set" type="text" value='.$row["set_no"].' disabled /></label>
							</div>
						</div>
						<div class="row col-md-offset-3">
							<input type="submit" class="btn btn-success btn-default col-lg-1 col-md-1 col-sm-1 col-xs-1" id="save" value="save"/>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
							<input type="submit" class="btn btn-primary btn-default col-lg-1 col-md-1 col-sm-1 col-xs-1" id="edit" value="edit"/>
							<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"></div>
							<input type="submit" class="btn btn-danger btn-default col-lg-1 col-md-1 col-sm-1 col-xs-1" id="cancel" value="cancel"/>
						</div>
					</form>	';
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