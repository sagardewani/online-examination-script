<?php
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
include_once('../includes/sitedetails.php');
	if(!$user->is_logged_in())
	{	
		echo '<!DOCTYPE HTML>
<html>
	<head>
		<title>'.$site_title_prefix.':Online Portal</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
		<meta name="keywords" content='.$site_keywords.' >
		<meta name="description" content='.$site_desc.'>
		<meta property="og:title" content='.$site_title_prefix.':Online Portal>
		<meta property="og:url" content='.$site_url.'>
		<meta property="og:description" content='.$site_og_desc.'>
		 <!--CSS  -Linksheets!-->
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		 <link href="https://fonts.googleapis.com/css?family=Anton|Fjalla+One" rel="stylesheet">
		 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
		 <link rel="stylesheet" href="../css/color.css">
		 <link rel="stylesheet" href="../css/hetrotech10.css">
		 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

		 <link rel="icon" type="image/x-icon" href='.$site_favicon.'>
		 <link rel="stylesheet" href="../css/hetrotecheducation.css">
		 <!-- JSS -Javascripts!-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="../js/jquery.blockui.js"></script>';
?>

		<script>
			$(function($){
				
				var m_modal = $('#msgBox'),
					m_body= $("#msgText"),
					m_title = $('#msgTitle');
			$('#signin').on('click',function(e){
				e.preventDefault();
				$user = $('#username');
				$pass = $('#password');
				$user_val = $user.val();
				$pass_val = $pass.val();
				if($user_val == null || $user_val == "")
				{
					alert('Insert username');
					return false;
				}
				else if($pass_val == null || $pass_val == "")
				{
					alert('Insert password');
					return false;
				}
				var loginData = {user:$user_val, pass:$pass_val};
				$.ajax({
					url:'processAdminLogin.php',
					type:'POST',
					dataType:'JSON',
					data: {login:loginData},
					beforeSend: function(){
						$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
					},
					complete:function(){
						$.unblockUI();
					},
					success:function(res){
						$.unblockUI();
						if(res['response'] == 1)
						{
							var i = setTimeout(page(res['url']),5000);
						}
						else if(res['response'] == -1)
						{
							m_body.html('<p class="text-color-text-red">Username and Password does not matched.</p>');
							m_modal.modal('show');
						}
						//console.log(JSON.stringify(res));
					},
					error: function(err){
						$.unblockUI();
						m_body.html('<p class="text-color-text-red">Some Error Occured.</p>');
						m_modal.modal('show');
						console.log(JSON.stringify(err));
					}
				});
			});
			function page(url)
			{
				window.location = url; // Members Area
			}
			});
		</script>
	</head>
	<body class="container-fluid" id="disablebody">
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
		<div class="bg-color-blue" style="height:100px;">
		</div>
		<div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-color-dark-grey">
				<h2>System Number</h2>
				<h3>SUPER-USER</h3>
				<h4 class="text-center text-color-text-blue" style="font-weight:bold; font-size:2em;"><?php echo $site_title_prefix; ?> SUPER USER LOGIN</h4>
			</div>
		</div>
		<div class="clearfix"></div>
		</br>
		<form class="form-horizontal bg-color-light-gray col-md-4 col-md-offset-4 text-center">

			<div class="form-group text-center">
				<legend><a href="../" alt="user login">USER LOGIN</a></legend>
			</div>	
			<div class="form-group">
				<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="username" class="form-control" placeholder="username" type="text" required="">
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="password" class="form-control" placeholder="*****" type="password" required="">
					</div>
				</div>
			</div>
			<div class="form-gruop">
				<div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 col-md-offset-1">
					<button type="button" id="signin" class="btn btn-primary btn-block">Sign In</button>
				</div>
			</div>
			<div class="clearfix"></div>
			</br>
		</form>
	</body>
</html>	
<?php
	}
	else
	{
		header('Location: logout.php');
	}
	exit;
?>	