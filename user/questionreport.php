<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	include_once('../includes/sitedetails.php');
	if(isset($_SESSION['islogged']) || ($user->is_logged_in() && $user->is_admin()))
	{
		
		if(isset($_POST['user']) && isset($_POST['code']))
		{
			
			$id = $_POST['user'];
			$code = $_POST['code'];
			
			$query = "SELECT finish FROM user_paper WHERE users_id = :a AND category_id=:b";
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a'=>$id,':b'=>$code));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if(!empty($row['finish']))
			{
				$viewable = $row['finish'];
			}
			else
			{
				exit("<h2>You have not completed the test yet.<br>Please complete the exam first and then come back to see your result.</h2><br>Click Here to go <a href=user_area.php title=back alt=back>&#8678;</a>");
			}
			
			if($viewable){
			$query = "SELECT C.title FROM category C WHERE C.id = :a";
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a'=>$code));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$title =$row['title'];
			$q_count=0;
			$query = "SELECT UAE.is_answered,UAE.is_correct FROM user_answers_english UAE WHERE UAE.users_id = :a AND UAE.category_id = :b";
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a'=>$id,':b'=>$code));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			/*while($r = $stmt->fetch())
			{

				
			}*/
			
			$query = "SELECT Q.*,UAE.opt_select FROM english_questions Q LEFT JOIN user_answers_english UAE ON UAE.question_id = Q.id WHERE UAE.users_id =:a AND UAE.category_id=:b";
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a' => $id,':b'=>$code));
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			echo '<!DOCTYPE HTML>
<html>
	<head>
		<title>Question Report</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content='.$site_keywords.' >
		<meta name="description" content='.$site_desc.'>
		<meta property="og:title" content='.$site_title_prefix.':Online Portal>
		<meta property="og:url" content='.$site_url.'>
		<meta property="og:description" content='.$site_og_desc.'>
		 <!--CSS  -Linksheets!-->
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		 <link href="https://fonts.googleapis.com/css?family=Anton|Fjalla+One" rel="stylesheet">
		 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		 <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
		 <link rel="stylesheet" href="../css/common.css">
		 <link rel="stylesheet" href="../css/hetrotecheducation.css">
		 <link rel="stylesheet" href="../css/color.css">
		 <link rel="icon" type="image/x-icon" href='.$site_favicon.'>
		 
		 <!-- JSS -Javascripts!-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.2/raphael-min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.js"></script>
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }</script>';
?>


			<style>
				.margin-top-10p
				{
					margin-top:5%;
				}
				.margin-top-2p
				{
					margin-top:2%;
				}
			</style>
			<script>
				function viewResult(){
					$exam_code = $("#examcode").val();
					var user_id = $("#userid").val();
					data = {user:user_id,code:$exam_code};
					//console.log(data);
					post("result.php",data);
				}
				function post(path, params, method) {
			method = method || "post"; // Set method to post by default if not specified.

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
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
				function toggleParagraph(qNum)
				{
					$("#passage_"+qNum).toggleClass("hide");
				}
			</script>

	<body>
		<input type="hidden" id="userid" value=<?php echo $id; ?> >
		<input type="hidden" id="examcode" value=<?php echo $code; ?> >
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					 <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#Navbar">
						  <span class="icon-bar"></span>
						  <span class="icon-bar"></span>
						  <span class="icon-bar"></span>                        
					  </button>
					  <a class="navbar-brand" href=<?php echo $site_url; ?> ><?php echo $site_title_prefix; ?></a>
				</div>
				<div class="collapse navbar-collapse" id="Navbar">
					<ul class="nav navbar-nav">
						 <li><a href=javascript:void(0); onClick=viewResult()>Score Card</a></li>
						 <li><a href="#tab1";>Question Report</a></li>
						 <li><a href="user_area.php" id="home">Home</a></li>
					</ul>	
				</div>
			</div>			
		</nav>
		<div class="container-fluid">
		<h1 class="text-center" style="margin-top:5%;" ><?php echo $title; ?></h1>
		</div>
		<div id="tab1" class="margin-top-10p">
					<h1 class="text-center"><b>Question Report</b></h1>
					<div class="container table-responsive">
						<table class="table table-bordered">
							<thead>
								<tr><th width=20px>#</th>
								<th>Question</th>
								</tr>
							</thead>
							<tbody>
							<?php
							while($r = $stmt->fetch())
								{
									$q_count++;
									$q_direction = $r['question_direction'];
									$question = $r['question'];
									$img = $r['img'];
									$bgColor = "bg-color-none";
									$opt1 = "<tr><td class=".$bgColor." >1)&nbsp ".$r['opt_1']."</td></tr>";
									$opt2 = "<tr><td class=".$bgColor." >2)&nbsp ".$r['opt_2']."</td></tr>";
									$opt3 = "<tr><td class=".$bgColor." >3)&nbsp ".$r['opt_3']."</td></tr>";
									$opt4 = "<tr><td class=".$bgColor." >4)&nbsp ".$r['opt_4']."</td></tr>";
									$opt5 = "<tr><td class=".$bgColor." >5)&nbsp ".$r['opt_5']."</td></tr>";
									$opt6 = "<tr><td class=".$bgColor." >6)&nbsp ".$r['opt_6']."</td></tr>";
									
									$selected = $r['opt_select'];
									$correct = $r['correct_opt'];
									//$bgColorCorrect = "bg-color-green";
									if($selected == $correct)
									{
										$bgColor = "bg-color-green";
										switch($correct)
										{
											case 1: $opt1 = "<tr><td class=".$bgColor." >1)&nbsp ".$r['opt_1']."</td></tr>"; break;
											case 2: $opt2 = "<tr><td class=".$bgColor." >2)&nbsp ".$r['opt_2']."</td></tr>"; break;
											case 3:	$opt3 = "<tr><td class=".$bgColor." >3)&nbsp ".$r['opt_3']."</td></tr>"; break;
											case 4:	$opt4 = "<tr><td class=".$bgColor." >4)&nbsp ".$r['opt_4']."</td></tr>"; break;
											case 5:	$opt5 = "<tr><td class=".$bgColor." >5)&nbsp ".$r['opt_5']."</td></tr>"; break;
											case 6:	$opt6 = "<tr><td class=".$bgColor." >6)&nbsp ".$r['opt_6']."</td></tr>"; break;
										}
									}
									else
									{
										$bgColor="bg-color-red";
										switch($selected)
										{
											case 1: $opt1 = "<tr><td class=".$bgColor." >1)&nbsp ".$r['opt_1']."</td></tr>"; break;
											case 2: $opt2 = "<tr><td class=".$bgColor." >2)&nbsp ".$r['opt_2']."</td></tr>"; break;
											case 3:	$opt3 = "<tr><td class=".$bgColor." >3)&nbsp ".$r['opt_3']."</td></tr>"; break;
											case 4:	$opt4 = "<tr><td class=".$bgColor." >4)&nbsp ".$r['opt_4']."</td></tr>"; break;
											case 5:	$opt5 = "<tr><td class=".$bgColor." >5)&nbsp ".$r['opt_5']."</td></tr>"; break;
											case 6:	$opt6 = "<tr><td class=".$bgColor." >6)&nbsp ".$r['opt_6']."</td></tr>"; break;
										}
										$bgColor="bg-color-green";
										switch($correct)
										{
											case 1: $opt1 = "<tr><td class=".$bgColor." >1)&nbsp ".$r['opt_1']."</td></tr>"; break;
											case 2: $opt2 = "<tr><td class=".$bgColor." >2)&nbsp ".$r['opt_2']."</td></tr>"; break;
											case 3:	$opt3 = "<tr><td class=".$bgColor." >3)&nbsp ".$r['opt_3']."</td></tr>"; break;
											case 4:	$opt4 = "<tr><td class=".$bgColor." >4)&nbsp ".$r['opt_4']."</td></tr>"; break;
											case 5:	$opt5 = "<tr><td class=".$bgColor." >5)&nbsp ".$r['opt_5']."</td></tr>"; break;
											case 6:	$opt6 = "<tr><td class=".$bgColor." >6)&nbsp ".$r['opt_6']."</td></tr>"; break;
										}
										
									}								
										$q_category = $r['question_category'];
									echo "<tr>
										<td>Q.$q_count</td>
										<td>
											<div id=directions>
												$q_direction
											</div>
											<div id=question class=margin-top-10>
												$question
											</div>";
									if($img == "YES")
									{
										$dir = "../images/papers/";
										$image_category = "category_".$set;
										$image_question = "_question_".$qQID.".jpeg";
										$src=$dir.$image_category.$image_question;
										echo "<div id=image class=margin-top-10>
												<img class='img-responsive  question-img' id=question_image src=$src />
											</div>";
									 }		
									 echo "<div id=options class=margin-top-2p>
												<table>$opt1$opt2$opt3$opt4";

										if($r['opt_5'] != NULL)
												echo "$opt5";
										if($r['opt_6'] != NULL)
												echo "$opt6";		
										echo "</table>
											</div>
										</td>							
									</tr>
									
									";
									if($r['paragraph_id'] !=0)
									{
											$query = "SELECT paragraph_text FROM paragraph_english WHERE id = :a";
											$pstmt = $db->prepare($query);
											$pstmt->execute(array(':a' => $r['paragraph_id']));
											$row = $pstmt->fetch(PDO::FETCH_ASSOC);
											$passage= $row['paragraph_text'];
									echo "
									<tr>
										<td></td>
										<td>
											<div id=solution>
												<div class=pull-right>
													<a href=javascript:void(0); onClick=toggleParagraph($q_count); style='margin-right:10px; background-color:lightgrey'>paragraph</a>
												</div>
											</div>
										</td>	
									</tr>
									<tr id=passage_$q_count class='hide bg-color-light-grey'>
										<td></td>
										<td>
											<p text-align=justify>$passage</p>
										</td>
									</tr>";
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
		<script>
			$('body').scrollspy({target: ".navbar", offset: 50});
			$("#Navbar a").on('click', function(event) {
				if (this.hash !== "") {
					event.preventDefault();
					var hash = this.hash;
					$('html, body').animate({
					  scrollTop: $(hash).offset().top
					}, 800, function(){
						window.location.hash = hash;
				});
				}
			});		
					

		</script>
	</body>
</html>
<?php 
			}
		}
	}
	else
	{
		exit("you are not logged in.<br>Click Here<a href=./index.php title=login>Login</a>");
	}
	exit;
?>				