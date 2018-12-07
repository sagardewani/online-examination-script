<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	include_once('../includes/sitedetails.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
					$ip = $_SESSION['IP'];
	$username = $_SESSION['username'];
	$firstname = $_SESSION['firstname'];
	$lastname = $_SESSION['lastname'];
	$e_lang = $_GET['lang'];
				if($_GET['lang'] == 0)
				{
					$lang = 'English';
	/*				$sql = "SELECT count(question_id) FROM hetrotec_exams.english_questions WHERE category_id = :a";
					$pstmt = $db->prepare($query);
					$pstmt->execute(array(

						':a' => $_GET['set']
					));
					$total = $result->fetchColumn();
					$pages = $total/10;
					$limit = 10;
					$left_rec = $rec_count - ($page * $limit);
					
					$offset = $limit+$offset;
					if( isset($_GET{'page'} ) ) {
						$page = $_GET{'page'} + 1;
						$offset = $limit * $page ;
					}else {
						$page = 0;
						$offset = 0;
						$limit OFFSET $offset
					}*/

					$query = "SELECT EQ.id,EQ.img,EQ.question_id,EQ.solution,EQ.paragraph_id,EQ.question_category,EQ.question_type,EQ.correct_opt,M.positive,M.negative FROM hetrotec_exams.english_questions EQ
							INNER JOIN hetrotec_exams.english_marks M ON M.question_id = EQ.id WHERE category_id=:a LIMIT 200";
					$pstmt = $db->prepare($query);
					$pstmt->execute(array(

					':a' => $_GET['set']
					));
					$pstmt->setFetchMode(PDO::FETCH_ASSOC);
					

				}
				else
				{
					$lang = 'Hindi';
					$query = "SELECT EQ.id,EQ.img,EQ.paragraph_id,EQ.solution,EQ.question_category,EQ.question_type,EQ.correct_opt,M.positive,M.negative FROM hetrotec_exams.hindi_questions EQ
							INNER JOIN hetrotec_exams.hindi_marks M ON M.question_id = EQ.id WHERE category_id=:a LIMIT 200";
					$pstmt = $db->prepare($query);
					$pstmt->execute(array(
					':a' => $_GET['set']
					));
					$pstmt->setFetchMode(PDO::FETCH_ASSOC);
				}
				$count = 1;
			
echo '
				<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>'.$site_title_prefix.':Admin Panel</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	<meta name="keywords" content='.$site_keywords.' >
	<meta name="description" content='.$site_desc.'>
	<meta property="og:title" content='.$site_title_prefix.':Online Portal>
	<meta property="og:url" content='.$site_url.'>
	<meta property="og:description" content='.$site_og_desc.'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <link href="https://fonts.googleapis.com/css?family=Anton|Fjalla+One" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/color.css">
  <link rel="stylesheet" href="../css/hetrotech10.css">
  <link rel="stylesheet" href="../css/hetrotecheducation.css">
  <link rel="icon" type="image/x-icon" href='.$site_favicon.'>  

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <script src="../js/jquery.blockui.js"></script>
  <script src="../js/admin_functions.js"></script>
  <script src="../js/slidenav.js?v1.0"> </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="modal fade" id="msgBox" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-color-green">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 id="msgTitle" class="modal-title">Question View</h4>
					</div>
					<div id="msg" class="modal-body">
						<div class="container " id="question_view"">
							<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9" style="border:3px solid black; border-radius:8px; background-color:rgba(13, 30, 74, 0.89) !important;	font-size:14px; color:white !important;">
							<div class="row col-lg-8 col-md-10 " >
								<div class="row" style="margin: 5px 10px; text-decoration:underline;">
									<h4>Question<b></b></h4>
								</div>
							</div>	
							<div class="row" style="margin: 15px 10px;">
								<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
									<div id="modal_question_directions"></div>
								</div>
							</div>
							<div class="row" style="margin: 15px 10px;">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div id="modal_question_paragraph">
									</div>
								</div>
							</div>
							<div class="row" style="margin: 15px 10px;">
								<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
									<div id="modal_question_question">
									</div>
								</div>
							</div>
							<div class="row" style="margin: 15px 10px;">
								<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
									<div id="modal_question_opt_1"></div>
								</div>
							</div>
							<div class="row" style="margin: 5px 10px;">
								<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
									<div id="modal_question_opt_2"></div>
								</div>
							</div>
							<div class="row" style="margin: 5px 10px;">
								<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
									<div id="modal_question_opt_3"></div>
								</div>
							</div>
							<div class="row" style="margin: 5px 10px;">
								<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
									<div id="modal_question_opt_4"></div>
								</div>
							</div>
							<div class="row" style="margin: 5px 10px;">
								<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
									<div id="modal_question_opt_5"></div>
								</div>
							</div>
							<div class="row" style="margin: 5px 10px;">
								<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
									<div id="modal_question_opt_6"></div>
								</div>
							</div>
							<div class="row" style="margin: 5px 10px;">	
								<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12">
									<div id="modal-question-solution"></div>
								</div>
							</div>
							</div>
					</div>
					<div id="msgFotter" class="modal-footer">
						<button class="btn btn-success btn-default pull-left" id="msgOK" data-dismiss="modal">OK</button>
					</div>
				</div>
			</div>
		</div>
</div>		
<nav class="navbar navbar-default no-margin">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" id="menu-toggle">
					<i class="fa fa-th-large" aria-hidden="true"></i>
				</button>
				<a class="navbar-brand pull-right" href='.$site_url.'><i class="fa fa-rocket fa-4"></i> '.$site_logo.'</a>
			</div>
			<ul class="nav navbar-nav navbar-right" style="margin-right:20px">
				<li>
					<a href="javascript:void(0);" class="usr-small-img dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<img src="../img/user8.jpg" alt="" style="margin-right:2px"><span id="admin_username">'.$username.'</span>
						<span class=" fa fa-angle-down"></span>
					</a>
					<ul class="dropdown-menu dropdown-usermenu" style="width:220px">
						<li><a href="mainpanel.php">Profile<span class="fa fa-user pull-right "></span></a></li>
						<li><a href="../notes/help.html" target="_blank">Help<span class="fa fa-info pull-right"></span></a></li>
						<li><a href="logout.php">Logout<span class="fa fa-sign-out pull-right"></span></a></li>
					</ul>
				</li>
			</ul>
		</nav>
		<div id="wrapper">
			
  <!-- Left side column. contains the logo and sidebar -->

	<div id="page-content-wrapper">
				<div class="container-fluid min-width-320">
						<div id="pages" class="row">
				
				<div class="container">
						<table id ="paper_view_entry" class="table table-bordered">
							<thead>
								<tr class="info">
									<th>#</th>
									<th>Question Type</th>
									<th>Question Category</th>
									<th>Correct Option</th>
									<th title="question have image">Image</th>
									<th>Marks</th>
									<th>View</th>
									
								</tr>
							</thead>';
								while($r = $pstmt->fetch())
								{
									$type = $r['question_type'];
									switch($type)
									{
										case 1: $type = "Normal"; break;
										case 2: $type = "Paragraphical"; break;
										case 3: $type = "Others"; break;
										default: $type = "Unknown";
									}
									$q_category = $r['question_category'];
									$correct = $r['correct_opt'];
									$img = $r['img'];
									$question_num = $r['question_id'];
									switch($img)
									{
										case 0: $img = "NO"; break;
										case 1: $img = "YES"; break;
										default: $img = "not specified";
									}
									$solution = $r['solution'];
									$positive = $r['positive'];
									$negative = $r['negative'];
									$id =  $r['id'];

									echo '<tbody><tr>
									<th>'.$question_num.'</th><th>'.$type.'</th><th>'.$q_category.'</th>
									<th>'.$correct.'</th><th>'.$img.
									'</th></th><th>+'.$positive.' & -'.$negative;
									echo "</th>
									<th>
										<a href=javascript:void(0); onClick=viewQuestions($id,$e_lang); >view question </a>
									</tr></tbody>";
								}
							
				echo '</table></div>			</div>
	</div></div>
	</body>
</html>		';
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