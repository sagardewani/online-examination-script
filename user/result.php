<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	require_once('../includes/sitedetails.php');
	if(isset($_SESSION['islogged']) || ($user->is_logged_in() && $user->is_admin()))
	{
		
		if(isset($_POST['user']) && isset($_POST['code']))
		{
			
			function timedCount($timeInSeconds)
			{

			$hours = (int)($timeInSeconds / 3600 ) % 24;
			$minutes = (int)($timeInSeconds / 60 ) % 60;
			$seconds = ($timeInSeconds%60);
			$result = ($hours < 10 ? "0".$hours : $hours).":".($minutes < 10 ? "0".$minutes : $minutes).":".($seconds < 10 ? "0".$seconds: $seconds);
			return $result;
			}
			
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
			$query = "SELECT C.title,C.questions,C.time,C.marks,C.id FROM course Co INNER JOIN category C ON C.category_id = Co.category_id WHERE C.id = :a AND Co.users_id =:b";
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a'=>$code,':b'=>$id));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$title =$row['title'];
			$questions = $row['questions'];
			$time = $row['time'];
			$marks = $row['marks'];
			$count_correct = 0;
			$count_incorrect = 0;
			$positive = 0;
			$negative = 0;
			$q_count = 0;
			$query = "SELECT UAE.obtained,UAE.is_correct,U.time_taken FROM user_answers_english UAE INNER JOIN user_paper U ON U.users_id = UAE.users_id WHERE UAE.category_id = :a";
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a'=>$code));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$time_taken = $row['time_taken'];
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			while($r = $stmt->fetch())
			{
				if($r['is_correct'])
				{
					$count_correct++;
					$positive += $r['obtained'];
				}
				else
				{
					$count_incorrect++;
					$negative += $r['obtained'];
				}
				
			}
			
			$query = "SELECT question_direction,question,img,opt_1,opt_2,opt_3,opt_4,opt_5,opt_6,solution,paragraph_id,question_category,correct_opt FROM english_questions WHERE category_id =:a";
			$stmt = $db->prepare($query);
			$stmt->execute(array(':a' => $code));
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			echo '<!DOCTYPE HTML>
<html>
	<head>
		<title>Score Card</title>
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
			<script type="text/javascript">
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
			function viewReport(){
					$exam_code = $("#examcode").val();
					var user_id = $("#userid").val();
					data = {user:user_id,code:$exam_code};
					//console.log(data);
					post("questionreport.php",data);
				}
			$(function($){
				$(".paragraph_link").on('click',function(e){
					e.preventDefault();
					$getClass = $(this).attr('id');
					$splitClass = $getClass.split("_");
					$id = $splitClass[2];
					//console.log($splitClass,$id);
					$("#passage_"+$id).toggleClass("hide");
				});
				$(".solution_link").on('click',function(e){
					e.preventDefault();
					$getClass = $(this).attr('id');
					$splitClass = $getClass.split("_");
					$id = $splitClass[2];
					//console.log($splitClass,$id);
					$("#solution_"+$id).toggleClass("hide");
				});
			});
			</script>
		</head>
	
	
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
						 <li><a href="#tab1">Score Card</a></li>
						 <li><a href="#tab3" >Solution Report</a></li>
						 <li><a href=javascript::void(0); onClick=viewReport()>Question Report</a></li>
						 <li><a href="user_area.php" id="home">Home</a></li>
					</ul>	
				</div>
			</div>			
		</nav>
		<div class="container-fluid">
		<h1 class="text-center" style="margin-top:5%;" ><?php echo $title; ?></h1>
		</div>
		<div class="tab-content">
			<div class="tab-pane active in" id="tab1">
				<h1 class="text-center"><b>Score Card</b></h1>
				
				
				<div class="container table-responsive">
					<table class="table table-bordered">
					  <tbody>
						<tr>
						  <th>Total Marks</th>
						  <td width=20px><?php echo $marks;?></td>
						  <th title="rank you obtained">My Score</th>
						  <td width=20px><?php echo ($positive+$negative)?></td>
						  
						
						</tr>
								   
					  </tbody>
					  <br></br>
					  <tbody>
						<tr>
						  <th>Total Question</th>
						  <td><?php echo $questions; ?></td>
						  <th title="your time taken">My Time</th>
						  <td><?php echo timedCount($time_taken)."Hr"; ?></td>
						<!--  <td title="your percentile score">My Percentile</td>
						  <td>-----</td> -->
						  
						</tr>
						<tr>
						  <th>Total Time Of Test</th>
						  <td><?php echo timedCount($time)."Hr"; ?></td>
						<th>Correct/Incorrect Question</th>
						  <td width=40px><?php echo $count_correct."/".$count_incorrect; ?></td>
						</tr>
						<tr>
							<th colspan=3>Correct Marks/Negative Marks</th>
						  <td><?php echo  $positive."/".$negative; ?></td>
						</tr>
						
					</tbody>
					  
					  
					</table>
				 </div>
	
	<!-- <h1 class="text-center"><b>Subject Wise Score Card</b></h1>
		<div class="col-lg-4 col-md-4 col-md-offset-4" >
			<div id="graph" width=230px></div> 
		</div>	
		<div style="margin-top:20px">
            <table class="table table-bordered" >
            
			  
			  
			  
            </table>
			
          </div>
	</div>-->
		<div id="tab2" class="margin-top-10p">
		<h1 class="text-center"><b>Time Management Report</b></h1>
		<div id="Visitors"></div>
	<!-- <div class="bs-docs-example" id="tab2">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Subject</th>
                  <th>Percentage</th>
                  <th>Score & Time(in Min.)</th>
                  <th>How Did Topper Do</th>
				  
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td >English Language</td>
                  <td >-------</td>
				  <td >----------</td>
                  <td >-------</td> 
				  
				  
                </tr>
				                
              </tbody>
			  <br></br>
			  <tbody>
                <tr>
                  <td>Num Ability</td>
                  <td>-----</td>
				   <td>------------</td>
                  <td>-----</td>
			</tbody>
			<tbody>
                <tr>
                  <td>Rea  Ability</td>
                  <td>-----</td>
				   <td>--------</td>
                  <td>-----</td>
			</tbody>
			  
			  
			  
            </table>
          </div> -->
			</div>
		</div>	
	
		<div id="tab3" class="margin-top-10p">
			<h1 class="text-center"><b>Solution Report</b></h1>
			<div class="container table-responsive">
				<table class="table table-bordered">
					<thead>
						<tr><th width=20px>#</th>
						<th>Question</th>
						</tr>
					</thead>
					<tbody>
					<?php	while($r = $stmt->fetch())
						{
							$q_count++;
							$q_direction = $r['question_direction'];
							$question = $r['question'];
							$img = $r['img'];
							$opt1 = $r['opt_1'];
							$opt2 = $r['opt_2'];
							$opt3 = $r['opt_3'];
							$opt4 = $r['opt_4'];
							$opt5 = $r['opt_5'];
							$opt6 = $r['opt_6'];
							$solution = $r['solution'];
							$q_category = $r['question_category'];
							$correct = $r['correct_opt'];
							echo "<tr>
								<td>Q.$q_count</td>
								<td>
									<div id=directions>
										$q_direction
									</div>
									<div id=question class=margin-top-10>
										<b>$question</b>
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
										<table>
											<tr><td>1)&nbsp $opt1</td></tr>
											<tr><td>2)&nbsp $opt2</td></tr>
											<tr><td>3)&nbsp $opt3</td></tr>
											<tr><td>4)&nbsp $opt4</td></tr>";
								if($opt5 != NULL)
										echo "<tr><td>5)&nbsp $opt5</td></tr>";
								if($opt6 != NULL)
										echo "<tr><td>6)&nbsp $opt6</td></tr>";		
								echo "</table>
									</div>
								</td>							
							</tr>
							<tr>
								<td></td>
								<td>
									<div id=solution>
										<b>Correct Ans. $correct</b>
										<div class=pull-right>
											<a href=# class=paragraph_link id=paragraph_link_$q_count style='margin-right:10px; background-color:lightgrey'>paragraph</a>
											<a href=# class=solution_link id=solution_link_$q_count style='margin-right:10px; background-color:lightgrey'>solution</a>
										</div>
									</div>
								</td>	
							</tr>
							<tr id=solution_$q_count class='hide bg-color-light-grey'>
								<td></td>
								<td><div id=solution_text_$q_count>$solution</div></td>
							</tr>";
							if($r['paragraph_id'] !=0)
							{
									$query = "SELECT paragraph_text FROM paragraph_english WHERE id = :a";
									$pstmt = $db->prepare($query);
									$pstmt->execute(array(':a' => $r['paragraph_id']));
									$row = $pstmt->fetch(PDO::FETCH_ASSOC);
									$passage= $row['paragraph_text'];
							echo "<tr id=passage_$q_count class='hide bg-color-light-grey'>
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
				
				
		
		  </div>
		
		<!-- Example JavaScript -->
		<script>

		/*	Morris.Bar({
		  element: 'graph',
		  data: [
			{y: 'English', a: 100, b: 70},
			{y:'Numerical Analysis', a:100, b:50},
			{y:'Reasoning', a:100, b:80}
		  ],
		  xkey: 'y',
		  ykeys: ['a', 'b'],
		  labels: ['Max Score', 'You Scored']
		});*/
		Morris.Donut({
			  element: 'Visitors',
			  data: [
				{value: 70, label: 'English Ability'},
				{value: 45, label: 'Numerical Ability'},
				{value: 90, label: 'Reasoning Abitlity'}
			  ],
			  backgroundColor: '#fff',
			  labelColor: '#111',
			  colors: [
				'#8E44AD',
				'#2C3E50',
				'#1ABC9C',
				'#D35400'
			  ],
			  formatter: function (x) { return x + "%"},
			  resize:true
		});
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
	exit();
?>