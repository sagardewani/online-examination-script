<?php
	require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	include_once('../includes/sitedetails.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
		$query = 'SELECT count(id) as admins FROM hetrotec_exams.admins';
		$stmt=$db->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$admins = $row['admins'];
		$query = 'SELECT count(id) as users FROM hetrotec_exams.users';
		$stmt=$db->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$users = $row['users'];
		$query = 'SELECT count(is_active) as inactive FROM hetrotec_exams.users WHERE is_active = 0';
		$stmt=$db->prepare($query);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$inactive = $row['inactive'];
		
		$ip = $_SESSION['IP'];
		$username = $_SESSION['username'];
		$firstname = $_SESSION['firstname'];
		$lastname = $_SESSION['lastname'];
		
		echo '<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>'.$site_title_prefix.':Admin Panel</title>
  <META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="keywords" content='.$site_keywords.' >
		<meta name="description" content='.$site_desc.'>
		<meta property="og:title" content='.$site_title_prefix.':Online Portal>
		<meta property="og:url" content='.$site_url.'>
		<meta property="og:description" content='.$site_og_desc.'>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <link href="https://fonts.googleapis.com/css?family=Anton|Fjalla+One" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/color.css">
  <link rel="stylesheet" href="../css/hetrotech10.css">
  <link rel="stylesheet" href="../css/hetrotecheducation.css">
   <link rel="icon" type="image/x-icon" href='.$site_favicon.'> 

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

 <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
 <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
  <script src="../js/jquery.blockui.js"></script>';

?>


<script>

</script>
  <script>
  
 
 
     function initMenu() {
		// console.log("init");
      $('#menu ul').hide();
      $('#menu ul').children('.current').parent().show();
      //$('#menu ul:first').show();
      $('#menu li a').click(
        function() {
          var checkElement = $(this).next();
          if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
			  //$('#menu ul:visible').find("span.fa-chevron-down").removeClass('fa-chevron-down').addClass('fa-chevron-up');
			  $(this).find("span.fa-chevron-up").removeClass('fa-chevron-up').addClass('fa-chevron-down');
			  checkElement.slideUp('normal');
            return false;
            }
          if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
			 $(this).find("span.fa-chevron-down").removeClass('fa-chevron-down').addClass('fa-chevron-up');
           // $('#menu ul:visible').slideUp('normal');
            checkElement.slideDown('normal');
            return false;
            }
          }
        );
      }
  
	function loadjscssfile(filename, filetype){
    if (filetype=="js"){ //if filename is a external JavaScript file
        var fileref=document.createElement('script')
        fileref.setAttribute("type","text/javascript")
        fileref.setAttribute("src", filename)
    }
    if (typeof fileref!="undefined")
        document.getElementsByTagName("head")[0].appendChild(fileref)
}

//dynamically load and add this .js file

