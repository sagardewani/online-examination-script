<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	include_once('../includes/sitedetails.php');
	if($user->is_admin() || isset($_SESSION['islogged']) && isset($_SESSION['status']) && $_SESSION['islogged'] && $_SESSION['status'])
	{
		function timedCount($timeInSeconds)
		{

			$hours = (int)($timeInSeconds / 3600 ) % 24;
			$minutes = (int)($timeInSeconds / 60 ) % 60;
			$result = ($hours < 10 ? "0".$hours : $hours).":".($minutes < 10 ? "0".$minutes : $minutes);
			return $result;
		}
		if($user->is_admin())
		{
			$user = $_POST['user'];
			$id = $_POST['uID'];
		}
		else
		{
			$user = $_SESSION['user'];
			$id = $_SESSION['uID'];
			$status = $_SESSION['status'];
		}
				//$_SESSION['slot'] = $row['slot'];
		echo '<!DOCTYPE HTML>
		<html>
		<head>
		<title>User Area</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		 <link rel="stylesheet" href="../css/hetrotecheducation.css?v=1.0">
		 <link rel="icon" type="image/x-icon" href='.$site_favicon.'>
		 <!-- JSS -Javascripts!-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }</script>
		</head>
		<style>
			html{
				height:100%;
			}
			body{
				height:100vh;
			}	
			.overflow-x{
				overflow-x:overlay;
				overflow-y:visible;
			}
			.full-vh{
				position:fixed;
				z-index:100;
				color:initial;
				
			}
		</style>
		';
?>		
		<body>
			<div class="container-fluid">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:rgba(30, 17, 88, 0.91)!important; color:white;">
					<h3><span class="site-name-font-style"><?php echo $site_logo; ?></span></h3>
					<div style="float:right; margin: 15px 20px;">
								<div class="bg-color-white new-box-shadow" style="padding:10px;">
									<div class="block-content"  style="margin:1px; width:85px; height:90px; border: 1px solid gray;">
										<img class="new-box-shadow"  width="75px" height="80px" src="../images/profile.jpg" alt="profile-image"/>
									</div>
									<div style="margin-left:15px; font-size:0.8em">
									<span><a href="#"><?php echo $user; ?></a></span></div>
									<input id="userid" type="hidden" value= <?php echo $id; ?> >
									<input id="username" type="hidden" value= <?php echo $user; ?> >
								</div>
					</div>
					<div class="col-lg-2 col-md-3 col-sm-4 col-xs-10 full-vh  box-show box-visible" style="background-color:rgb(7, 29, 51)!important;" id="sidebar">
					<span><i class="fa fa-bars clickable pull-left box-shadow-round" style="margin:5px 0;" id="sidebar-icon" aria-hidden="true"></i></span>
					<div class="hide" id="sidebar-content" style="padding:20px 1px 10px 10px">		
					<!--SIDEBAR USERPIC -->
						<div class="usr-img center_img">
							<img src="../img/user8.jpg" class="img-circle img-responsive" alt="user_image"/>
						</div>
							<!--SIDEBAR USERTITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name"><?php echo $user; ?></div>
							</div>
							<div class="profile-userbuttons">
								<a href="profile.php" id="profile"><button type="button" class="btn btn-success btn-sm">Profile</button></a>
								<a href="logout.php"><button type="button" id="logout" class="btn btn-danger btn-sm">SignOut</button></a>
							</div>
							<div class="profile-usermenu">
								<ul class="nav">
									<li class="active">
										<a href="user_area.php">
										<i class="glyphicon glyphicon-home"></i>
										Home </a>
									</li>
									<li>
										<a href="profile.php">
										<i class="glyphicon glyphicon-user"></i>
										Profile </a>
									</li>
									<li>
										<a href=<?php echo $site_contact_us; ?>>
										<i class="fa fa-phone" aria-hidden="true"></i>
										Contact Us </a>
									</li>
									<li>
										<a href="#">
										<i class="fa fa-exclamation-circle" aria-hidden="true"></i>
										New Updates </a>
									</li>
									<li>
										<a href="../notes/user/help.html">
										<i class="glyphicon glyphicon-flag"></i>
										Help </a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				

				<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 margin-top-10 overflow-x">
					<div class="container table-responsive">
						<table id ="paper_available" class="table table-bordered">
							<thead>
								<tr class="info">
									<th>#</th>
									<th>Paper Title</th>
									<th>Duration</th>
									<th>Paper Start At</th>
									<th>Take Exam</th>
									<th>View Result</th>
								</tr>
							</thead>
							<tbody>
						<?php	
							$query = "SELECT C.title,C.time,Co.is_active,Co.slot,C.id,C.category_id,Cl.category_name FROM category C INNER JOIN course Co ON C.category_id = Co.category_id INNER JOIN category_list Cl ON Cl.id=Co.category_id WHERE Co.users_id =:a";
							try{
								$stmt = $db->prepare($query);
								$stmt->execute(array(':a'=>$id));
								$stmt->setFetchMode(PDO::FETCH_ASSOC);
							}
							catch(PDOException $e)
							{
								$error[] = $e->getMessage();
							}
								for($i=1;$r= $stmt->fetch();$i++)
								{	
									$title = $r['title'];
									$time = $r['time'];
									$status = $r['is_active'];
									$slot = $r['slot'];
									if($status)
									{
										$active = "active";
									}
									else
									{
										$active = "inactive";
									}
									$category = $r['category_name'];
									$id = $r['id'];
									$category_id = $r['category_id'];
									echo "<tr>
										<td>$i</td>
										<td>$title</td>
										<td>".timedCount($time)." Hrs</td>
										<td>$slot</td>
										<td><a href=javascript::void(0); onClick=takeExam($id,$category_id); >take</a></td>
										<td><a href=javascript::void(0); onClick=viewResult($id); >view</a></td>
									</tr>";
									
								}
								?>
							</tbody>
						</table>	
				</div>
			</div>
			</div>
			<script>
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
		function takeExam(id,cid){
			$exam_code = id;
			var user_id = $("#userid").val();
					data = {user:user_id,code:$exam_code,course:cid};
					//console.log(data);
					post("instructions.php",data);
		}
		function viewResult(id){
					console.log(id);
					$exam_code = id;
					var user_id = $("#userid").val();
					data = {user:user_id,code:$exam_code};
					//console.log(data);
					post("result.php",data);
		}
			$(function(){
				$("#sidebar-icon").on("click",function(e){
					e.preventDefault();
					$("#sidebar").toggleClass("box-show box-visible");
					$("#sidebar-content").toggleClass("show hide");
				});
			});
			</script>
		</body>
		</html>
<?php
		
	}
	else
	{
		header('Location: ../index.php');
	}	
	exit;
?>