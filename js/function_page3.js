			$(function($){
				var m_modal = $('#msgBox'),
					m_body= $("#msgText"),
					m_title = $('#msgTitle');
				var para_count = 0;
				var para_id =0;	
				var	count = 1;
				var options_val = 4;
				var paragraph_id = 1;
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
				$('#question_category_type').on('change',function(e){
					e.preventDefault();
					var type = $('#question_category_type option:selected'),
						type_val = type.val();
						//console.log(type_val);
						if(type_val == -1)
						{
							var m_title_val = m_title.html('Add New Question Type');
							m_body.html('<input class="form-control" placeholder="write your new type here..." id="new_question_type"/>');
							m_modal.modal('show');
							$('#msgOK').unbind('click').on('click',function(e){
								e.preventDefault();
								var new_type = $('#new_question_type'),
								new_type_val = new_type.val();
								if(new_type_val == null || new_type_val == "")
								{
									m_body.append('<p class="text-color-text-red">This type can not be added!</p>');
									return false;
								}
								$('#question_category_type').append('<option selected value='+new_type_val+'>'+new_type_val+'</option>');
								//console.log('added');
							});
							$('#msgCancel').on('click',function(e){
								e.preventDefault();
								m_modal.modal('hide');
								return false;
							});
						}	
				});
				$('#save').on('click',function(e){
					e.preventDefault();
					var question_negative = $('#question_negative'),
						question_positive = $('#question_positive'),
						question_no = $('#question_no option:selected'),
						question_text = $('#question_text'),
						option_text_1 = $('#option_text_1'),
						option_text_2 = $('#option_text_2'),
						option_text_3 = $('#option_text_3'),
						option_text_4 = $('#option_text_4'),
						paper_set = $('#paper_set'),
						paper_category = getParameterByName('c');
						paper_language = $('#paper_language');
						if($('input[name="option"]').is(":checked"))
						{
							var	question_answer = $('input[name="option"]:checked'),
							question_answer_split = question_answer.attr('id').split('opt_'),
							question_answer_id = question_answer_split[1];
						}	
					var	question_category_type = $('#question_category_type option:selected'),
						question_type = $('#question_type option:selected'),
						correct_option = -1;
					var question_positive_val = question_positive.val(),
						paper_set_val = paper_set.val(),
						paper_lang_val = paper_language.val();
						question_negative_val = question_negative.val().trim(),
						question_text_val = question_text.val().trim(),
						option_text_1_val = option_text_1.val().trim(),
						option_text_2_val = option_text_2.val().trim(),
						option_text_3_val = option_text_3.val().trim(),
						option_text_4_val = option_text_4.val().trim();
					var flag = 0;	
						var m_title_val = m_title.html('Server Response');
						
					for(var i = 1; i<=6;i++)
					{
						if(i == (question_answer_id))
						{
							correct_option = i;
							break;
						}	
					}	
					if(question_positive_val == null || parseInt(question_positive_val) < 1 || isNaN(question_positive_val) || question_positive_val =="")
					{
						//$('#question_positive').prop('disabled', false);
						alert("Please enter valid positive marks for question.");
						return false;
					}
					else if(question_negative_val == null || parseFloat(question_positive_val) < 1 || isNaN(question_positive_val) || question_negative_val =="")
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
					else
					{	
						$('#question_no').prop('disabled', 'disabled');
						$('#question_positive').prop('disabled', 'disabled');
						$('#question_negative').prop('disabled', 'disabled');
						var dataObject = {
							negative: question_negative.val(),
							positive: question_positive.val(),
							question: question_no.val(),
							question_text: question_text.val(),
							option_1: option_text_1.val(),
							option_2: option_text_2.val(),
							option_3: option_text_3.val(),
							option_4: option_text_4.val(),
							opt_flag: flag,
							language: paper_lang_val,
							set: paper_set_val,
							paper_category: paper_category,
							answer: correct_option,
							category: question_category_type.val(),
							type: question_type.val()
						};
						if(options_val == 5)
						{
							var option_text_5 = $('#option_text_5');
							if(option_text_5.val().length < 1) 
							{
								alert("Please provide the option 5.");
								return false;
							}
							dataObject.option_5 = option_text_5.val();
							dataObject.opt_flag = 1;
						}
						else if(options_val == 6)
						{
							var option_text_5 = $('#option_text_5');
							var option_text_6 = $('#option_text_6');
							if(option_text_5.val().length < 1 || option_text_6.val().length < 1) 
							{
								alert("Please provide the option 5 or 6.");
								return false;
							}
							dataObject.option_5 = option_text_5.val();
							dataObject.option_6 = option_text_6.val();
							dataObject.opt_flag = 2;
						}
						if(question_type.val() != 1)
						{
							var paragraph_text = $('#paragraph_text'),
							question_related = $('#question_related');
							var paragraph_text_val = paragraph_text.val(),
							question_related_val = question_related.val().trim();
							if(paragraph_text_val.length < 1)
							{
								alert("Please provide the passage details.");
								return false;
							}
							else if(question_related_val == null || parseInt(question_related_val) < 1 || isNaN(question_related_val) || question_related_val == "")
							{
								alert("Please insert correct number of question related to paragraph.");
								return false;
							}
							dataObject.paragraph = paragraph_text_val;
							dataObject.paragraph_questions = question_related_val;
							dataObject.paragraph_id = para_id;
						}
						console.log(JSON.stringify(dataObject));
						$.ajax({
							url:"processQuestions.php",
							type:'POST',
							dataType: 'JSON',
							data: {paper:dataObject},
							cache:false,
							beforeSend: function(){
								$.blockUI({ message: '<div class="loader col-center"></br></div><p>Processing...</p>' });
							},
							complete: function(){
								$.unblockUI();
							},
							success: function(res){
								$.unblockUI();
								if(res['response'] == 11 && res['p_response'] == 0 && para_id == 0)
								{
									m_body.html('<p class="text-color-text-green">Successfully Added</p>');
									m_modal.modal('show');
									count++;
									$('form[name="question_paper"]')[0].reset();
									$('form[name="question_paper_2"]')[0].reset();
									$('#question_no').append('<option selected value='+count+'>'+count+'</option>');
								}
								else if(res['response'] == 11 && (res['p_response'] == 9 || para_id != 0))
								{
									if(para_id == 0)
									{
										para_id = res['para_id'];
										para_count = res['para_count'];
										$('#paragraph_text').prop('disabled', 'disabled');
										$('#question_type').prop('disabled', 'disabled');
										$('#question_category_type').prop('disabled', 'disabled');
										$('#question_related').prop('disabled', 'disabled');
										$('form[name="question_paper"]')[0].reset();
									}
									m_body.html('<p class="text-color-text-green">Successfully Added</p>');
									m_modal.modal('show');
									count++;
									para_count--;
									console.log(para_count);
									if(para_count == 0)
									{
										$('#paragraph_text').prop('disabled', false);
										$('#question_type').prop('disabled', false);
										$('#question_category_type').prop('disabled', false);
										$('#question_related').prop('disabled', false);
										$('#paragraph_text').val('');
										$('#paragraph').addClass('hide');
										$('form[name="question_paper"]')[0].reset();
										$('form[name="question_paper_2"]')[0].reset();
									}
									//$('#paragraph_text').prop('disabled', 'disabled');
									$('#question_no').append('<option selected value='+count+'>'+count+'</option>');
								}	
								else{
									m_body.html('<p class="text-color-text-red">'+JSON.stringify(res['response'])+'</br>There are some Successive Errors</p>');
									m_modal.modal('show');
								}
							},
							error: function(err){
								$.unblockUI();
								m_body.html('<p class="text-color-text-red">'+JSON.stringify(err[0])+'</br>There are some Errors</p>');
								m_modal.modal('show');
								console.log(JSON.stringify(err));
							},
							timeout:10000
						});
					}	
						
				});
				$('#edit').on('click',function(e){
					e.preventDefault();
					$('#question_no').prop('disabled', false);
					$('#question_positive').prop('disabled', false);
					$('#question_negative').prop('disabled', false);
					$('#paragraph').prop('disabled', false);
				});
				$('#question_no').on('change',function(e){
					e.preventDefault();
					var question_no_val = $('#question_no').val();
					var dataObject = {question: question_no_val};
					$.ajax({
						url: 'editQuestions.php',
						cache:false,
						dataType:'JSON'
						type:'POST',
						data: {edit:dataObject},
						success: function(data){
							
						},
						error: function(err){
							
						}
					});
				});
				$('#cancel').on('click',function(e){
					e.preventDefault();
					$('#paragraph_text').val('');
					$('#paragraph').addClass('hide');
					$('form[name="question_paper"]')[0].reset();
					$('form[name="question_paper_2"]')[0].reset();
					$('#question_no').prop('disabled', 'disabled');
					$('#question_positive').prop('disabled', 'disabled');
					$('#question_negative').prop('disabled', 'disabled');
				});
			});