function removejscssfile(filename, filetype){
    var targetelement=(filetype=="js")? "script" : (filetype=="css")? "link" : "none" //determine element type to create nodelist from
    var targetattr=(filetype=="js")? "src" : (filetype=="css")? "href" : "none" //determine corresponding attribute to test for
    var allsuspects=document.getElementsByTagName(targetelement)
    for (var i=allsuspects.length; i>=0; i--){ //search backwards within nodelist for matching elements to remove
    if (allsuspects[i] && allsuspects[i].getAttribute(targetattr)!=null && allsuspects[i].getAttribute(targetattr).indexOf(filename)!=-1)
        allsuspects[i].parentNode.removeChild(allsuspects[i]) //remove element by calling parentNode.removeChild()
    }
}
function getParameterByName(name, url) {
				if (!url) {
					url = window.location.href;
				}
				name = name.replace(/[\[\]]/g, "\\$&");
				var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
				results = regex.exec(url);
				if (!results) return null;
				if (!results[2]) return '';
				return decodeURIComponent(results[2].replace(/\+/g, " "));
			}
	$(function(){
	/*var m_modal = $('#msgBox'),
					m_body= $("#msgText"),
					m_title = $('#msgTitle');*/
					initMenu();

		
		
		
		 $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled-2");
    });
     $("#menu-toggle-2").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled-2");
        $('#menu ul').hide();
    });	

		$('#addusernavigation').on('click',function(e){
			e.preventDefault();	
			$self = this;
			$.ajax({
				url:'page1.php',
				cache:false,
				beforeSend: function(){
					$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
				},
				success: function(data){
					$.unblockUI();
					$('#pages').html(data);
					changeActiveElement($self);
				}
			});
		});
		$('#papereditor').on('click',function(e){
			e.preventDefault();
			$self = this;
			$.ajax({
				url:'page2.php',
				cache:false,
				beforeSend: function(){
					$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
				},
				success: function(data){
					$.unblockUI();
					$('#pages').html(data);
					changeActiveElement($self);
				}
			});
		});
		$('#activateusers').on('click',function(e){
			e.preventDefault();
			$self = this;
			$.ajax({
				url:'page4.php',
				cache:false,
				beforeSend: function(){
					$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
				},
				success: function(data){
					$.unblockUI();
					$('#pages').html(data);
					changeActiveElement($self);
				}
			});
		});
		$('#addcourse').on('click',function(e){
			e.preventDefault();
			$self = this;
			$.ajax({
				url:'page5.php',
				cache:false,
				beforeSend: function(){
					$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
				},
				success: function(data){
					$.unblockUI();
					$('#pages').html(data);
					changeActiveElement($self);
				}
			});
		});
		$('#activatecourse').on('click',function(e){
			e.preventDefault();
			$self = this;
			$.ajax({
				url:'page6.php',
				cache:false,
				beforeSend: function(){
					$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
				},
				success: function(data){
					$.unblockUI();
					$('#pages').html(data);
					changeActiveElement($self);
				}
			});
		});
		$('#addnewadmin').on('click',function(e){
			e.preventDefault();
			$self = this;
			$.ajax({
				url:'admin_page.php',
				cache:false,
				beforeSend: function(){
					$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
				},
				success: function(data){
					$.unblockUI();
					$('#pages').html(data);
					changeActiveElement($self);
				}
			});
		});
		$('#viewadmin').on('click',function(e){
			e.preventDefault();
			$self = this;
			$.ajax({
				url:'page7.php',
				cache:false,
				beforeSend: function(){
					$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
				},
				success: function(data){
					$.unblockUI();
					$('#pages').html(data);
					changeActiveElement($self);
				}
			});
		});
		$('#showpapers').on('click',function(e){
			e.preventDefault();
			$self = this;
			$.ajax({
				url:'page8.php',
				cache:false,
				beforeSend: function(){
					$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
				},
				success: function(data){
					$.unblockUI();
					$('#pages').html(data);
					changeActiveElement($self);
				}
			});
			
		});
		function changeActiveElement(element)
		{
			$(".tab-main").removeClass("active");
			$(".tab").removeClass("active");
			$(element).addClass("active");
		}
		
		/*$('#questionLayout').on('click',function(e){
			e.preventDefault();
			var c = getParameterByName('c');
			var d = getParameterByName('lang');
			var f = getParameterByName('set');
			var dataString = "c="+c+"&lang="+d+"&set="+f;
			$.ajax({
				url:'page3.php',
				type:'POST',
				data: dataString,
				cache:false,
				success: function(data){
					loadjscssfile("../js/functions_page3.js", "js");
					removejscssfile("../js/functions_page2.js?v=1.0","js");
					removejscssfile("../js/functions.js","js");
					$('#pages').html(data);
				}
			});
		});*/

	});
	
			function openNav(){
			document.getElementById("sideNav").style.width = "250px";
		}
		function closeNav()
		{
			document.getElementById("sideNav").style.width = "0";
		}
  </script>
  <style>
  .block-content{
				margin-bottom:10px;
				padding: 5px;
				border: 2px solid black;
				border-radius: 2px;
				-webkit-border-radius:2px;
				-moz-border-radius:2px;
			}
			.box-shadow{
				margin-bottom:2px;
				padding: 5px;
				box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
				-webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
				-mozbox-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
				background-color: rgb(73, 121, 110);
			}
  </style>
