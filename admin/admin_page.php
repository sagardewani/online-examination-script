<?php
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
	echo '<form id="form" class="form-horizontal col-lg-5 col-md-8 col-sm-12 col-xs-12 col-md-offset-2 text-center">
				<fieldset>
						<legend class="bg-color-dark-gray">ADD NEW ADMIN</legend>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="username">Username*</label>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input id="username" class="form-control" placeholder="username" type="text" required="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="firstname">Firstname*</label>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input id="firstname" class="form-control" placeholder="firstname" type="text" required="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="lastname">Lastname*</label>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input id="lastname" class="form-control" placeholder="lastname" type="text" required="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="password">Password*</label>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input id="password" class="form-control" placeholder="password" type="password" required="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="confirm_password">Confirm Password*</label>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input id="confirm_password" class="form-control" placeholder="confirm password" type="password" required="">
							</div>
						</div>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="email">Email*</label>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input id="email" class="form-control" placeholder="example@email.com" type="email" required="">
							</div>
						</div>
						<div class="form-group hide">
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="admin_password">Your Password*</label>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input id="admin_password" class="form-control" placeholder="enter your password" type="password" required="">
							</div>
						</div>
						<!--<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="package">Package</label>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input type="number" id="package" class="form-control" required="">
							</div>
						</div> -->
						<div class="clearfix"></div>
						</br>
						<div class="form-gruop">
							<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-md-offset-4">
								<button type="button" onClick=addAdmin(); class="btn btn-primary btn-block">ADD ADMIN</button>
							</div>
						</div>
					</fieldset>	
				</form>';
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