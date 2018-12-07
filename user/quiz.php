<?php
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
require_once('../includes/sitedetails.php');
function time_in_seconds($date)
{
	$str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $date);
	sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
	return $slot_seconds = $hours * 3600 + $minutes * 60 + $seconds;
}

if($user->is_user_logged())
{
	$id = $_POST['user'];
	$code = $_POST['code'];//contain ids of category 
	$course =$_POST['course'];// contain ids of category list
	$query = "SELECT id,users_id,slot,package,is_active FROM hetrotec_exams.course WHERE users_id=:a AND is_active=:b AND category_id = :c ";
	$stmt = $db->prepare($query);
	$stmt->execute(array(':a' => $id,':b' => 1,':c'=>$course));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if(!empty($row['id']))
	{	
		$status = $row['is_active'];
		$c_id = $code;
		$slot = $row['slot'];
		$course_id = $row['id'];
		$question_number_count = 0;
	}
	else
	{
		//indicate there is no entry matching the desired paper. Tell them sorry, there is no existing paper and refuse the request.
		exit('<h>Maybe paper of this category is not active yet</h><br>Click Here to go <a href=user_area.php title=back alt=back>&#8678;</a>');
	}
	if($status == 1)
	{
	
		$query = 'SELECT U.Username,C.time,C.questions,C.title,C.is_active as paper_active,Cl.category_name 
					FROM hetrotec_exams.course Co
				INNER JOIN hetrotec_exams.users U ON U.id = Co.users_id
				INNER JOIN hetrotec_exams.category C ON C.category_id = Co.category_id
				INNER JOIN hetrotec_exams.category_list Cl ON Cl.id = C.category_id
				WHERE C.id=:c AND Co.is_active=:d';
		$stmt = $db->prepare($query);
		$stmt->execute(array(':c'=> $code,':d'=>1));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$user_id = $id;
		$username = $row['Username'];
		$category = $row['category_name'];
		$title = $row['title'];
		$time = $row['time'];
		$questions = $row['questions'];
		$set = $code;//this indicate id of category table which in turn returns the id of paper fetched
		//$slot = $row['slot'];
		$question_category =null;
		$daysec = 86400;
		$slot_seconds = time_in_seconds($slot);
		
		$query = "SELECT Up.id,Up.is_attempted,Up.finish,UNIX_TIMESTAMP(timestamp) FROM hetrotec_exams.user_paper Up WHERE Up.users_id = :a AND Up.category_id = :b";
		try{
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a' => $user_id,':b'=> $code));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		catch(PDOException $e)
		{
			$error[] = $e->getMessage();
		}
		if(!empty($row['id']))
		{
			$finish = $row['finish'];
			$attempt = $row['is_attempted'];
			$initialized = $row['UNIX_TIMESTAMP(timestamp)'];
		}
		else
		{
			$finish = 0;
			$attempt=0;
			$initialized = time();
		}
		
		// H - 24 hour format ; h - 12 hour format
		$current_time = time_in_seconds(date("H:i:s"));
		//echo $current_time - $slot_seconds;
		if($current_time - $slot_seconds <= 900 && $current_time - $slot_seconds >= 0 || $attempt == 1){ $is_passed = 0;}//indicate user have time to attempt the paper within time limit of 15min.}
		else{ exit('<h>Your time has been passed please come tomorrow.</h><br>Click Here to go <a href=user_area.php title=back alt=back>&#8678;</a>');}
		//echo "time_left: ".$is_passed;
		//echo "</br>check: <br>"."current_time: ".$current_time."<br> slot_seconds: ".$slot_seconds."<br> duration: ".($current_time - $slot_seconds)."<br> slot: ".$slot;
		$lang = 0;

		if(!$is_passed)
		{
			
			if($finish)
			{
				exit('<h2>Paper is Finished Yet</h2><br>Click Here to go <a href=user_area.php title=back alt=back>&#8678;</a>');
			}
			else
			{	
				if(time() - $initialized <= $time && time() - $initialized >= 0)
				{	
					$query = 'SELECT DISTINCT(question_category) FROM hetrotec_exams.english_questions WHERE category_id=:a';
					try{
						$stmt = $db->prepare($query);
						$stmt->execute(array(':a' => $set));
						$stmt->setFetchMode(PDO::FETCH_ASSOC);
					}
					catch(PDOException $e)
					{
						$error[] =$e->getMessage();
					}
					while($d = $stmt->fetch())
					{
						$question_category[] = $d['question_category'];
						//$question_type[] = $r['question_type'];
					} 
					$random_question_category = array_rand($question_category,1);
					//$random_question_type = array_rand($question_type,1);
					//if($random_question_type == 0)
					$value = rand(0,1);	
					if($value == 0)
					{
					$query = 'SELECT Q.*,M.positive,M.negative FROM hetrotec_exams.english_questions Q
								INNER JOIN hetrotec_exams.english_marks M ON M.question_id = Q.id
							WHERE `category_id`= :a ORDER BY question_category ASC';
					}
					else if($value == 1)
					{
						$query = 'SELECT Q.*,M.positive,M.negative FROM hetrotec_exams.english_questions Q
								INNER JOIN hetrotec_exams.english_marks M ON M.question_id = Q.id
							WHERE `category_id`= :a ORDER BY question_category DESC';
					}		
					//else if($random_question_type >= 1)
					//$query = 'SELECT Eq.*,Ep.* FROM hetrotec_exams.english_questions Eq INNER JOIN hetrotec_exams.paragraph_english Ep ON Ep.id = Eq.paragraph_id WHERE `question_category`= :a ORDER BY question_id';
					$qstmt = $db->prepare($query);
					$qstmt->execute(array(':a' => $set));
					$qstmt->setFetchMode(PDO::FETCH_ASSOC);
					$question = 0;
					/*//SELECT Eq.*,Ep.* FROM hetrotec_exams.english_questions Eq INNER JOIN hetrotec_exams.paragraph_english Ep ON Ep.id = Eq.paragraph_id WHERE `question_category`= "General" ORDER BY RAND();
					$stmt = $db->prepare($query);
					$stmt->execute(array(':a' => $c_id));
					$stmt->setFetchMode(PDO::FETCH_ASSOC);
					
					$query = 'SELECT * FROM hetrotec_exams.english_marks WHERE category_id=:a';
					$stmt = $db->prepare($query);
					$stmt->execute(array(':a' => $c_id));
					$stmt->setFetchMode(PDO::FETCH_ASSOC);*/
					if($value)
					$query = 'SELECT Q.*,UA.is_answered,UA.is_marked FROM hetrotec_exams.english_questions Q
							LEFT JOIN hetrotec_exams.user_answers_english UA ON UA.question_id = Q.id AND UA.users_id = :b
					WHERE Q.category_id= :a ORDER BY question_category DESC';
					else
					$query = 'SELECT Q.*,UA.is_answered,UA.is_marked FROM hetrotec_exams.english_questions Q
							LEFT JOIN hetrotec_exams.user_answers_english UA ON UA.question_id = Q.id AND UA.users_id = :b
					WHERE Q.category_id= :a ORDER BY question_category ASC';					
					$pstmt = $db->prepare($query);
					$pstmt->execute(array(':a' => $set,':b'=>$user_id));
					$pstmt->setFetchMode(PDO::FETCH_ASSOC);
					echo '<!DOCTYPE html>
	<head>
		<title>'.$site_title_prefix.':Online Quiz </title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
		 <link rel="stylesheet" href="../css/hetrotecheducation.css?v=1.0">
		<link rel="icon" type="image/x-icon" href='.$site_favicon.'>
		 <!-- JSS -Javascripts!-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
				 <script src="../js/jquery.blockui.js"></script>
		<script type="text/javascript" src="../js/jquery.countdownTimer.min.js"></script>
		<script type="text/javascript" src="../js/functions_page2.js"></script>
		<script type="text/javascript" src="../js/quiz.min.js"></script>';
?>	


		<style>
			.form-control {
				width:auto;
				display:inline-block;
			}
			
			
		</style>

	</head>	
	<body>
		<div class="container-fluid">
			<div class="modal fade" id="msgBox" role="dialog">
			<div id="modal-class" class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-color-green">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 id="msgTitle" class="modal-title">Attention !!!</h4>
					</div>
					<div id="msg" class="modal-body">
						
					</div>
					<div id="msgFotter" class="modal-footer">
						<button class="btn btn-success btn-default pull-left" id="msgOK" data-dismiss="modal">OK</button>
						<button class="btn btn-danger btn-default pull-right" id="msgCancel" data-dismiss="modal">Cancel</button>
					</div>
				</div>
			</div>
			</div>
			<div class="bg-color-blue box-50">
				<h3><span class="site-name-font-style"><?php echo $site_logo;?></span></h3>
			</div>
			<div class="bg-color-black box-20">
				<div class="pull-right">
					<span class="span-margin" id="instructions"><a href="#" class="text-color-text-white">Instructions</a></span>
				</div>
			</div>
			<div class="col-md-12 bg-color-light-grey">
				<div class="text-center">
					<h3><b><?php echo $title; ?></b></h3>
				</div>
			</div>
			<nav class="col-lg-10 col-md-8 navbar navbar-fixed">
				<?php
					if(isset($question_category))
					{
						foreach($question_category as $question_category)
						{
							echo "<input type='button' id='q_category_$question_category' name='q_category' class='btn navbar-btn category-button' value=$question_category>";
						}
					}

				?>
				<div class="pull-right ">
					<p id="timer"><b>Time Left: <?php echo $time; ?></b></p>
				</div>
			</nav>
			
			
				
				<?php 
				echo "<input type=hidden id=totalQuestion value=$questions>
							<input type=hidden id=totalTime value=$time>
							<input type=hidden id=lastTime value=$initialized>
							<input type=hidden id=userID value=$user_id>
							<input type=hidden id=paperCategory value=$c_id>
							<input type=hidden id=paperCourse value=$course_id>";
							
				while($r = $qstmt->fetch())
				{
					$qID = $r['id'];
					$qDirections = $r['question_direction'];
					$qQID = $r['question_id'];
					$question++;
					
					if($question == 1)
					{
						$show ="none";
					}
					else{
						$show ="hide";
					}
					if($show == "none")
					{
						echo "<input type=hidden id=currentQuestion value=$qID>";
					}
					
						$opt_1 = null;
						$opt_2 = null;
						$opt_3 = null;
						$opt_4 = null;
						$opt_5 = null;
						$opt_6 = null;
		
						$optt_1 = $r['opt_1'];
						$optt_2 = $r['opt_2'];
						$optt_3 = $r['opt_3'];
						$optt_4 = $r['opt_4'];
						$optt_5 = $r['opt_5'];
						$optt_6 = $r['opt_6'];

						$opt_1 = $optt_1;
						$opt_2 = $optt_2;
						$opt_3 = $optt_3;
						$opt_4 = $optt_4;

						
			?>
				<div class="col-lg-9 col-md-8 col-sm-12 col-xs-12 <?php echo $show; ?>" id=getQuestion_<?php echo $question."_id_".$qID; ?> alt=catQuestion_<?php echo $qID; ?> rel=<?php echo $r['question_category'];?> name=question_entry_<?php echo $question; ?> >
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-color-light-grey">
						<div class="pull-left">
							<label class="control-label" for="view-in">view in:</label>
							<select id="view_in" class="form-control simple-margin">
								<option selected value="0">English</option>
								<!-- <option value="1">Hindi</option> -->
							</select>
						</div>
						<div class="pull-left">
							<label class="simple-margin"><b>WRONG</b>:<span style="color:red"> -<?php echo $r['negative']; ?></span></label>
							<label class="simple-margin"><b>RIGHT</b>:<span style="color:green"> +<?php echo $r['positive']; ?></span></label>
						</div>
					
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 low-block-content">
						<p><b>Question no. <span id="question_number"><?php echo $question;?></span></b></p>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 low-block-content question-container">
						<table name="question_paper" class="table-width" cellpadding=3 height=100%>
							<tr>
								<td colspan=2>
									<div id="directions" class="margin-left">
										<p text-align=justify id="question_directions"><b>Directions</b>: <?php echo  $qDirections; ?></p>
									</div>
								</td>
							</tr>
				<?php	if($r['paragraph_id'])
						{
							$query = "SELECT Q.paragraph_id,P.id,P.paragraph_text,P.total FROM hetrotec_exams.paragraph_english P
							INNER JOIN hetrotec_exams.english_questions Q ON Q.id = :a AND P.id=Q.paragraph_id";
							try{
								$rstmt = $db->prepare($query);
								$rstmt->execute(array(':a' => $qID));
								$rrow = $rstmt->fetch(PDO::FETCH_ASSOC);
								echo "<tr>
								<td colspan=2><div id=paragraph class=margin-left>
									<p text-align=justify  class=paragraph-font id=question_paragraph >".$rrow['paragraph_text']." </p>
								</div></td>
							</tr>";
							}
							catch(PDOException $e)
							{
								$error[] =$e->getMessage();
							}
						}
						$query = "SELECT id,opt_select,elapsed FROM hetrotec_exams.user_answers_english WHERE question_id = :a AND users_id=:b";
						try{
							$tstmt = $db->prepare($query);
							$tstmt->execute(array(':a' => $qID,':b'=>$user_id));
							$trow = $tstmt->fetch(PDO::FETCH_ASSOC);
						
						}	
						catch(PDOException $e)
						{
							$error[] =$e->getMessage();
						}
						if(!empty($trow['id']))
						{
							$option_selected = $trow['opt_select'];
							$elapsed = $trow['elapsed'];
					
						}
						else
						{
							$option_selected = 0;
							$elapsed = 0;	
						}				
						if($r['img'])
						{		
							$dir = "../images/papers/";
							$image_category = "category_".$set;
							$image_question = "_question_".$qQID.".jpeg";
							$src=$dir.$image_category.$image_question;
							echo "<tr>
								<td colspan=2 align=left><div id=image class=margin-left>
									<img class='img-responsive  question-img' id=question_image src=$src />
								</div></td>
							</tr>";
						}	
						?>	
							
							<tr>
								<td colspan=2><div id="question" class="margin-left">
									<p id="only_question" class="question-font" text-align=justify><?php echo $r['question']; ?></p>
								</div>
								</td>
							</tr>
							<tr>
								<td colspan=2><div class="margin-left" >
									<div class="form-control-textarea-2 margin-left">
										<label class="control-label radio"><input type="radio" name="option_<?php echo $qID; ?>" id="o1" <?php echo ($option_selected == 1)?'checked':'' ?>>	
										<span class="option-font-style" id="opt_1"><?php echo $opt_1;?></span>
										</label>
									</div>
								</div>
								</td>
							</tr>
							<tr>
								<td colspan=2><div class="margin-left" >
									<div class="form-control-textarea-2 margin-left">
										<label class="control-label radio"><input type="radio" name="option_<?php echo $qID; ?>" id="o2" <?php echo ($option_selected == 2)?'checked':'' ?>>	
										<span class="option-font-style" id="opt_2"><?php echo $opt_2;?></span>
										</label>
									</div>
								</div>
								</td>
							</tr>
							<tr>
								<td colspan=2><div class="margin-left" >
									<div class="form-control-textarea-2 margin-left">
										<label class="control-label radio"><input type="radio" name="option_<?php echo $qID; ?>" id="o3" <?php echo ($option_selected == 3)?'checked':'' ?>>	
										<span class="option-font-style" id="opt_3"><?php echo $opt_3;?></span>
										</label>
									</div>
								</div>
								</td>
							</tr>
							<tr>
								<td colspan=2><div class="margin-left" >
									<div class="form-control-textarea-2 margin-left">
										<label class="control-label radio"><input type="radio" name="option_<?php echo $qID; ?>" id="o4" <?php echo ($option_selected == 4)?'checked':'' ?>>	
										<span class="option-font-style" id="opt_4"><?php echo $opt_4;?></span>
										</label>
									</div>
								</div>
								</td>
							</tr>
						<?php if($optt_5 != null )
						{
							$opt_5 = $optt_5;
							echo "<tr>
								<td colspan=2><div class=margin-left >
									<div class='form-control-textarea-2 margin-left'>
										<label class='control-label radio'><input type=radio name=option_$qID id=o5  ($option_selected == 5)?'checked': '' >	
										<span class=option-font-style id=opt_5>$opt_5</span>
										</label>
									</div>
								</div>
								</td>
							</tr>";
						}
						if($optt_6 != null)
						{
							$opt_6 = $optt_6;
							echo "<tr>
								<td colspan=2><div class=margin-left >
									<div class='form-control-textarea-2 margin-left'>
										<label class='control-label radio'><input type=radio name=option_$qID id=o6  ($option_selected == 6)?'checked': '' >	
										<span class=option-font-style id=opt_6>$opt_6</span>
										</label>
									</div>
								</div>
								</td>
							</tr>";
						} ?>
						</table>			
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 hidden-top-block-content" id=select_qOption_<?php echo $qID; ?> >
						<input type="button" class="form-control category-button-2 simple-black-border" id=q_mark_<?php echo $qQID."_number_".$question."_id_".$qID; ?> name="mark_next" value="Mark for Review & Next"/>
						<input type="button" class="form-control category-button-2 simple-black-border" id=q_clear_<?php echo $qQID."_number_".$question."_id_".$qID; ?> name="clear" value="Clear Response"/>
						<input type="button" class="form-control category-button-2 simple-black-border" id=q_save_<?php echo $qQID."_number_".$question."_id_".$qID; ?>  name="save_next" value="Save & Next"/>
						<input type="button" class="form-control btn-danger margin-left pull-right"  id="submit" value="Submit"/>
					</div>
				</div>
			<?php		
				}
			?>
			<div class="col-lg-3 col-md-4 col-sm-12">
				<div class=" box-110 bg-color-white new-box-shadow" style="padding:10px;">
					<div class="row block-content"  style="margin:1px; width:85px; height:90px; border: 1px solid gray;">
						<img class="new-box-shadow"  width="75px" height="80px" src="../images/profile.jpg" alt="profile-image"/>
					</div>
					<div style="margin-left:15px; font-size:0.8em">
					<span><a href="#" ><?php echo $username; ?></a></span></div>				
				</div>
				<div class="category-box-shadow bg-color-green">
					<span id="question_selected_category" >General Awareness</span>
				</div>
				<div class="box palette-container" >
				<h3><strong>Question Palette</strong></h3>
				<h5>Choose a Question</h5>
					<?php
					while($r = $pstmt->fetch())
					{
						$question_id = $r['id'];
						$question_number = $r['question_id'];
						$answered = $r['is_answered'];
						$marked = $r['is_marked'];
						$question_number_count++;
						if($question_number_count < 10)
						$prefix = "00";
						else if($question_number_count < 100 && $question_number_count >= 10)
						$prefix = "0";
						else
						$prefix = "";
						if($marked && $answered)
							if($question_number_count == 1)	
							echo "<button type=button  id=question_no_$question_id name=question_coun class='question_number_count_$question_number_count button selected-reviewanswered' style='margin:5px 3px;' ><span id=question_id_$question_id >$prefix$question_number_count</span></button>";
							else
							echo "<button type=button  id=question_no_$question_id name=question_count  class='question_number_count_$question_number_count button not-selected-reviewanswered' style='margin:5px 3px;' ><span id=question_id_$question_id >$prefix$question_number_count</span></button>";
						else if($answered)
							if($question_number_count == 1)	
							echo "<button type=button  id=question_no_$question_id name=question_count class='question_number_count_$question_number_count button selected-answered' style='margin:5px 3px;' ><span id=question_id_$question_id >$prefix$question_number_count</span></button>";							
							else
							echo "<button type=button  id=question_no_$question_id name=question_count  class='question_number_count_$question_number_count button not-selected-answered' style='margin:5px 3px;'><span id=question_id_$question_id >$prefix$question_number_count</span></button>";
						else if($marked)
							if($question_number_count == 1)	
							echo "<button type=button  id=question_no_$question_id name=question_count class='question_number_count_$question_number_count button selected-review' style='margin:5px 3px;'><span id=question_id_$question_id >$prefix$question_number_count</span></button>";							
							else
							echo "<button type=button  id=question_no_$question_id name=question_count class='question_number_count_$question_number_count button not-selected-review' style='margin:5px 3px;' ><span id=question_id_$question_id >$prefix$question_number_count</span></button>";
						else
							if($question_number_count == 1)	
								echo "<button type=button  id=question_no_$question_id name=question_count class='question_number_count_$question_number_count button selected' style='margin:5px 3px;'><span id=question_id_$question_id >$prefix$question_number_count</span></button>";
							else
								echo "<button type=button  id=question_no_$question_id name=question_count class='question_number_count_$question_number_count button not-selected' style='margin:5px 3px;'><span id=question_id_$question_id >$prefix$question_number_count</span></button>";
					}
					?>
				</div>
				<div class="box instruction-box">
					<table width=100%>
						<tr class="font-btn">
							<td width=50%><button type=button class="button not-selected" disabled>001</button>not visited</td>
							<td><button type=button class="button not-selected-unanswered" disabled>001</button>not answered</td>
						</tr>
						<tr class="font-btn">
							<td><button type=button class="button not-selected-answered" disabled>001</button>answered</td>
							<td><button type=button class="button not-selected-review" disabled>001</button>mark for review</td>
						</tr>
						<tr class="font-btn">
							<td><button type=button class="button not-selected-reviewanswered" disabled>001</button>review & answered</td>
						</tr>	
					</table>
				</div>
			</div>	
			</div>
			<script>
			function hasClass(elem, className) {
					return new RegExp(' ' + className + ' ').test(' ' + elem.className + ' ');
				}
				function setClick(element)
				{
					$self = element;
					var classes="-";
					$class_split = $self.className.split(' ');
					$class_name = $class_split[0];
					$split_class = $class_name.split('_');
					$required_class_name = $class_split[2];
					$class_array = $required_class_name.split('-');
					$class_array.forEach(function(item){
						if(item != "not" && item != "selected"){classes+=item;}
						});
					if(classes == "-")
					{
					$class = "not-selected";
					$rclass = "selected";
					}
					else
					{
						$class = "not-selected"+classes;
					$rclass = "selected"+classes;
					}

					//console.log(cls);
					var getElement =document.getElementsByClassName("question_number_count_"+question_count);
					if(hasClass(getElement[0],E))
					{
						getElement[0].classList.remove(E);
						getElement[0].classList.add(J);
					}
					else if(hasClass(getElement[0],A))
					{
						getElement[0].classList.remove(A);
						getElement[0].classList.add(F);
					}
					else if(hasClass(getElement[0],B))
					{
						getElement[0].classList.remove(B);
						getElement[0].classList.add(G);
					}
					else if(hasClass(getElement[0],C))
					{
						getElement[0].classList.remove(C);
						getElement[0].classList.add(H);
					}
					else if(hasClass(getElement[0],D))
					{
						getElement[0].classList.remove(D);
						getElement[0].classList.add(I);
					}
					
					if(hasClass($self,$class))
					{
						$self.classList.remove($class);
						$self.classList.add($rclass);
					}
					question_count = $split_class[3];					
				}
		</script>
	</body>
</html>
<?php
				}
				else {
					exit("Paper is not available.<br>Click Here to go <a href=user_area.php title=back alt=back>&#8678;</a>");
				}
			}
		}		
			
	}
}	
else
{
	header('Location: ../index.php');
	exit;
}
?>