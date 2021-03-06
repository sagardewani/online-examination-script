<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	include_once('../includes/sitedetails.php');
	if(!isset($_SESSION['islogged']))
	{
		exit("you are not logged in.");
	}
	if(isset($_POST['user']) && isset($_POST['code']) && isset($_POST['course']))
	{
		$id = $_POST['user'];
		$code = $_POST['code'];
		$course = $_POST['course'];

		echo '<!DOCTYPE html>
	<head>
		<title>Instructions</title>
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
		 <link rel="stylesheet" href="../css/hetrotecheducation.css">
		 <link rel="icon" type="image/x-icon" href='.$site_favicon.'>
		 <!-- JSS -Javascripts!-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
?>

		<style>
			.bg-color-light-blue, .bg-color-hover-light-blue:hover {
				color: #000!important;
				background-color: #b6dbea!important;
			}
		</style>
		<script  type="text/javascript">
			$(function($){
			
				function post(path, params, method) {
					method = method || "post"; 
					var form = document.createElement("form");
					form.setAttribute("method", method);
					form.setAttribute("action", path);

					for(var key in params) {
						if(params.hasOwnProperty(key)) {
						var hiddenField = document.createElement("input");
							hiddenField.setAttribute("type", "hidden");
							hiddenField.setAttribute("name", key);
							hiddenField.setAttribute("value", params[key]);
							form.appendChild(hiddenField);
						}
					}
					document.body.appendChild(form);
					form.submit();
				}
				$("#submit").on('click',function(e){
					e.preventDefault();
					if($("#accept").is(':checked'))
					{
						$element_name =
						$exam_code = <?php echo "$code;";?>
						$course = <?php echo "$course;";?>
						var user_id = <?php echo "$id;";?>
						data = {user:user_id,code:$exam_code,course:$course};
						post("quiz.php",data);
					}
					else
					{
						alert("Please accept the terms");
					}
				});
				function hideInstructionsButton()
				{
					$("#instructions").remove();
				}
			});
		</script>
	</head>
	<body>
		<div class="container-fluid col-lg-6">
			<div class="text-center">
				<p><b>Instructions For Exam</b></p>
			</div>
			<b>General Instructions</b>:
				<ol>
					<li>Total duration of examination is ____.</li>
					<li>The clock will be set at the server. The countdown timer in the top right of screen will display the remaining time available for you to complete the examination. When the timer reaches zero, the examination will end by itself. You will not be required to end or submit your examination.</li>
					<li>The Question Palette displayed on the right side of screen will show the status of each question using one of the following background color of button:
						<ul>
							<li><button type=button class="button not-selected" disabled>001</button>: You have not visited the question yet.</li>
							<li><button type=button class="button not-selected-unanswered" disabled>001</button>: You have not answered the question.</li>
							<li><button type=button class="button not-selected-answered" disabled>001</button>: You have answered the question.</li>
							<li><button type=button class="button not-selected-reviewanswered" disabled>001</button>: You have answered the question and marked for review.</li>
							<li><button type=button class="button not-selected-review" disabled>001</button>: You have not answered the question, but marked for review.</li>
							<li type=none>The Marked for Review status for a question simply indicates that you would like to look at that question again.
							<span class="text-color-text-red">If a question is answered and Marked for Reivew, your answer for that question will be considered in the evaluation.</span></li>
						</ul>
					</li>
					<li>To review the instructions at any time click on the instructions link at top right corner of the screen on black horizontal bar.</li>
					<li>To end the paper before the time is over click on the <b>Submit</b> button a popup will appear to ensure your selection.
					Click on <b>OK</b> button to submit the paper or <b>Cancel</b> button to cancel the submission of paper. 
					<span class="text-color-text-red">Note after clicking on OK button no further change would be possible.</span></li>					
				</ol>
			<b>Navigating to a Question</b>:
				<ol start=6>
					<li>To answer a question, do the following:
						<ul>
							<li>Click on the question number in the Question Palette at the right of your screen to go to that numbered question directly.
							Note that using this option also <b>SAVE</b> your answer to the current question.</li>
							<li>Click on <b>Save & Next</b> to save your answer for the current question and then go to the next question.</li>
							<li>Click on <b>Mark for Review & Next</b> to save your answer for the current question, mark it for review, and then go to the next question.
							Note that if you have not selected any option for the current question then it will not considered as answered.</li>
						</ul>
					</li>
				</ol>
			<b>Answer a Question</b>:
				<ol start=7>
					<li>
						Procedure for answering a multiple choice type question:
						<ul>
							<li>To select your answer, click on the <b>radio</b> button of one of the options.</li>
							<li>To deselect your chosen answer, click on the <b>Clear Response</b> button.</li>
							<li>To change your chosen answer, click on the <b>radio</b> button of another option.</li>
							<li>To save your answer, you MUST click on the <b>Save & Next</b> button.</li>
							<li>To mark the question for review, click on the <b>Mark for Review & Next</b> button.
							If an answer is selected for a question that is Marked for Review, that answer will be considered in the evaluation.</li>
						</ul>
					</li>
					<li>To change your answer to a question that has already been answered, first select that question for answering and then follow the procedure for answering that type of question.</li>
					<li>Note that ONLY Questions for which answers are saved or marked for review after answering will be considered for evaluation</li>
				</ol>
			<b>Navigating through Category</b>:
				<ol start=10>
					<li>Categories in this question paper are displayed on the top bar of the screen.
					Questions in a category can be viewed by clicking on the category name.
					The category you are currently viewing is visible on right side of the screen above the question palette in green color box.</li>
					<li>After clicking the <b>Save & Next</b> button on the last question for a section, you will automatically be taken to the first question of the next section.</li>
					<li>You can shuffle between tests and questions anytime during the examination as per your convenience only during the time stipulated.</li>
					<li>Candidate can view the corresponding section summary as part of the legend that appears in every section above the question palette.</li>
				</ol>
				<p class="text-center"><b>Please note all questions will appear in English language.</b></p>
				<div id="instructions">
				<input type=checkbox id="accept"><span>I have read and understood the instructions.</span><br>
				<input type=button id="submit" value="I Accept & Agree" class="btn btn-info col-md-offset-4">
				</div>
		</div>
	</body>
</html>
<?php 
	}
	exit;
?>