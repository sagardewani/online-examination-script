<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	include_once('../includes/sitedetails.php');
	if($user->is_admin() || isset($_SESSION['islogged']) && isset($_SESSION['status']) && $_SESSION['islogged'] && $_SESSION['status'])
	{
		if($user->is_admin())
		{
			$user = $_POST['user'];
			$id = $_POST['uID'];
		}
		else
		{
			$user = $_SESSION['user'];
			$id = $_SESSION['uID'];
		}
		$query = "SELECT * FROM users WHERE id=:a";
		$stmt = $db->prepare($query);
		$stmt->execute(array(':a'=>$id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$contact = $row['Contact'];
		$email = $row['Email'];
		$dob = $row['DOB'];
				//$_SESSION['slot'] = $row['slot'];
		echo '<!DOCTYPE HTML>
		<html>
		<head>
		<title>User Profile</title>
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
		 <link rel="stylesheet" href="../css/hetrotecheducation.css">
		 <link rel="icon" type="image/x-icon" href='.$site_favicon.'>
		 <!-- JSS -Javascripts!-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }</script>
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
		</head>
		<body>
			<div class="container-fluid">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="background-color:rgba(30, 17, 88, 0.91)!important; color:white;">
					<h3><span class="site-name-font-style">'.$site_logo.'</span></h3>
					<div style="float:right; margin: 15px 20px;">
								<div class="bg-color-white new-box-shadow" style="padding:10px;">
									<div class="block-content"  style="margin:1px; width:85px; height:90px; border: 1px solid gray;">
										<img class="new-box-shadow"  width="75px" height="80px" src="../images/profile.jpg" alt="profile-image"/>
									</div>
									<div style="margin-left:15px; font-size:0.8em">
									<span><a href="#">'.$user.'</a></span></div>
									<input id="userid" type="hidden" value= '.$id.' >
									<input id="username" type="hidden" value= '.$user.' >
								</div>
					</div>
					<div class="col-lg-2 col-md-3 col-sm-4 col-xs-10 full-vh box-show box-visible" style="background-color:rgb(7, 29, 51)!important;" id="sidebar">
					<span><i class="fa fa-bars clickable pull-left box-shadow-round" style="margin:5px 0;" id="sidebar-icon" aria-hidden="true"></i></span>
					<div class="hide" id="sidebar-content" style="padding:20px 1px 10px 10px">		
					<!--SIDEBAR USERPIC -->
						<div class="usr-img center_img">
							<img src="../img/user8.jpg" class="img-circle img-responsive" alt="user_image"/>
						</div>
							<!--SIDEBAR USERTITLE -->
							<div class="profile-usertitle">
								<div class="profile-usertitle-name">'.$user.'</div>
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
										<a href='.$site_contact_us.'>
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
				<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 margin-top-10">
					<div class="container table-responsive">';
						echo "<table id=user_profile class='table table-bordered'>

								<tr class=info>
									<th>Username</th>
									<td>$user</td>
								</tr>
								<tr>
									<th>Email</th>
									<td>$email</td>
								</tr>
								<tr>
									<th>Contact</th>
									<td>$contact</td>
								</tr>
								<tr>
									<th>DOB</th>
									<td>$dob</td>
								</tr>
								<tr><th>Course Enrolled</th><td><table class='table table-bordered'>";
									$query = "SELECT CL.category_name FROM category_list CL INNER JOIN course Co ON CL.id = Co.category_id WHERE Co.users_id = :a";
									$stmt = $db->prepare($query);
									$stmt->execute(array(':a'=>$id));
									$stmt->setFetchMode(PDO::FETCH_ASSOC);
									while($r = $stmt->fetch())
									{
										$course = $r['category_name'];
										echo "
											<tr>
												<td>$course</td>
											</tr>
										";
									}
								echo "
								</table></td></tr>
						</table>
		<script type='text/javascript'>
			$('#sidebar-icon').on('click',function(e){
					e.preventDefault();
					$('#sidebar').toggleClass('box-show box-visible');
					$('#sidebar-content').toggleClass('show hide');
				});
		</script>						
		</body>
		</html>";

		
	}
	else
	{
		header('Location: ../index.php');
	}	
	exit;
?>							