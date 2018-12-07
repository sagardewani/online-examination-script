	var m_modal = $('#msgBox'),
					m_body= $("#msg"),
					m_title = $('#msgTitle'),
					m_footer = $('#msgFotter');
					//m_body.html("");
				
		var lastValue = $('#category option:last-child').val();	
		var count = parseInt(lastValue)+1;
		//admin functions
		function addCategory()
		{
				$('#new_category_box').removeClass('hide');
		}
		function cancelBtn()
		{
			$('#new_category_name').val('');
			$('#new_category_box').addClass('hide');
		}
		function addBtn()
				{
					var new_category = $('#new_category_name');
					var	new_category_val = new_category.val();
					var m_title_val = m_title.html('Add New Category');
						if(!new_category_val || new_category_val == "" || new_category_val == null || new_category_val.length < 1)
						{
							m_body.html('<p class="text-color-text-red">Please provide the Category name.</p>');
							m_modal.modal('show');	
							return false;
						}
						else if($('#category option:contains('+new_category_val.trim().toUpperCase()+')').length > 0)
						{
							m_body.html('<p class="text-color-text-red">Specified Category already exist. Please add another Category.</p>');
							m_modal.modal('show');	
							return false;
						}	
						else{
							var data={category_name:new_category_val};
							$.ajax({
							url: 'addNewCategory.php',
							type:'POST',
							dataType:'JSON',
							cache:false,
							data: {data:data},
							beforeSend: function(){
								$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
							},
							success: function(data){
								$.unblockUI();
								if(data["response"] == 1)
								{
									$('#new_category_box').addClass('hide');
									m_body.html('<p class="text-color-text-green">Category Added Sucessfully!</p>');
									  m_modal.modal('show');
									$('#category').append('<option value='+count+'>'+new_category_val.toUpperCase()+'</option>');
									count++;
								}
								else
								{
									m_body.html('<p class="text-color-text-red">Category Not Added Sucessfully!</p>');
									m_modal.modal('show');
									console.log(JSON.stringify(data));
								}	//$('#category').append('<option value='+count+'></option>');
							},
							error: function(err){
								$.unblockUI();
								if(data["response"] == 1)
								{
									$('#new_category_box').addClass('hide');
									m_body.html('<p class="text-color-text-yellow">Category Added Sucessfully!</br>But some error occured</p>');
									m_modal.modal('show');
									$('#category').append('<option value='+count+'>'+new_category_val.toUpperCase()+'</option>');
									count++;
								}
								else
								{
									m_body.html('<p class="text-color-text-red">Category Not Added Sucessfully!</br>Some Error occured.</p>');
									m_modal.modal('show');
								}
								console.log(JSON.stringify(err));
							}
						});
							new_category.val('');
						}
				}
						function selectCancel(){
			$('#paper_details')[0].reset();
		}
		function selectNext()
		{
					var category = $('#category option:selected'),
						language = $('#language option:selected'),
						minutes = $('#minutes'),
						title = $('#paper_title'),
						questions = $('#paper_questions');
						//set = $('#paper_set');
					var num_regEx = /^[0-9]*$/;
					var category_val = category.val(),
						language_val = language.val(),
						minutes_val = minutes.val(),
						title_val = title.val(),
						questions_val = questions.val();
						//set_val = set.val();
					var m_title_val = m_title.html('Paper Response');
					if(category_val == 0)
					{	
						m_body.html('<p class="text-color-text-red">Category is not selected.</p>');
						m_modal.modal('show');
						category.focus();
						return false
					}
					else if(!language_val)
					{
						m_body.html('<p class="text-color-text-red">Language is not specified.</p>');
						m_modal.modal('show');
						return false;
					}
					else if(title_val == null || title_val == "" || title_val.length < 2)
					{
						m_body.html('<p class="text-color-text-red">title must be set and must be more than 1 character.</p>');
						m_modal.modal('show');
						title.focus();
						return false;
					}
					else if(questions_val == null || questions_val < 1)
					{
						m_body.html('<p class="text-color-text-red">Please provide total no. of questions in question paper.</p>');
						m_modal.modal('show');
						questions.focus();
						return false;
					}
					else if(!num_regEx.test(questions_val))
					{
						m_body.html('<p class="text-color-text-red">Please Enter only integer value(eg: 123)</p>');
						m_modal.modal('show');
						questions.focus();
						return false;
					}
					else if(!minutes_val || minutes_val==null || minutes_val < 1)
					{
						m_body.html('<p class="text-color-text-red">Please provide correct time duration in minutes of the paper.</p>');
						m_modal.modal('show');
						return false;
					}
					else if(!num_regEx.test(minutes_val))
					{
						m_body.html('<p class="text-color-text-red">Please provide time duration in minutes only(eg: 123)</p>');
						m_modal.modal('show');
						return false;
					}
					else
					{
						var total_minutes_val = minutes_val % 60,
						total_hours_val = parseInt(minutes_val/60);
						
						var JSONObject = {
							category:category.text(),
							language:language_val,
							time: minutes_val,
							title:title_val,
							questions:questions_val
							//set:set_val
						};
						//console.log(data);
						$.ajax({
							url:'processDetails.php',
							type:'POST',
							dataType:'JSON',
							data: {form:JSONObject},
							cache:false,
							beforeSend: function(){
								$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
								//Show loader col-center
							},
							complete: function(res){
								$.unblockUI();
								//Requested successfully !
								//console.log(JSON.stringify(res));
							},
							error: function(err){
								$.unblockUI();
								m_body.html('<p class="text-color-text-red">Some Error Occured!</p>');
								m_modal.modal('show');
								console.log(JSON.stringify(err));
								//alert(JSON.stringify(err));
							},
							success:function(res){
								$.unblockUI();
								//alert(JSON.stringify(res));
								//console.log(JSON.stringify(res));
								if(res['response'] == 10)
								{
									m_body.html('<p class="text-color-text-green">'+JSON.stringify(res[0])+'</p>');
									m_modal.modal('show');
									console.log(JSON.stringify(res['url']));
									var i = setTimeout(page(res['url']),5000);
									
								}
								else
								{
									m_body.html('<p class="text-color-text-red">'+JSON.stringify(res[0])+'</p>');
									m_modal.modal('show');
								}	
							},
							timeout:15000
							
						});
					}
					
				}
		function addAdmin()
		{
			var admin_user = $('#admin_username');
			var username=$('#username'),
				email = $('#email'),
				password = $('#password'),
				c_password = $('#confirm_password'),
				f_name = $('#firstname'),
				l_name = $('#lastname');

			var admin_user_val = admin_user.text();
			var user_val = username.val(),
				email_val = email.val(),
				pass_val = password.val(),
				c_pass_val = c_password.val(),
				//slot_val = slot.val(),
				f_name_val = f_name.val(),
				l_name_val = l_name.val();
				//category_val = category.val();
				
				//console.log(f_name_val,l_name_val);
				
			var emailRegex = /^[Aa-z0-9._]*\@[A-Za-z]*\.[A-Za-z]{2,5}$/;
			var illegal = /\W/;
			var forbid = /^[a-zA-Z]*$/;	
			var m_title_val = m_title.html('Attention!!!');
			if(user_val == null || user_val.length < 1 || user_val == "")
			{
				m_body.html('<p class="text-color-text-red">Please Enter Correct Username.</p>');
				m_modal.modal('show');
				return false;
			}
			else if(f_name_val == null || f_name_val.length < 1 || f_name_val == "" || !forbid.test(f_name_val))
			{
				m_body.html('<p class="text-color-text-red">Please Enter Correct Firstname.</p>');
				m_modal.modal('show');
				return false;
			}
			else if(l_name_val == null || l_name_val.length < 1 || l_name_val == "" || !forbid.test(l_name_val))
			{
				m_body.html('<p class="text-color-text-red">Please Enter Correct Lastname.</p>');
				m_modal.modal('show');
				return false;
			}
			else if(pass_val == null || pass_val.length < 1 || pass_val == "")
			{
				m_body.html('<p class="text-color-text-red">Please Do not enter empty password.</p>');
				m_modal.modal('show');
				return false;
			}
			else if(c_pass_val == null || c_pass_val.length < 1 || c_pass_val == "" || c_pass_val !=pass_val)
			{
				m_body.html('<p class="text-color-text-red">Password Do not matches.</p>');
				m_modal.modal('show');
				return false;
			}
			else if(email_val == null || !emailRegex.test(email_val))
			{
				m_body.html('<p class="text-color-text-red">Please Enter Correct Email Address</br>(Format: example@email.com).</p>');
				m_modal.modal('show');
				return false;
			}
			else
			{
				m_title.html("<h3>Enter Password</h3>");
				m_body.html('<input class="form-control" id="admin_pass" type="password" placeholder="admin password..."/>');
				m_footer.html('<button class="btn btn-success btn-default pull-left" id="admin_msgOK" data-dismiss="modal">Submit</button>\
								<button class="btn btn-danger btn-default pull-right" id="admin_msgCancel" data-dismiss="modal">Cancel</button>');
				m_modal.modal('show');
				return true;
			}
		}
		function addUserCourse()
		{
			var user = $('#username'),
				category = $('#category option:selected'),
				slot = $('#timing'),
				pack = $('#package');
				
			var user_val = user.val(),
				category_val = category.val(),
				slot_val = slot.val(),
				pack_val = pack.val();
				var m_title_val = m_title.html('Attention!!!');
			if(user_val == "" || user_val == null)
			{
				m_body.html('<p class="text-color-text-red">Please enter username</p>');
				m_modal.modal('show');
				return false;
			}
			else if(category_val == 0)
			{	
				m_body.html('<p class="text-color-text-red">Category is not selected.</p>');
				m_modal.modal('show');
				return false;
			}
			else if(slot_val == null || slot_val == "")
			{
				m_body.html('<p class="text-color-text-red">Please Select a slot timing</p>');
				m_modal.modal('show');
				return false;
			}
			else if(pack_val < 1)
			{
				m_body.html('<p class="text-color-text-red">Please Enter Correct Package validity.</br>Must be greater than 0.</p>');
				m_modal.modal('show');
				return false;
			}
			else
			{
				var dataObject = { user:user_val,category:category_val,slot:slot_val,pack:pack_val};
				$.ajax({
					url: 'processUserCourse.php',
					type:'POST',
					dataType:'JSON',
					cache:false,
					data: {course:dataObject},
					beforeSend: function(){
						$.blockUI({ message: '<div class="loader"></br></div><p>Processing...</p>' });
					},
					success: function(res){
						$.unblockUI();
						if(res['response'] == 1)
						{
							m_body.html('<p class="text-color-text-green">User is added to the Course.</p>');
							m_modal.modal('show');
							$('form')[0].reset();
						}
						else if(res['response'] == 2)
						{
							m_body.html('<p class="text-color-text-red">Username does not exist.</br>Please add the user first.</p>');
							m_modal.modal('show');	
						}
						else if(res['response'] == -3)
						{
							m_body.html('<p class="text-color-text-red">User already added to the course.</p>');
							m_modal.modal('show');
						}	
						else
						{
							m_body.html('<p class="text-color-text-red">Some Successive Error Occured</p>');
							m_modal.modal('show');
							console.log(JSON.stringify(res['error']));
						}
						
					},
					error: function(res){
					$.unblockUI();
						if(res['response'] == 1)
						{
							m_body.html('<p class="text-color-text-red">User is added to the Course.</br>But some error occured.</p>');
							m_modal.modal('show');
						}
						else
						{
							m_body.html('<p class="text-color-text-red">Some Error Occured</p>');
							m_modal.modal('show');
						}
						console.log(JSON.stringify(res));						
					}
				});
			}
		}
		function addUser()
		{
			var username=$('#username'),
				email = $('#email'),
				password = $('#password'),
				c_password = $('#confirm_password'),
				//slot = $('#timing'),
				day = $('#day'),
				month = $('#month'),
				year = $('#year'),
				//pack = $('#package'),
				contact = $('#contact');
				//category = $('#category');
			
			var user_val = username.val(),
				email_val = email.val(),
				pass_val = password.val(),
				c_pass_val = c_password.val(),
				//slot_val = slot.val(),
				day_val = day.val(),
				month_val = month.val(),
				year_val = year.val(),
				//pack_val = pack.val();
				con_val = contact.val();
				//category_val = category.val();
				
				//console.log(slot_val);
				
			var emailRegex = /^[Aa-z0-9._]*\@[A-Za-z]*\.[A-Za-z]{2,5}$/;
			var phoneno = /^([0-9]{10})$/;
			var illegal = /\W/;
			var forbid = /^[a-zA-Z]*$/;	
			var m_title_val = m_title.html('Attention!!!');
			if(user_val == null || user_val.length < 1 || user_val == "")
			{
				m_body.html('<p class="text-color-text-red">Please Enter Correct Username.</p>');
				m_modal.modal('show');
				return false;
			}
			else if(pass_val == null || pass_val.length < 1 || pass_val == "")
			{
				m_body.html('<p class="text-color-text-red">Please Do not enter empty password.</p>');
				m_modal.modal('show');
				return false;
			}
			else if(c_pass_val == null || c_pass_val.length < 1 || c_pass_val == "" || c_pass_val !=pass_val)
			{
				m_body.html('<p class="text-color-text-red">Password Do not matches.</p>');
				m_modal.modal('show');
				return false;
			}
			else if(email_val == null || !emailRegex.test(email_val))
			{
				m_body.html('<p class="text-color-text-red">Please Enter Correct Email Address</br>(Format: example@email.com).</p>');
				m_modal.modal('show');
				return false;
			}
			/*else if(slot_val == null)
			{
				m_body.html('<p class="text-color-text-red">Please Select a slot timing</p>');
				m_modal.modal('show');
				return false;
			}*/
			else if(month_val == 0 || day_val == 0 || year_val == 0)
			{
				m_body.html('<p class="text-color-text-red">Please Choose Correct Date of birth</p>');
				m_modal.modal('show');
				return false;
			}
			/*else if(pack_val < 1)
			{
				m_body.html('<p class="text-color-text-red">Please Enter Correct Package validity.</br>Must be greater than 0.</p>');
				m_modal.modal('show');
				return false;
			}*/
			else if(!phoneno.test(con_val))
			{
				m_body.html('<p class="text-color-text-red">Please Enter Correct Contact number</br>(Format: 0123456789)</p>');
				m_modal.modal('show');
				return false;
			}
			else
			{
				userObject = { 
					name: user_val,
					password: pass_val,
					email:email_val,
					//slot: slot_val,
					dob: day_val+'/'+month_val+'/'+year_val,
					contact: con_val,
					//pack:pack_val
					//category: category_val
				};
				$.ajax({
					url:'adduser.php',
					type:'POST',
					dataType:'json',
					cache:false,
					data: {user:userObject},
					beforeSend: function(){
								$.blockUI({ message: '<div class="loader"></br></div><p>Processing...</p>' });
								//Show Loader
					},
					success: function(res){
						$.unblockUI();
						if(res['response'] == 1)
						{
							m_body.html('<p class="text-color-text-green">User Added Successfully !!!</p>');
							m_modal.modal('show');
							$('#form')[0].reset();
						}
						else
						{
							m_body.html('<p class="text-color-text-red">User Not Added Successfully !!!</br>'+JSON.stringify(res[0][0])+'</p>');
							m_modal.modal('show');
							//console.log(JSON.stringify(res));
						}
					},
					error: function(err){
						$.unblockUI();
						if(err['response'] == 1)
						{
							m_body.html('<p class="text-color-text-red">User Added Successfully!!!</br>But some error occured.</p>');
							m_modal.modal('show');
						}
						else
						{
							m_body.html('<p class="text-color-text-red">User Not Added Successfully!!!</br>And some error occured.</p>');
							m_modal.modal('show');
							console.log(JSON.stringify(err));
						}
					}
				});
			}
		}
		function unblockAdmin(element,adminID)
		{
			var id = adminID;
			var status = 0;
			var data = {user_id:id,a_status:status};
			
			$.ajax({
				url:'processAdminStatus.php',
				type:'POST',
				dataType:'JSON',
				data: {status:data},
				cache:false,
				success: function(res){
					if(res['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">Admin Successfully Unblocked</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-primary").addClass("btn-danger");
						$(element).val("block");
						element.onclick = function(){blockAdmin(element,adminID);}
					}
					else
					{
						m_body.html('<p class="text-color-text-red">'+JSON.stringify(res['response'])+'</br>There are some Successive Errors</p>');
						m_modal.modal('show');	
					}	
				},
				error: function(err){
					if(err['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">User Successfully Unblocked</br>Some error Occured.</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-primary").addClass("btn-danger");
						$(element).val("block");
						element.onclick = function(){blockAdmin(element,adminID);}
					}
					else{
						m_body.html('<p class="text-color-text-red">There are some Errors</p>');
						m_modal.modal('show');
						console.log(JSON.stringify(err));
					}	
				}
			});
			
		}		
		function blockAdmin(element,adminID)
		{
			var id = adminID;
			var status = 1;
			var data = {user_id:id,a_status:status};
			$.ajax({
				url:'processAdminStatus.php',
				type:'POST',
				dataType:'JSON',
				data: {status:data},
				cache:false,
				success: function(res){
					if(res['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">User Successfully Blocked</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-danger").addClass("btn-primary");
						$(element).val("unblock");
						element.onclick = function(){unblockAdmin(element,adminID);}
					}
					else
					{
						m_body.html('<p class="text-color-text-red">'+JSON.stringify(res['response'])+'</br>There are some Successive Errors</p>');
						m_modal.modal('show');	
					}	
				},
				error: function(err){
					if(err['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">User Successfully Deactivated.</br>Some Error Occured.</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-danger").addClass("btn-primary");
						$(element).val("unblock");
						element.onclick = function(){unblockAdmin(element,adminID);}
					}
					else{	
						m_body.html('<p class="text-color-text-red">There are some Errors</p>');
						m_modal.modal('show');
						console.log(JSON.stringify(err));
					}	
				}
			});
		}
		
		function editPaper(catID)
		{
			$url = "questionlayout.php?lang=0&set="+catID;
			$.blockUI({ message: '<div class="loader col-center"></div><p>Redirecting...</br> in 3 seconds!</br>Please Do Not Refresh.</p>' });
			var x=setTimeout(function(){page($url);},3000);
		}
		
		function viewPaper(catID)
		{
			$url = "page9.php?lang=0&set="+catID;
			$.blockUI({ message: '<div class="loader col-center"></br></div><p>Redirecting...</br> in 3 seconds!</br>Please Do Not Refresh.</p>' });
			var x=setTimeout(function(){page($url);},3000);
		}
		
		function activatePaper(element,id)
		{
			var category = id;
			var flag = 1;
			var data = {category:category,c_status:flag};
			$.ajax({
				url:'processCategoryStatus.php',
				type:'POST',
				dataType:'JSON',
				data: {status:data},
				cache:false,
				success: function(res){
					if(res['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">Category Successfully Activated</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-primary").addClass("btn-danger");
						$(element).val("deactivate");
						element.onclick = function(){deactivatePaper(element,id);}
					}
					else
					{
						m_body.html('<p class="text-color-text-red">'+JSON.stringify(res['response'])+'</br>There are some Successive Errors</p>');
						m_modal.modal('show');	
					}	
				},
				error: function(err){
					if(err['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">Category Successfully activated.</br>But Some Error Occured.</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-primary").addClass("btn-danger");
						$(element).val("deactivate");
						element.onclick = function(){deactivatePaper(element,id);}
					}
					else{	
						m_body.html('<p class="text-color-text-red">There are some Errors</p>');
						m_modal.modal('show');
						console.log(JSON.stringify(err));
					}	
				}
			});
		}
		function deactivatePaper(element,id)
		{
			var category = id;
			var flag = 0;
			var data = {category:category,c_status:flag};
			$.ajax({
				url:'processCategoryStatus.php',
				type:'POST',
				dataType:'JSON',
				data: {status:data},
				cache:false,
				success: function(res){
					if(res['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">Category Successfully Deactivated</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-danger").addClass("btn-primary");
						$(element).val("activate");
						element.onclick = function(){activatePaper(element,id);}
					}
					else
					{
						m_body.html('<p class="text-color-text-red">'+JSON.stringify(res['response'])+'</br>There are some Successive Errors</p>');
						m_modal.modal('show');	
					}	
				},
				error: function(err){
					if(err['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">Category Successfully Deactivated.</br>But Some Error Occured.</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-danger").addClass("btn-primary");
						$(element).val("activate");
						element.onclick = function(){activatePaper(element,id);}
					}
					else{	
						m_body.html('<p class="text-color-text-red">There are some Errors</p>');
						m_modal.modal('show');
						console.log(JSON.stringify(err));
					}	
				}
			});
		}
		
		
		function activateCourse(element,id)
		{
			var course = id;
			var flag = 1;
			var data = {course:course,c_status:flag};
			$.ajax({
				url:'processCourseStatus.php',
				type:'POST',
				dataType:'JSON',
				data: {status:data},
				cache:false,
				success: function(res){
					if(res['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">User Course Successfully Activated</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-primary").addClass("btn-danger");
						$(element).val("deactivate");
						element.onclick = function(){deactivateCourse(element,id);}
					}
					else
					{
						m_body.html('<p class="text-color-text-red">'+JSON.stringify(res['response'])+'</br>There are some Successive Errors</p>');
						m_modal.modal('show');	
					}	
				},
				error: function(err){
					if(err['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">User Course Successfully activated.</br>But Some Error Occured.</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-primary").addClass("btn-danger");
						$(element).val("deactivate");
						element.onclick = function(){deactivateCourse(element,id);}
					}
					else{	
						m_body.html('<p class="text-color-text-red">There are some Errors</p>');
						m_modal.modal('show');
						console.log(JSON.stringify(err));
					}	
				}
			});
		}
		function deactivateCourse(element,id)
		{
			var course = id;
			var flag = 0;
			var data = {course:course,c_status:flag};
			$.ajax({
				url:'processCourseStatus.php',
				type:'POST',
				dataType:'JSON',
				data: {status:data},
				cache:false,
				success: function(res){
					if(res['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">User Course Successfully Deactivated</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-danger").addClass("btn-primary");
						$(element).val("activate");
						element.onclick = function(){activateCourse(element,id);}
						
					}
					else
					{
						m_body.html('<p class="text-color-text-red">'+JSON.stringify(res['response'])+'</br>There are some Successive Errors</p>');
						m_modal.modal('show');	
					}	
				},
				error: function(err){
					if(err['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">User Course Successfully Deactivated.</br>But Some Error Occured.</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-danger").addClass("btn-primary");
						$(element).val("activate");
						element.onclick = function(){activateCourse(element,id);}
					}
					else{	
						m_body.html('<p class="text-color-text-red">There are some Errors</p>');
						m_modal.modal('show');
						console.log(JSON.stringify(err));
					}	
				}
			});
		}
		function deactivateUser(element,username){
			var user = username;
			var u_status = 0;
			var data = {username:user,u_status:u_status};
			
			$.ajax({
				url:'processUserStatus.php',
				type:'POST',
				dataType:'JSON',
				data: {status:data},
				cache:false,
				success: function(res){
					if(res['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">User Successfully Deactivated</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-danger").addClass("btn-primary");
						$(element).val("activate");
						element.onclick = function(){activateUser(element,username);}
						
					}
					else
					{
						m_body.html('<p class="text-color-text-red">'+JSON.stringify(res['response'])+'</br>There are some Successive Errors</p>');
						m_modal.modal('show');	
					}	
				},
				error: function(err){
					if(err['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">User Successfully Deactivated</br>Some error Occured.</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-danger").addClass("btn-primary");
						$(element).val("activate");
						element.onclick = function(){activateUser(element,username);}
					}
					else{
						m_body.html('<p class="text-color-text-red">There are some Errors</p>');
						m_modal.modal('show');
						console.log(JSON.stringify(err));
					}	
				}
			});
			
		}
		function activateUser(element,username){
			var user = username;
			var u_status = 1;
			var data = {username:user,u_status:u_status};
			
			$.ajax({
				url:'processUserStatus.php',
				type:'POST',
				dataType:'JSON',
				data: {status:data},
				cache:false,
				success: function(res){
					if(res['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">User Successfully Activated</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-primary").addClass("btn-danger");
						$(element).val("dectivate");
						element.onclick = function(){deactivateUser(element,username);}
						
					}
					else
					{
						m_body.html('<p class="text-color-text-red">'+JSON.stringify(res['response'])+'</br>There are some Successive Errors</p>');
						m_modal.modal('show');	
					}	
				},
				error: function(err){
					if(err['response'] == 1)
					{
						m_body.html('<p class="text-color-text-green">User Successfully Activated</br>Some error Occured.</p>');
						m_modal.modal('show');
						$(element).removeClass("btn-primary").addClass("btn-danger");
						$(element).val("deactivate");
						element.onclick = function(){deactivateUser(element,username);}
					}
					else{
						m_body.html('<p class="text-color-text-red">There are some Errors</p>');
						m_modal.modal('show');
						console.log(JSON.stringify(err));
					}	
				}
			});
			
		}
		
		
		
		
		
		function viewQuestions(qID,lang)
		{
			var qOb = {question:qID,lang:lang};
			console.log(JSON.stringify(qOb));
			$.ajax({
				url: "showQuestionDetails.php",
					type:"POST",
					dataType:"JSON",
					cache:false,
					data: {data:qOb},
					success: function(res){
						if(res["response"] == 1)
						{
							var detail = '<b>Question Directions:</b></br></div>'+res["directions"];
							var detail_1 = '<b>Question Paragraph:</b></br>'+res["paragraph"];
							var detail_2 = '<b>Question:</b></br></div>'+res["question"];
							var detail_3 = '<b>Option 1:</b>  '+res["opt_1"];
							var detail_4 = '<b>Option 2:</b>  '+res["opt_2"];
							var detail_5 = '<b>Option 3:</b>  '+res["opt_3"];
							var detail_6 = '<b>Option 4:</b>  '+res["opt_4"];
							var detail_7 = '<b>Option 5:</b>  '+res["opt_5"];
							var detail_8 = '<b>Option 6:</b>  '+res["opt_6"];
							var detail_9 = '<b>Solution:</br></b>  '+res["solution"];
							$("#modal_question_directions").html(detail);
							$("#modal_question_paragraph").html(detail_1);
							$("#modal_question_question").html(detail_2);
							$("#modal_question_opt_1").html(detail_3);
							$("#modal_question_opt_2").html(detail_4);
							$("#modal_question_opt_3").html(detail_5);
							$("#modal_question_opt_4").html(detail_6);
							$("#modal_question_opt_5").html(detail_7);
							$("#modal_question_opt_6").html(detail_8);
							$("#modal_question_solution").html(detail_9);
							m_modal.modal("show");
							//$("question_view").removeClass("hide");
						}
						else
						{
							console.log(JSON.stringify(res));
						}
						
					},
					error: function(err){
						if(err["response"] == 1)
						{
							m_body.html(res['res']);
							m_modal.modal("show");
							//$("question_view").removeClass("hide");
							console.log("failed");
						}
						console.log(JSON.stringify(err));
					}
			});
		}

		
		function page(url)
		{
			window.location = url; // Members Area
		}
$(function($){

		$("#msgBox").unbind('click').on('click',"#admin_msgOK",function(e){
				e.preventDefault();
				var admin_pass_val = $("#admin_pass").val();
				var admin_user_val = $('#admin_username').text();

				var user_val = $('#username').val(),
				email_val = $('#email').val(),
				pass_val = $('#password').val(),
				f_name_val = $('#firstname').val(),
				l_name_val = $('#lastname').val();

				
				adminOb = {user:admin_user_val,pass:admin_pass_val};
				var xhr = $.ajax({
					url:'processAccess.php',
					type:'POST',
					dataType:'json',
					cache:false,
					data: {user:adminOb},
					beforeSend: function(){
								$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
								m_title.html("<h3>Attention !!!</h3>");
								m_footer.html('<button class="btn btn-success btn-default pull-left" id="msgOK" data-dismiss="modal">OK</button>\
										<button class="btn btn-danger btn-default pull-right" id="msgCancel" data-dismiss="modal">Cancel</button>');
								//Show Loader
					},
					success: function(response){
						$.unblockUI();
						if(response["response"] == 1)
						{
							admin_data = { 
							username: user_val,
							pass: pass_val,
							email:email_val,
							f_name:f_name_val,
							l_name:l_name_val
							};
							var nxhr = $.ajax({
								url:'secureSuperAdd.php',
								type:'POST',
								dataType:'json',
								cache:false,
								data: {admin_data:admin_data},
								beforeSend: function(){
									$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
								},
								success: function(res){
									$.unblockUI();
									alert(JSON.stringify(res));
									$('#form')[0].reset();
								},
								error: function(err){
									$.unblockUI();
									console.log(JSON.stringify(err));
								}
							});
						}
						else
						{
							alert('Access Denied!!!Password is incorrect !!!');
						}
						
						
					},
					error: function(errs){
						$.unblockUI();
						if(errs["response"] ==1)
						{
							console.log('Access Authorized. But some errors occured !!!');
						}
						else
						{
							alert('Access Denieds!!!');
							
						}
						console.log(JSON.stringify(errs));
					}
				});
		});
		$("#msgBox").on('click',"#admin_msgCancel",function(e){
				e.preventDefault();
				var admin_pass = $("#admin_pass").val("");
				$('#form')[0].reset();
				m_title.html("<h3>Attention !!!</h3>");
				m_footer.html('<button class="btn btn-success btn-default pull-left" id="msgOK" data-dismiss="modal">OK</button>\
										<button class="btn btn-danger btn-default pull-right" id="msgCancel" data-dismiss="modal">Cancel</button>');
		});
		$('#category').on('change',function(e){
					$('#new_category_name').val('');
					$('#new_category_box').addClass('hide');
				});
		$('#msgCancel').unbind('click').on('click',function(e){
					e.preventDefault();
					$('#new_category_name').val('');
		});


		
		//other functions
			
});	