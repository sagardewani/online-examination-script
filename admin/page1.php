<?php
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');
	if($user->is_logged_in())
	{	
		if($user->is_admin())
		{
			if(!$user->is_blocked())
			{
				echo '<form id="form" class="form-horizontal col-lg-5 col-md-8 col-sm-12 col-xs-12 col-md-offset-3 text-center">
				<fieldset>
						<legend class="bg-color-dark-gray">ADD USERS</legend>
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="username">Username*</label>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input id="username" class="form-control" placeholder="username" type="text" required="">
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
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="contact">Contact*</label>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<div class="input-group">
									<span class="input-group-addon">+91</span>
									<input id="contact" class="form-control" placeholder="12345678XX" s="10" type="text" required="">
								</div>
							</div>	
						</div>
						<!--<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-4 col-xs-4 control-label" for="timing">Slot</label>
							<div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
								<input id="timing" class="form-control" placeholder="timing" type="time" required="">
							</div>
						</div> -->
						<div class="form-group">
							<label class="col-lg-4 col-md-4 col-sm-10 col-xs-10 control-label" >Date of Birth</label>
							<div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
								<select class="form-control" id="month"><option selected="selected" value="0">Month</option><option value="1">Jan</option><option value="2">Feb</option><option value="3">Mar</option><option value="4">Apr</option><option value="5">May</option><option value="6">Jun</option><option value="7">Jul</option><option value="8">Aug</option><option value="9">Sep</option><option value="10">Oct</option><option value="11">Nov</option><option value="12">Dec</option> </select> 
							</div>
							<div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
							<select class=" form-control"  id="day"><option selected="selected" value="0">Day</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option><option value="13">13</option><option value="14">14</option><option value="15">15</option><option value="16">16</option><option value="17">17</option><option value="18">18</option><option value="19">19</option><option value="20">20</option><option value="21">21</option><option value="22">22</option><option value="23">23</option><option value="24">24</option><option value="25">25</option><option value="26">26</option><option value="27">27</option><option value="28">28</option><option value="29">29</option><option value="30">30</option><option value="31">31</option> </select>
							</div>
							<div class="col-lg-2 col-md-3 col-sm-4 col-xs-4">
							<select class=" form-control"  id="year"><option selected="selected" value="0">Year</option><option value="2016">2016</option><option value="2015">2015</option><option value="2014">2014</option><option value="2013">2013</option><option value="2012">2012</option><option value="2011">2011</option><option value="2010">2010</option><option value="2009">2009</option><option value="2008">2008</option><option value="2007">2007</option><option value="2006">2006</option><option value="2005">2005</option><option value="2004">2004</option><option value="2003">2003</option><option value="2002">2002</option><option value="2001">2001</option><option value="2000">2000</option><option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option><option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option><option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option><option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option><option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option><option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option><option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option><option value="1956">1956</option><option value="1955">1955</option><option value="1954">1954</option><option value="1953">1953</option><option value="1952">1952</option><option value="1951">1951</option><option value="1950">1950</option><option value="1949">1949</option><option value="1948">1948</option><option value="1947">1947</option></select>
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
								<button type="button" onClick=addUser(); class="btn btn-primary btn-block">ADD USER</button>
							</div>
						</div>
					</fieldset>	
				</form>';
			}
			else
			{
				echo '<h1 style="color:red !important; font-size:3em;">You are blocked. Please contact Server Administarator</h1>';
			}
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