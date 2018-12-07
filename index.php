<?php
	include_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'includes/config.php');
	if(isset($_SESSION['islogged']) && $_SESSION['islogged'])
	{
		header('Location: user/user_area.php');
	}
	else
	{
		include_once('includes/sitedetails.php');
	echo '<!DOCTYPE HTML>
<html>
	<head>
		<title>'.$site_title_prefix.':Online Portal</title>
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
		 <link rel="stylesheet" href="css/color.css">
		 <link rel="stylesheet" href="css/hetrotech10.css">
		 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		 
		 <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
		 <link href="css/keyboard.css" rel="stylesheet">
		 <link rel="icon" type="image/x-icon" href='.$site_favicon.'>
		 <link rel="stylesheet" href="css/hetrotecheducation.css">
		 <!-- JSS -Javascripts!-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
		<script src="js/jquery.keyboard.js"></script>
		<script src="js/jquery.keyboard.extension-typing.js"></script>
		<script src="js/jquery.blockui.js"></script>';	
	?>	

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
			$(function($){
				
				var m_modal = $('#msgBox'),
					m_body= $("#msgText"),
					m_title = $('#msgTitle');
			$('body').bind("cut copy paste contextmenu selectstart",function(e) {
				e.preventDefault();
			});		
			$('#username')
				.keyboard({
					lockInput: true, // prevent manual keyboard entry
					layout: 'custom',
					customLayout: {
					'normal': [
						'` 1 2 3 4 5 6 7 8 9 0 - = {bksp}',
						' q w e r t y u i o p [ ] \\',
						'a s d f g h j k l ; \' {enter}',
						'{shift} z x c v b n m , . / {shift}',
						'{accept} {space} {left} {right} {cancel}'
					],
					'shift': [
						'~ ! @ # $ % ^ & * ( ) _ + {bksp}',
						' Q W E R T Y U I O P { } |',
						'A S D F G H J K L : " {enter}',
						'{shift} Z X C V B N M &lt; &gt; ? {shift}',
						'{accept} {space} {left} {right} {cancel}'
					]
				}
				})
				.addTyping({
				showTyping : false,
				lockTypeIn : true,
				delay      : 250
			});
			$('#password')
				.keyboard({
					lockInput: true, // prevent manual keyboard entry
					layout: 'custom',
					customLayout: {
					'normal': [
						'` 1 2 3 4 5 6 7 8 9 0 - = {bksp}',
						' q w e r t y u i o p [ ] \\',
						'a s d f g h j k l ; \' {enter}',
						'{shift} z x c v b n m , . / {shift}',
						'{accept} {space} {left} {right} {cancel}'
					],
					'shift': [
						'~ ! @ # $ % ^ & * ( ) _ + {bksp}',
						' Q W E R T Y U I O P { } |',
						'A S D F G H J K L : " {enter}',
						'{shift} Z X C V B N M &lt; &gt; ? {shift}',
						'{accept} {space} {left} {right} {cancel}'
					]
				}
				})
				.addTyping({
				showTyping : false,
				lockTypeIn : true,
				delay      : 250
			}); 
			$('#u_click').on('click',function(e){
				e.preventDefault();
				var kb = $('#username').getkeyboard();
				kb.reveal();
			});
			$('#p_click').on('click',function(e){
				e.preventDefault();
				var kb = $('#password').getkeyboard();
				kb.reveal();
			});
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
					url:'user/processLogin.php',
					type:'POST',
					dataType:'JSON',
					data: {login:loginData},
					beforeSend: function(){
						$.blockUI({ message: '<div class="loader"></br></div><p>Processing...</p>' });
					},
					success:function(res){
						if(res['response'] == 1)
						{
							$.blockUI({ message: '<div class="loader col-center"></div>'+res['msg']});
							var x=setTimeout(function(){page(res['url']);},3000);
						}
						else if(res['response'] == 2)
						{
							$.unblockUI();
							m_body.html('<p class="text-color-text-red">Username does not exists</p>');
							m_modal.modal('show');

						}
						else if(res['response'] == 3)
						{
							$.unblockUI();
							m_body.html('<p class="text-color-text-red">Username and Password does not match</p>');
							m_modal.modal('show');
						}
						else
						{
							$.unblockUI();
							m_body.html('<p class="text-color-text-red">Strange error occured</p>');
							m_modal.modal('show');
						}
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
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 bg-color-dark-grey">
				<h2>System Number</h2>
				<h3>C0-03</h3>
				<h4 class="text-center text-color-text-blue" style="font-weight:bold; font-size:2em;"><?php echo $site_title_prefix; ?> EXAM PORTAL</h4>
			</div>

		<div class="clearfix"></div>
		</br>
		<form class="form-horizontal bg-color-light-gray col-md-4 col-md-offset-4 text-center">

			<div class="form-group text-center">
				<legend><a href="admin/" alt="admin login">ADMIN LOGIN</a></legend>
			</div>	
			<div class="form-group">
				<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
						<input id="username" class="form-control" placeholder="username" type="text" required="">
						<span class="input-group-addon clickable" id="u_click" ><i  class="fa fa-keyboard-o"></i></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 col-md-offset-1">
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
						<input id="password" class="form-control" placeholder="*****" type="password" required="">
						<span class="input-group-addon clickable" id="p_click"><i  class="fa fa-keyboard-o"></i></span>
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
	exit;
?>		