</head>
<body>
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
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="active">
						<button class="navbar-toggle collapse in" data-toggle="collapse" id="menu-toggle-2">
							<i class="fa fa-th-large" aria-hidden="true"></i>
						</button>
					</li>		
				</ul>
			</div>
		</nav>
		<div id="wrapper">
			<div class="sidebar-wrapper">
				<ul class="sidebar-nav nav-pills nav-stacked" id="menu">
					<li class="text-color-text-light-grey" align=center>
						<div style="background-color:rgb(166, 22, 12)">
						<span>ADMIN: </span>
						<span>CONTROLS</span>
						</div>
						<div class=" usr-img" style="margin: 12px 0 20px 4px; ">
							<img src="../img/user8.jpg" class="img-circle">
						</div>
						<div class="bg-color-black margin-4-10">		
							<span style="margin-left:2px;">WELCOME </span>
							<span style="margin-left:2px;"><?php echo $firstname." ".$lastname ; ?></span>
						</div>	
					</li>
					<li class="active tab" id="dashboard">
						<a href="mainpanel.php"><span class=" fa-stack fa-lg pull-left"><i class="fa fa-dashboard  fa-stack-1x"></i></span>Dashboard</a>
					</li>
					<li id="papereditor" class="tab">
						<a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-pencil-square fa-stack-1x"></i></span>Paper Editor</a>
					</li>
					<li id="add">
						<a href="#"><span class="fa-stack fa-lg  pull-left"><i class="fa fa-plus fa-stack-1x "></i></span>Add<span class="fa fa-chevron-down pull-right icon-right"></span></a>
						<ul class="nav-pills nav-stacked" style="list-style-type:none;">							
							<li id="addcourse" class="tab"><a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-book icon-right"></i></span>User Courses</a></li>
							<li id="addusernavigation" class="tab"><a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-user icon-right" aria-hidden="true"></i></span>User</a></li>
							<li id="addnewadmin" class="tab"><a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-user-secret icon-right"></i></span>Admins</a></li>
						</ul>
					</li>
					<li id="view">
						<a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-eye fa-stack-1x"></i></span>View<span class="fa fa-chevron-down pull-right icon-right"></span></a>
						<ul class="nav-pills nav-stacked" style="list-style-type:none;">
							<li id="showpapers" class="tab"><a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-file-text icon-right"></i></span>Papers</a></li>
							<li id="viewadmin" class="tab"><a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-user-secret icon-right"></i></span>Admins</a></li>
							<li id="viewuser" class="tab"><a href="viewuser.php"><span class="fa-stack fa-lg pull-left"><i class="fa fa-user icon-right"></i></span>User</a></li>
						</ul>
					</li>
					<li id="activate">
						<a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-power-off fa-stack-1x"></i></span>Activate<span class="fa fa-chevron-down pull-right icon-right"></span></a>
						<ul class="nav-pills nav-stacked" style="list-style-type:none;">
							<li id="activatecourse" class="tab"><a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-book icon-right"></i></span>User Courses</a></li>
							<li id="activateusers" class="tab"><a href="#"><span class="fa-stack fa-lg pull-left"><i class="fa fa-user icon-right"></i></span>Users</a></li>
						</ul>
					</li>	
				</ul>
			</div>
			<div id="page-content-wrapper">
				<div class="container-fluid min-width-320">
						<div id="pages">
							<section class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 admin-box-shadow">
								<i class="fa fa-user"></i>
								<span class="admin-box-header">Total Users</span>
								<div class="admin-box-text"><?php echo $users; ?></div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 admin-box-shadow">
								<i class="fa fa-user"></i>
								<span class="admin-box-header">Total Admins</span>
								<div class="admin-box-text"><?php echo $admins; ?></div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 admin-box-shadow">
								<i class="fa fa-user"></i>
								<span class="admin-box-header">active Users</span>
								<div class="admin-box-text"><?php echo $inactive; ?></div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 admin-box-shadow">
								<i class="fa fa-user"></i>
								<span class="admin-box-header">Inactive Users</span>
								<div class="admin-box-text"><?php echo ($users-$inactive); ?></div>
							</div>
							</section>
							
							<br>
							<section class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 admin-graph-margin">
								<div id="NewUsers" style="height:350px;"></div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 admin-graph-margin">
								<div id="UserActivity" style="height:350px;"></div>
							</div>
							</section>
							<section class="col-md-12 col-sm-12 col-xs-12">
							<div class="col-lg-4 col-md-4 col-sm-12 col-xm-12 margin-4-10" style="margin-top:20px;">
								<legend>Today's Visitors</legend>
								<div id="Visitors" style="height:230px;"></div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 margin-4-10" style="margin-top:20px;">
								<legend>New Updates</legend>
								<div id="Updates">
									<ul class="news-ul">
										<li><i class="fa fa-exclamation-circle" aria-hidden="true"></i><span>Student list has been updated</span></li>
										<li><i class="fa fa-exclamation-circle" aria-hidden="true"></i><span>New Paper has been added</span></li>
										<li><i class="fa fa-exclamation-circle" aria-hidden="true"></i><span>John Smith has registered 4hours ago</span></li>
										<li><i class="fa fa-exclamation-circle" aria-hidden="true"></i><span>5 candidates scored more than 90%</span></li>
										<li><i class="fa fa-exclamation-circle" aria-hidden="true"></i><span>User Interface is improved</span></li>
									</ul>
								</div>
							</div>
							</section>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xm-12 admin-graph-margin">
							</div>
						</div>
				</div>
			</div>
		</div>
		<script>
			var d = new Date();
			var date = d.getDate().toString();
			console.log(date);

			Morris.Area({
			  element: 'NewUsers',
			  behaveLikeLine: true,
			  data: [
				{x: '2011 Q1', y: 3, z: 3},
				{x: '2011 Q2', y: 2, z: 1},
				{x: '2011 Q3', y: 2, z: 4},
				{x: '2011 Q4', y: 3, z: 3}
			  ],
			  xkey: 'x',
			  ykeys: ['y', 'z'],
			  labels: ['Y', 'Z']
			});
			Morris.Bar({
			  element: 'UserActivity',
			  data: [
				{x: '2011 Q1', y: 3, z: 2, a: 3},
				{x: '2011 Q2', y: 2, z: null, a: 1},
				{x: '2011 Q3', y: 0, z: 2, a: 4},
				{x: '2011 Q4', y: 2, z: 4, a: 3}
			  ],
			  xkey: 'x',
			  ykeys: ['y', 'z', 'a'],
			  labels: ['Y', 'Z', 'A']
			}).on('click', function(i, row){
			  console.log(i, row);
			});
			Morris.Donut({
			  element: 'Visitors',
			  data: [
				{value: 70, label: 'foo'},
				{value: 15, label: 'bar'},
				{value: 10, label: 'baz'},
				{value: 5, label: 'A really really long label'}
			  ],
			  backgroundColor: '#fff',
			  labelColor: '#111',
			  colors: [
				'#0BA462',
				'#39B580',
				'#67C69D',
				'#95D7BB'
			  ],
			  formatter: function (x) { return x + "%"}
			});
		</script>
		  <script src="../js/admin_functions.js"></script>
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
