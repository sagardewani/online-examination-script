<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	include_once('../includes/sitedetails.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
				$username = $_SESSION['username'];
				$firstname = $_SESSION['firstname'];
				$lastname = $_SESSION['lastname'];
				
				echo '<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>'.$site_title_prefix.':Admin Panel</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
		<meta name="keywords" content='.$site_keywords.' >
		<meta name="description" content='.$site_desc.'>
		<meta property="og:title" content='.$site_title_prefix.':Online Portal>
		<meta property="og:url" content='.$site_url.'>
		<meta property="og:description" content='.$site_og_desc.'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Anton|Fjalla+One" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/color.css">
  <link rel="stylesheet" href="../css/hetrotech10.css">
  <link rel="stylesheet" href="../css/hetrotecheducation.css?v1.0">
  <link rel="icon" type="image/x-icon" href='.$site_favicon.'> 

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script src="../js/jquery.blockui.js"></script>';
?>				

  <script src="../js/admin_functions.js"></script>
  
  <script>
	$(function($){
		var selected = $("#searchby option:selected").val();
		// removes highlighting by replacing each em tag within the specified elements with it's content
		function removeHighlighting(highlightedElements){
			highlightedElements.each(function(){
				var element = $(this);
				element.replaceWith(element.html());
			})
		}

		// add highlighting by wrapping the matched text into an em tag, replacing the current elements, html value with it
		function addHighlighting(element, textToHighlight){
			var text = element.text();
			var highlightedText = '<em>' + textToHighlight + '</em>';
			var newText = text.replace(textToHighlight, highlightedText);

			element.html(newText);
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
		$("#searchby").on('change',function(e){
			e.preventDefault();
			selected = $("#searchby option:selected").val();
		});
		$(".view_user").on('click',function(e){
			$self = $(this);
			$id = $self.attr('id');
			$userid = $id.split("_")[2];
			$username = $id.split("_")[3];
			$url = "../user/user_area.php";
			$data = {user:$username,uID:$userid};
			post($url,$data);
		});
		$("#search_user").on('keyup',function(e){
			var filter = $(this).val();
			searchFun(filter,selected);
			
		});
		$("#search_user").on('click',function(){
			if($("#open_search").hasClass('next'))
			{	
				$("#open_search").removeClass("next");
				$("#search_user").blur();
			}
			else
			{
				$("#open_search").addClass("next");
			}
		});
		
		function searchFun(input,selected) {
  // Declare variables 
		  var input, filter, table, tr, td, i;
		  filter = input.toUpperCase();
		  table = document.getElementById("user_entry");
		  tr = table.getElementsByTagName("tr");
		  // Loop through all table rows, and hide those who don't match the search query
		  for (i = 2; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[selected];
			if (td) {
			  if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			  } else {
				tr[i].style.display = "none";
			  }
			} 
		  }
		}
	});
  </script>
</head>
<body class="container-fluid">
	<nav class="navbar navbar-default no-margin">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" id="menu-toggle">
					<i class="fa fa-th-large" aria-hidden="true"></i>
				</button>
				<a class="navbar-brand pull-right" href=<?php echo $site_url;?>><i class="fa fa-rocket fa-4"></i> <?php echo $site_logo;?></a>
			</div>
			<ul class="nav navbar-nav navbar-right" style="margin-right:20px">
				<li>
					<a href="javascript:void(0);" class="usr-small-img dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
						<img src="../img/user8.jpg" alt="" style="margin-right:2px"><span id="admin_username"><?php echo $username; ?></span>
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
		
		<?php
	$query = 'SELECT * FROM hetrotec_exams.users ORDER BY created DESC';
				$ptmt = $db->prepare($query);
				$ptmt->execute();
				$ptmt->setFetchMode(PDO::FETCH_ASSOC);
				$count =0;
				
				echo '<div class="container table-responsive">
							<div class="row">
								<h2><b>View User Details</b></h2>
							</div>
							<table id ="user_entry" class="table table-bordered">
								<thead>
									<tr class="primary">
										<th colspan=5>
										<div class="pull-left search-form">
											<label for="searchby">Search By</label>
											<select id="searchby">
												<option selected value=1>Name</option>
												<option value=2>Email</option>
												<option value=3>Contact</option>
											</select>
										</div>
									<div  class="search-form">
										<div id="open_search" class="form-group has-feedback">
											<label for="search" class="sr-only">Search</label>
											<input type="text" class="form-control" id="search_user" placeholder="search by user details">
											<span class="glyphicon glyphicon-search form-control-feedback"></span>
										</div>
									</div></th>
									</tr>
									<tr class="info">
										<th>#</th>
										<th>Username</th>
										<th>Email</th>
										<th>Contact</th>
										<th>View</th>
									</tr>
								</thead>';
									while($r = $ptmt->fetch())
									{
										$username = $r['Username'];
										$email = $r['Email'];
										$contact = $r['Contact'];
										$id = $r['id'];
										$uinfo = $id."_".$username;
										$count++;
										echo "<tbody>
										<tr>
											<td>$count</td>
											<td>$username</td>
											<td>$email</td>
											<td>$contact</td>
											<td><a href=# id=view_user_$uinfo class=view_user>view</a></td>
										</tr></tbody>";
			
									}
								
				echo '</table></div>';
				?>
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
