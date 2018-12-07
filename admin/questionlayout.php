<?php
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
include_once('../includes/sitedetails.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
			$query = 'SELECT Cl.*,C.* FROM hetrotec_exams.category C
			INNER JOIN hetrotec_exams.category_list Cl ON Cl.id =C.category_id
			WHERE C.id=:a';
			$stmt = $db->prepare($query);
			$stmt->execute(array(

				':a' => $_GET['set']
			));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if($_GET['lang'] == 0)
			{
				$lang = 'English';
				$query = "SELECT * FROM hetrotec_exams.english_questions WHERE category_id=:a ORDER BY question_id ASC";
				$pstmt = $db->prepare($query);
				$pstmt->execute(array(

				':a' => $_GET['set']
				));
				$pstmt->setFetchMode(PDO::FETCH_ASSOC);
			}
			echo '<!DOCTYPE HTML>
			<html>
				<head>
					<title>'.$site_title_prefix.':Admin Panel</title>
					<meta name="viewport" content="width=device-width, initial-scale=1">
					<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
					<meta name="keywords" content='.$site_keywords.' >
					<meta name="description" content='.$site_desc.'>
					<meta property="og:title" content='.$site_title_prefix.':Online Portal>
					<meta property="og:url" content='.$site_url.'>
					<meta property="og:description" content='.$site_og_desc.'>
					 <!--CSS  -Linksheets!-->
					 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
					 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
					 <link rel="stylesheet" href="../css/color.css">
					 <link rel="stylesheet" href="../css/hetrotech10.css">
					  <link rel="stylesheet" href="../css/hetrotecheducation.css">
					 <link rel="icon" type="image/x-icon" href='.$site_favicon.'>
					 <!-- JSS -Javascripts!-->
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
					<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
					<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=th6iyc3o2vkiuvp57c4dncjile705zolpl0377pisbqgcn8h"></script>
					<script src="../js/jquery.blockui.js"></script>
					<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }</script>
					<script type="text/javascript" src="../js/qlayout.min.js"></script>
				</head>';
			?>
			
				<!--<button id="show">show</button>-->
				<body class="container-fluid bg-color-white">
					<input type=hidden id=set value=<?php echo $_GET['set']; ?> >
					<div class="container bg-color-light-grey">
					<div class="modal fade" id="msgBox" role="dialog">
						<div class="modal-dialog modal-sm">
							<div class="modal-content">
								<div class="modal-header bg-color-green">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 id="msgTitle" class="modal-title">Attention !!!</h4>
								</div>
								<div id="msg" class="modal-body">
									<p id="msgText"></p>
								</div>
								<div id="msgFotter" class="modal-footer">
									<button class="btn btn-success btn-default pull-left" id="msgOK" data-dismiss="modal">OK</button>
									<button class="btn btn-danger btn-default pull-right" id="msgCancel" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>
					</br>
					<div class="clearfix"></div>
					<div class="bg-color-white">
						<section>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<label class="control-label" for="paper_language">Language
									<input type="text" id="paper_language" value=<?php echo $lang;?> class="form-control" disabled /></label>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<label class="control-label form-control-textarea" for="question_paper">PAPER
								<textarea id="question_paper" class="form-control form-control-textarea" rows="5" disabled><?php echo $row['title'];?></textarea></label>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<label class="control-label" for="paper_time">Time Duration
									<input type="text" value=<?php echo ($row['time']/60)."(min)";?> id="paper_time" class="form-control" disabled /></label>
							</div>
						</section>
						<section>
							<label class="control-label" for="question_marks">Marks:
								<span class="glyphicon glyphicon-plus"><input type="text" value="1" id="question_positive" class="form-control" disabled /></span> 
								<span class="glyphicon glyphicon-minus"><input type="text" value="0.25" id="question_negative" class="form-control" disabled /></span> 
							</label>
						</section>
					</div>		
					</br>
					<div class="clearfix"></div>
					<div class="container">
						<div class="row " id="directions">
							<div class="form-group form-control-textarea-3">
								<label class="control-label col-md-1" for="direction_text">Question Directions*</label>
								<textarea name="question_direction" id="direction_text" rows="3" placeholder="write question guidelines here..." class="form-control form-control-textarea-3"></textarea>
							</div>
						</div>
						</br>
						<div class="row hide" id="paragraph">
							<div class="form-group form-control-textarea-3">
								<label class="control-label" for="paragraph_text">Paragraph</label>
								<div name="paragraph" id="paragraph_text" class="form-control form-control-textarea-2"></div>
							</div>
						</div>
						</br>
						<form name="images" id="form_images">
						<div class="row hide" id="images">
							<div class="form-group">
								<label class="control-label" for="question_images">images</label>
								<input type="file" name="question_images" id="question_images" class="form-control"/>
								<div class="margin-4-10">
									<img  width="190px" height="200px" id="show_image" class="img-responsive img-rounded"/>
								</div>	
								<input type="hidden" name="question_image"/>
							</div>
						</div>
						</form>
					</div>	
					<form name="question_paper" role="form" class="container form-inline">	
						<div class="clearfix"></div>
						<div class="row">
							<div class="form-group form-control-textarea-3">
								<label class="control-label" for="question_no">Q.</label>
								<select id="question_no" class="form-control" disabled>
							<?php while($r=$pstmt->fetch())
									{ 
										$value= $r['question_id'];
										echo '<option value='.$value.'>'.$value.'</option>';
									}
									$value= $value+1;
									echo '<option selected value='.$value.'>'.$value.'</option>';
									?>	
								</select>
								<textarea name="question" id="question_text" placeholder="write your question here..." rows="5" class="form-control form-control-textarea-2"></textarea>
							</div>
						</div>
						</br>
						<div class="clearfix"></div>
						<div class="row">
							<div class="form-group form-control-textarea-2">
								<label class="control-label radio"><input type="radio" name="option" id="opt_1">	</label>
								<input id="option_text_1" placeholder="write your 1st option here..." class="form-control form-control-textarea-2"/>
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
								<label class="control-label radio"><input type="radio" name="option"  id="opt_4">	</label>
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
						<div class="row" id="solution">
							<div class="form-group form-control-textarea-3">
								<label class="control-label" for="question_solution">Solution</label>
								<div name="solution" id="question_solution" class="form-control form-control-textarea-2"></div>
							</div>
							
						</div>

						</br>
						<div class="clearfix"></div>
					</form>
					</br>
					<div class="clearfix"></div>
					<form name="question_paper_2" class="container">
						<div class="row block-content table-responsive bg-color-white">
							<table class="table table-bordered">
								<thead>
									<tr class="info">
										<th>Options</th>
										<th>Question Type</th>
										<th>Type</th>
										<th>Image</th>
										<th>Paper Set</th>
										<th >Question Related</td>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>
											<select id="options" class="form-control">
												<option selected value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
											</select>
										</td>
										<td>
											<select id="question_category_type" class="form-control">
												<option value="-999">None</option>
												<option value="-1">Other(Specified)</option>
												<?php 
													$query = "SELECT distinct(question_category) FROM hetrotec_exams.english_questions WHERE category_id=:a";
													$stmt = $db->prepare($query);
													$stmt->execute(array(':a'=>$_GET['set']));
													$stmt->setFetchMode(PDO::FETCH_ASSOC);
													while($r = $stmt->fetch())
													{	
														$question_category = $r['question_category'];
														echo '<option value='.$question_category.'>'.$question_category.'</option>';
													}
												?>
											</select>
										</td>	
										<td>
											<select id="question_type" class="form-control">
												<option selected value="1">Normal</option>
												<option value="2">Paragraphical</option>
												<option value="3">Others</option>
											</select>
										</td>
										<td>
											<select id="image_required" class="form-control">
												<option selected value="0">No</option>
												<option value="1">Yes</option>
											</select>
										</td>	
										<td>
											<input class="form-control" id="paper_set" type="text" value=<?php echo $row['id']; ?> disabled />
										</td>
										<td class="hide" id="special_questions">
											<input class="form-control" id="question_related" type="text" placeholder="insert here..." />
										</td>
									</tr>
								</tbody>
							</table>
						</div>
						<div class="row col-md-offset-1" style="margin:20px">
							<SPAN class="margin-left margin-4-10">
								<input type="submit" class="btn btn-success btn-default button-padding bottom-tab" id="save" value="save"/>
								<div class="loader hide" id="loader"></div>
							</SPAN>
							<span class="margin-left margin-4-10">
								<input type="submit" class="btn btn-primary btn-default button-padding bottom-tab" id="edit" value="edit"/>
							</span>
							<span class="margin-left margin-4-10">
								<input type="submit" class="btn btn-danger btn-default button-padding bottom-tab" id="cancel" value="cancel"/>
							</span>
							<span class="margin-left margin-4-10">
								<input type="submit" class="btn btn-info btn-default bottom-tab" id="done" value="Submit Paper"/>
							</span>
						</div>
					</form>
					</div>
				</body>
			</html>
<?php
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