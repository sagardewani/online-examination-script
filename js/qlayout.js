/*function getParameterByName(name, url) {
							if (!url) {
								url = window.location.href;
							}
							name = name.replace(/[\[\]]/g, "\\$&");
							var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
							results = regex.exec(url);
							if (!results) return null;
							if (!results[2]) return '';
							return decodeURIComponent(results[2].replace(/\+/g, " "));
						}*/
						$(function($){
							var m_modal = $('#msgBox'),
								m_body= $("#msgText"),
								m_title = $('#msgTitle');
							var para_count = 0;
							var para_id =0;	
							var	count = $('#question_no option:selected').val();
							var options_val = 4;
							var paragraph_id = 1;
							var NonDigiT = /\D/g;
							var rel_number;
							var total_marks = 0;
							var newcategory = 0;
							var savedata = 0;
							var set = document.getElementById("set").value;
							verify_Relationships();
							function verify_Relationships()
							{
								var nset = set;
								console.log(nset);
								var dataOb = {set:nset};
								$.ajax({
									url:'accessRelationship.php',
									type:'post',
									cache:false,
									dataType:'json',
									data:{data:dataOb},
									beforeSend: function(){
												$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
												//Show Loader
									},
									success:function(res){
										$.unblockUI();
										if(res['response'] == 1)
										{
											para_id = res['para_id'];
											para_count = res['left_relations'];
											var question_category = res['question_category'];
											var total = res['total'];
											var p_text = res['p_text'];
											if(p_text == null)
											{
												p_text = "";
											}
											if(para_id != 0 && para_count != 0)
											{
												$('#paragraph_text').prop('disabled', 'disabled');
						/*leftpoint*/			$('#question_type').prop('disabled', 'disabled');
												$('#question_category_type').prop('disabled', 'disabled');
												$('#question_related').prop('disabled', 'disabled');
												$('#question_type option:eq(1)').prop('selected',true);
												$('#question_category_type').val(question_category);
												$("#question_related").val(total);
												$("#special_questions").removeClass('hide');
												$("#paragraph").removeClass("hide");
												
												//$('form[name="question_paper"]')[0].reset();
											}
											tinymce.init({
													selector:'#paragraph_text',
													theme: 'modern',
													plugins: [
														'lists charmap preview hr',
														'fullscreen insertdatetime nonbreaking',
														'table contextmenu directionality template paste textcolor autoresize fullscreen'
														],
													autoresize_bottom_margin: 50,
													autoresize_max_height: 450,
													autoresize_min_height: 150,
													toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | preview fullpage | forecolor backcolor',													relative_urls:false,
													init_instance_callback:function(editor)
														{
															editor.setContent(p_text);
														}
												});
										}

									},
									error: function(err){
										console.log(JSON.stringify(err));
									}
								});
							}
								
							$('#question_type').on('change',function(e){
								e.preventDefault();
								var question_type = $('#question_type option:selected'),
									special_questions = $('#special_questions'),
									paragraph = $('#paragraph');
									
								var question_type_val = question_type.val(),
									special_questions_val = special_questions.val(),
									paragraph_val = paragraph.val();
									
								if(question_type_val == 1)
								{
									special_questions.addClass('hide');
									
									paragraph.addClass('hide');
								}
								else
								{
									paragraph.removeClass('hide');
									special_questions.removeClass('hide');
								}
							});
							$('#image_required').on('change',function(e){
								e.preventDefault();
								var image_required = $('#image_required option:selected');
									
								var image_required_val = image_required.val();
								console.log(image_required_val);
								if(image_required_val == 0)
								{
									$('#images').addClass('hide');
									$("#question_images").val("");									
									$("#show_image").attr('src','data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABA‌​AACAUwAOw==');
								}
								else
								{
									$('#images').removeClass('hide');
									
								}
							});
							$('#options').on('change',function(e){
								e.preventDefault();
								var options = $('#options option:selected'),
									option_5 = $('#option_5'),
									option_6 = $('#option_6');
									
								options_val = options.val();
								
								if(options_val == 5)
								{
									option_5.removeClass('hide');
									option_6.addClass('hide');
								}
								else if(options_val == 6)
								{
									option_5.removeClass('hide');
									option_6.removeClass('hide');
								}
								else{
									option_5.addClass('hide');
									option_6.addClass('hide');
								}
							});
							function saveData()
							{
								var	solution_text_val = tinyMCE.get('question_solution').getContent(),
									question_text_val = tinyMCE.get('question_text').getContent();
								var regex =/^(0*[1-9][0-9]*(\.[0-9]+)?|0+\.[0-9]*[1-9][0-9]*)$/;
								var question_negative = $('#question_negative'), //negative numbers of question
									question_positive = $('#question_positive'), //positive numbers of question
									question_no = $('#question_no option:selected'), //question number that is currently selected
									option_text_1 = $('#option_text_1'), //question option 1 text
									option_text_2 = $('#option_text_2'), //question option 2 text
									option_text_3 = $('#option_text_3'), //question option 3 text
									option_text_4 = $('#option_text_4'), //question option 4 text
									directions = $('#direction_text'); //question directions or guidelines

									//check which option is selected
									if($('input[name="option"]').is(":checked")) 
									{
										var	question_answer = $('input[name="option"]:checked'),
										question_answer_split = question_answer.attr('id').split('opt_'), 
										question_answer_id = question_answer_split[1]; //get the option number that is selected
									}	
								var	question_category_type = $('#question_category_type option:selected'), //question category selected (such as reasoning)
									question_type = $('#question_type option:selected'), //question type selected (such as paragraphical, normal...)
									correct_option = -1; //if no option is selected then this variable will alert
								var image_required = $('#image_required option:selected'); //select image option element
								 //just trimming here and getting value of selected elements for further processing
								var question_positive_val = question_positive.val().trim(),
									question_negative_val = question_negative.val().trim(),
									paper_set_val = $('#paper_set').val(), //paper set no.
									paper_lang_val =$('#paper_language').val(),		//paper language (now only english)							
									
									option_text_1_val = option_text_1.val().trim(),
									option_text_2_val = option_text_2.val().trim(),
									option_text_3_val = option_text_3.val().trim(),
									option_text_4_val = option_text_4.val().trim(),
									directions_val = directions.val().trim();
								//Initializing the flag and img(assuming user have not selected it yet)	
								var flag = 0;
								var img=0;
								//updating the modal title.
								var m_title_val = m_title.html('Server Response');
								//if image option is set to "yes"
								if(image_required.val() == 1)
								{	
									//if image is not selected then return with alert
									if(!saveImage()){
										alert("Image is not inserted");
										return false;
									}
									//else set img variable to indicate image is inserted
									else
									{
										img = 1;
									}	
								}	
								//loop from all option to check which of the option is selected.
								for(var i = 1; i<=6;i++)
								{
									if(i == (question_answer_id))
									{
										correct_option = i;
										break;
									}	
								}
								//Now do if, else check based on condition to validate input
								if(!regex.test(question_positive_val))
								{
									//$('#question_positive').prop('disabled', false);
									alert("Please enter valid positive marks for question.");
									return false;
								}
								else if(!regex.test(question_positive_val))
								{
									//$('#question_negative').prop('disabled', false);
									alert("Please enter valid negative marks for question.");
									return false;
								}
								else if(question_text_val.length < 1)
								{
									alert("Please provide the question");
									return false;
								}
								else if(option_text_1_val.length < 1)
								{
									alert("Please provide the option 1.");
									return false;
								}
								else if(option_text_2_val.length < 1)
								{
									alert("Please provide the option 2.");
									return false;
								}
								else if(option_text_3_val.length < 1)
								{
									alert("Please provide the option 3.");
									return false;
								}
								else if(option_text_4_val.length < 1)
								{
									alert("Please provide the option 4.");
									return false;
								}
								else if(correct_option == -1)
								{
									alert("No correct answer is selected.");
									return false;
								}
								else if(question_category_type.val() == -1)
								{
									alert("Choose correct question type.");
									return false;
								}
								else if(solution_text_val.length < 1)
								{
									alert("Please provide the solution.");
									return false;
								}//after check is completed.
								else
								{	
									//while sending data for further level of processing disable elements to be accessible so that user can not change the value in between
									//that can create chaos.
									$('#question_no').prop('disabled', 'disabled');
									$('#question_positive').prop('disabled', 'disabled');
									$('#question_negative').prop('disabled', 'disabled');
									//assign all data collected in an object variable.
									var dataObject = {
										negative: question_negative_val,
										positive: question_positive_val,
										question: question_no.val(),
										question_text: question_text_val,
										option_1: option_text_1_val,
										option_2: option_text_2_val,
										option_3: option_text_3_val,
										option_4: option_text_4_val,
										directions: directions_val,
										opt_flag: flag,
										img:img,
										language: paper_lang_val,
										set: paper_set_val,
										para_count:para_count,
										answer: correct_option,
										category: question_category_type.val(),
										solution:solution_text_val,
										type: question_type.val()
										
									};
									//further if user have made more choices(such as more than 4 options & paragraphical questions) then do a final cross-check and update the dataObject
									if(options_val == 5)
									{
										var option_text_5 = $('#option_text_5');
										if(option_text_5.val().length < 1 ) 
										{
											alert("Please provide the option 5.");
											return false;
										}
										var option_text_5_val = option_text_5.val().trim();
										dataObject.option_5 = option_text_5_val;
										dataObject.opt_flag = 1;
									}
									else if(options_val == 6)
									{
										var option_text_5 = $('#option_text_5');
										var option_text_6 = $('#option_text_6');
										if((option_text_5.val().length < 1 || option_text_6.val().length < 1))
										{
											alert("Please provide the option 5 or 6.");
											return false;
										}
											var option_text_5_val = option_text_5.val().trim();
										
											var option_text_6_val = option_text_6.val().trim();
										
										dataObject.option_5 = option_text_5_val;
										dataObject.option_6 = option_text_6_val;
										dataObject.opt_flag = 2;
									}
									if(question_type.val() != 1)
									{
										var paragraph_text = tinyMCE.get('paragraph_text'),
										 paragraph_text_val = paragraph_text.getContent(),
										question_related_val = $('#question_related').val().trim();
										if(paragraph_text_val.length < 1)
										{
											alert("Please provide the passage details.");
											return false;
										}
										else if(question_related_val == null || NonDigiT.test(question_related_val))
										{
											alert("Please insert correct number of question related to paragraph.");
											return false;
										}
										dataObject.paragraph = paragraph_text_val;
										dataObject.paragraph_questions = question_related_val;//assign how much questions a paragraph would consist of.
										
										//initially the paragraph id is not known (until we fetched it from database) so it will be 0,
										//indicating that this is initalization of paragraphical question
										dataObject.paragraph_id = para_id;
									}
									savedata = 1;
									total_marks +=parseInt(question_positive_val);
								}	
								return dataObject;
							}
							function addNewCategory()
							{
								var m_title_val = m_title.html('Add New Question Type');
									m_body.html('<input class="form-control" placeholder="write your new type here..." id="new_question_type"/>');
									m_modal.modal('show');
									newcategory = 1;
							}
							$('#question_category_type').on('change',function(e){
								e.preventDefault();
								var type = $('#question_category_type option:selected'),
									type_val = type.val();
								if(type_val == -1)
								{
									addNewCategory();										
								}	
							});
							$('#msgOK').on('click',function(e){
								e.preventDefault();
								if(newcategory)
								{	
									var new_type = $('#new_question_type'),
										new_type_val = new_type.val().trim().toUpperCase();
									if(new_type_val == null || new_type_val == "")
									{
										m_body.append('<p class="text-color-text-red">This type can not be added!</p>');
										return false;
									}
									$('#question_category_type').append('<option selected value='+new_type_val+'>'+new_type_val+'</option>');
									new_type.val('');
								}			
							});
							$('#msgCancel').on('click',function(e){
								e.preventDefault();
								return false;
							});	
							$(".modal").on("hidden.bs.modal", function(){
									m_title = $('#msgTitle');
									m_title.html("Attention!!!");
									m_body.html("");
									newcategory = 0;
							});	
							$('#save').on('click',function(e){
								e.preventDefault();
								//selecting the elements
									var dataObject = saveData();
									if(savedata)
									$.ajax({
										url:"processQuestions.php",
										type:'POST',
										dataType: 'JSON',
										data: {paper:dataObject},
										cache:false,
										beforeSend: function(){
											$(".bottom-tab").addClass("hide");
											$("#loader").removeClass("hide");
										},
										success: function(res){
											$(".bottom-tab").removeClass("hide");
											$("#loader").addClass("hide");
											if(res['response'] == 11 && res['p_response'] == 0 && para_id == 0) //normal type
											{
												m_body.html('<p class="text-color-text-green">Successfully Added</p>');
												m_modal.modal('show');
												count++;
												//$('form[name="question_paper"]')[0].reset();
												$('form[name="question_paper_2"]')[0].reset();
												$('#form_images')[0].reset();
												$('#question_no').append('<option selected value='+count+'>'+count+'</option>');
											}
											else if(res['response'] == 11 && (res['p_response'] == 9 || para_id != 0)) //paragraph and other type
											{
												if(para_id == 0)//initially 
												{
													para_id = res['para_id']; //id of paragraph
													para_count = res['para_count']; //question related to paragraph
													$('#paragraph_text').prop('disabled', 'disabled');
													$('#question_type').prop('disabled', 'disabled');
													$('#question_category_type').prop('disabled', 'disabled');
													$('#question_related').prop('disabled', 'disabled');
													//$('form[name="question_paper"]')[0].reset();
												}
												count++;
												para_count--;
												if(para_count == 0)
												{
													$('#paragraph_text').prop('disabled', false);
													$('#question_type').prop('disabled', false);
													$('#question_category_type').prop('disabled', false);
													$('#question_related').prop('disabled', false);
													//$('#paragraph_text').val('');
													$('#paragraph').addClass('hide');
													$("#special_questions").addClass('hide');
													//$('form[name="question_paper"]')[0].reset();
													$('form[name="question_paper_2"]')[0].reset();
													$('#form_images')[0].reset();
													para_id = 0;
												}
												else
												{
													$('form[name="question_paper"]')[0].reset();
												}
												m_body.html('<p class="text-color-text-green">Successfully Added</p>');
												m_modal.modal('show');												
												//$('#paragraph_text').prop('disabled', 'disabled');
												$('#question_no').append('<option selected value='+count+'>'+count+'</option>');
											}	
											else{
												m_body.html('<p class="text-color-text-red">'+JSON.stringify(res['error'])+'</br>There are some Successive Errors</p>');
												m_modal.modal('show');
											}
											savedata = 0;
										},
										error: function(err){
											$(".bottom-tab").removeClass("hide");
											$("#loader").addClass("hide");
											m_body.html('<p class="text-color-text-red">'+JSON.stringify(err[0])+'</br>There are some Errors</p>');
											m_modal.modal('show');
											console.log(JSON.stringify(err));
											savedata = 0;
										},
										timeout:10000
									});								
							});
							$("#done").on('click',function(e){
								e.preventDefault();
								var category = set;
								var dataOb = {total:count-1,category:category,marks:total_marks};
								$.ajax({
									url:"processFinalPaper.php",
									type:'POST',
									dataType: 'JSON',
									data: {paper:dataOb},
									cache:false,
									beforeSend: function(){
										$.blockUI();
									},
									success: function(res){
										
										if(res['response'] == 1)
										{
											m_body.html('<div class="text-center"><p class="text-color-text-green">Paper Has Been Added Successfully</br>You will be redirected.In 3 Seconds.</p><p class="loader col-center"></p></div>');
											m_modal.modal('show');	
											var i = setTimeout(function() {page(res['url'])},3000);
										}
										else
										{
											$.unblockUI();
											m_body.html('<p class="text-color-text-red">Failed: Some error occured</p>');
											m_modal.modal('show');
											console.log(JSON.stringify(err));
										}
									},
									error:function(err){
										$.unblockUI();
										if(err['response'] == 1)
										{
											m_body.html('<p class="text-color-text-yellow">Paper Has Been Added Successfully</br>Some Error occured.</p>');
											m_modal.modal('show');	
										}
										else
										{
											m_body.html('<p class="text-color-text-red">Error: Some error occured</p>');
											m_modal.modal('show');	
										}
										console.log(JSON.stringify(err));
									},
									timeout:10000
								});
							});	
							$('#edit').on('click',function(e){
								e.preventDefault();
								$('#question_no').prop('disabled', false);
								$('#question_positive').prop('disabled', false);
								$('#question_negative').prop('disabled', false);
								$('#paragraph').prop('disabled', false);
							});
							
							$('#cancel').on('click',function(e){
								e.preventDefault();
								$('#paragraph_text').val('');
								$('#paragraph').addClass('hide');
								if(para_count==0)
								$("#special_questions").addClass('hide');
								$('form[name="question_paper"]')[0].reset();
								$('form[name="question_paper_2"]')[0].reset();
								$('#question_no').prop('disabled', 'disabled');
								$('#question_positive').prop('disabled', 'disabled');
								$('#question_negative').prop('disabled', 'disabled');
							});
							$("#question_images").on('change',function(){readURL(this);});
							
							tinymce.init({
								selector: '#question_text',
								theme: 'modern',
								plugins: [
									'lists charmap preview hr',
									'fullscreen insertdatetime nonbreaking',
									'table contextmenu directionality template paste textcolor autoresize fullscreen'
									],
								autoresize_bottom_margin: 50,
								autoresize_max_height: 450,
								autoresize_min_height: 150,
								toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | preview fullpage | forecolor backcolor',
										
							});
							
							tinymce.init({
								selector: '#question_solution',
								theme: 'modern',
								plugins: [
									'lists charmap preview hr',
									'fullscreen insertdatetime nonbreaking',
									'table contextmenu directionality template paste textcolor autoresize fullscreen'
									],
								autoresize_bottom_margin: 50,
								autoresize_max_height: 450,
								autoresize_min_height: 150,
								toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | preview fullpage | forecolor backcolor',
										
							});
							
							/*$("#show").on('click',function(e){
								var cText = tinyMCE.get('paragraph_text').getContent();
								console.log(cText);
							});*/
							function saveImage()
							{
								var result = false;
								if (window.File && window.FileReader && window.FileList && window.Blob)
								{
									if( !$('[name=question_images]').val()) //check empty input filed
									{
										m_body.html('<p class="text-color-text-red">Insert a Image</p>');
										m_modal.modal('show');
										return false;
									}
						
									var 
									fsize = $('[name=question_images]')[0].files[0].size, //get file size
									ftype = $('[name=question_images]')[0].files[0].type; // get file type
						//allow only valid image file types 
									switch(ftype)
									{
										case 'image/jpeg':
										break;
										case 'image/png':
										break;
										case 'image/jpg':
										break;
										default:
										m_body.html('<b>'+ftype+'</b><p class="text-color-text-red">Unsupported file type!(your file should be in jpeg format.)</p>');
										m_modal.modal('show');
										return false
									}
						//Allowed file size is less than 1 MB (1048576)
									if(fsize>(4*1048576)) 
									{
										m_body.html("<b>"+bytesToSize(fsize) +"</b> Too big Image file! <br />The maximum allowed size is : 4MB ");
										m_modal.modal('show');
										return false
									}
									//$('#show_image').addClass('hide');	
								}
								else
								{
									//Output error to older unsupported browsers that doesn't support HTML5 File API
									m_body.html("Please upgrade your browser, because your current browser lacks some new features we need!");
									m_modal.modal('show');
									return false;
								}
								var form = $('#form_images');
								
								var paper_set = $('#paper_set').val();
								var question = $('#question_no option:selected').val();
								$('[name="question_image"]').val('question_image_'+paper_set+'_'+question);
								$.ajax({
								url: "imageProcess.php",
								type: "POST",             // Type of request to be send, called as method
								data: new FormData(form[0]), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
								contentType: false,       // The content type used when sending data to the server.
								cache: false,             // To unable request pages to be cached
								processData:false,
								async:false,
								success:
										function(res)
										{
											result = true;
											//console.log(res);
										},	
								error:
									function()
									{
										//$('[name=upload_avatar]').show();
										//$('#avatar').css("opacity: none");
										//$('#loader').hide();
										//$('#output').html("Connection Timeout.");
										//$('#message').modal('show');
										console.log('err');
									}
								});
							//console.log(result);
								return result;
						}
						
						function bytesToSize(bytes) {
							var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
							if (bytes == 0) return '0 Bytes';
							var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
							return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
						}
						function readURL(input) {
							if (input.files && input.files[0])
							{
								var reader = new FileReader();
								reader.onload = function(e){$('#show_image').attr('src', e.target.result);}
								reader.readAsDataURL(input.files[0]);
							}
						}
						function page(url)
						{
							window.location.replace(url); // Members Area
						}
					
						});