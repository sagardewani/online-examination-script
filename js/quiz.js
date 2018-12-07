var question_count = 1;
				var A = "selected-answered";
				var B = "selected-review";
				var C = "selected";
				var D = "selected-reviewanswered";
				var E = "selected-unanswered";
				var F = "not-selected-answered";
				var G = "not-selected-review";
				var H = "not-selected";
				var I = "not-selected-reviewanswered";
				var J = "not-selected-unanswered";
				var submit = 0;
			$(function($){
				var question_time_elapsed = 0;
				var q_elapsed = 0;
				var last_question = $("#totalQuestion").val();
				var time = $("#totalTime").val();
				var question_id_full,question_id_split,question_id;
				var laststamp = $("#lastTime").val();
				var currentstamp = Math.round((new Date()).getTime() / 1000);
				var duration = currentstamp - laststamp;
		        var c = time - duration;
				if(c < 0) c= 0;
				var t;
				var user_id = $("#userID").val();
				var paper_category_id = $("#paperCategory").val();
				var paper_course_id = $("#paperCourse").val();
				

				timedCount();
				preProcess();
				
				function page(url)
				{
					window.location.replace(url); // Members Area
				}
				function getCurrentQId()
				{
					return $("#currentQuestion").val();
				}
				function getCurrentQNumber(qId)
				{
					$array = $('#question_no_'+qId).attr('class').split(' ');
					$newarray = $array[0].split('_');
					return $newarray[3];
				}
				function getCurrentQCategory(ID)
				{
					return $("[alt=catQuestion_"+ID+"]").attr('rel');
				}
				function getElapsedTime()
				{
					var elapsed = 0;
					elapsed = q_elapsed + question_time_elapsed;
					return elapsed;
				}
				function timedCount() {

					var hours = parseInt( c / 3600 ) % 24;
					var minutes = parseInt( c / 60 ) % 60;
					var seconds = c % 60;
					question_time_elapsed +=1;

					var result = "Time Left: "+(hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds  < 10 ? "0" + seconds : seconds);

					$("#timer").html(result);

					if(c == 0 ){
						//setConfirmUnload(false);
						var category_id = paper_category_id;
						var attempted = 1;
						var time_taken = time -c;
						var userOb = {user:user_id,category:category_id,attempted:attempted,finish:1,time:time_taken};
						$.ajax({
							url:'processSubmission.php',
							type:'post',
							dataType:'json',
							data:{submit:userOb},
							cache:false,
							success: function(res){
								//console.log(JSON.stringify(res));
								/*m_title.html('<h2>PAPER FINISHED</h2>');
								m_body.html('<p class="text-color-text-green">Paper is finished</br>Press Ok To Logout.</p>');
								m_modal.modal('show');*/
								$.blockUI({ message: '<p>Paper is finished...</p><div class="loader col-center"></br></div>' });
								page("../index.php");
							},
							error:function(err){
								console.log(JSON.stringify(err));
							}
						});
					}
					else{
						t = setTimeout(function(){ timedCount() }, 1000);
					}
					c = c - 1;
				
				}
				function preProcess(){
					var users_id = user_id;
						var category_id = paper_category_id;
						var attempted = 1;
						//var d = new Date();
						//var n = d.getTime();
						//var timestamp = n;
						var userOb = {user:users_id,category:category_id,attempted:attempted};
						$.ajax({
							url:'processSubmission.php',
							type:'post',
							dataType:'json',
							data:{submit:userOb},
							cache:false,
							success: function(res){
								//console.log(JSON.stringify(res));
							},
							error:function(err){
								console.log(JSON.stringify(err));	
							}
						});
				}
				function saveUserSelection(id,type)
				{
						var selected,elapsed;
						var lang_val = $('#view_in option:selected').val();
						$id = id;
						$typeOfSelection = type;
						$split_id = $id.split('_'); //get the ID of selected element and split it.
					
						var question_number_count = $split_id[4];
						var questions_id = $split_id[6];
						//$next_question = questions_id+1;
						//check which option is selected;
						var userOb;
						if(type == 'clear')
						{	
							$('input[name="option_'+$split_id[6]+'"]').prop('checked', false);
							var changeTag = $(".question_number_count_"+question_number_count);
							if(changeTag.hasClass(A))
								changeTag.removeClass(A);
							else if(changeTag.hasClass(B))
								changeTag.removeClass(B);
							else if(changeTag.hasClass(D))
								changeTag.removeClass(D);
							else if(changeTag.hasClass(C))
								changeTag.removeClass(C);
							
							changeTag.addClass(E);
							elapsed = getElapsedTime();
							userOb = {user:user_id,q_id: questions_id,course:paper_category_id,elapsed:elapsed,lang:lang_val};
						}	
						else if(type == 'save')
						{
							var changeTag = $(".question_number_count_"+question_number_count);
							if(question_number_count == last_question)
							{
								question_number_count %= last_question;
							}	
							var nextTag = "question_number_count_"+(parseInt(question_number_count)+1);
							if($('input[name="option_'+$split_id[6]+'"]').is(":checked"))
							{
								var	question_answer = $('input[name="option_'+$split_id[6]+'"]:checked').next(),
									question_answer_split = question_answer.attr('id').split('opt_'),
									question_answer_id = question_answer_split[1];
							}
							//console.log("option:"+question_answer_id);
							var correct_option = -1;
							for(var i = 1; i<=6;i++)
							{
								if(i == (question_answer_id))
								{
									correct_option = i;
									break;
								}	
							}
							if(correct_option == -1)
							{
								alert("No answer is selected.");
								return false;
							}
							if(changeTag.hasClass(A))
								changeTag.removeClass(A);
							else if(changeTag.hasClass(B))
								changeTag.removeClass(B);
							else if(changeTag.hasClass(D))
								changeTag.removeClass(D);
							else if(changeTag.hasClass(C))
								changeTag.removeClass(C);
							else if(changeTag.hasClass(E))
								changeTag.removeClass(E);
							
							changeTag.addClass(F);
							set_Click(nextTag,parseInt(question_number_count)+1);
							elapsed = getElapsedTime();
							userOb = {user:user_id,q_id: questions_id,course:paper_category_id,option_selected:correct_option,elapsed:elapsed,lang:lang_val};
							
						}
						else if(type == 'mark')
						{
							if($('input[name="option_'+$split_id[6]+'"]').is(":checked"))
							{
								var	question_answer = $('input[name="option_'+$split_id[6]+'"]:checked').next(),
									question_answer_split = question_answer.attr('id').split('opt_'),
									question_answer_id = question_answer_split[1];
							}
							var correct_option = -1;
							var flag = 0;
							var changeTag = $(".question_number_count_"+question_number_count);
							if(question_number_count == last_question)
							{
								question_number_count %= last_question;
							}	
							var nextTag = "question_number_count_"+(parseInt(question_number_count)+1);
							//console.log("option:"+question_answer_id);
							for(var i = 1; i<=6;i++)
							{
								if(i == (question_answer_id))
								{
									correct_option = i;
									flag = 1;
									break;
								}	
							}
							if(flag)
							{	
								if(changeTag.hasClass(B))
								changeTag.removeClass(B);
							else if(changeTag.hasClass(A))
								changeTag.removeClass(A);
							else if(changeTag.hasClass(C))
								changeTag.removeClass(C);
							else if(changeTag.hasClass(E))
								changeTag.removeClass(E);
								changeTag.addClass(I);
							}
							else
							{
								if(changeTag.hasClass(A))
								changeTag.removeClass(A);
							else if(changeTag.hasClass(D))
								changeTag.removeClass(D);
							else if(changeTag.hasClass(C))
								changeTag.removeClass(C);
							else if(changeTag.hasClass(E))
								changeTag.removeClass(E);
							changeTag.addClass(G);
							}
							set_Click(nextTag,parseInt(question_number_count)+1);
							elapsed = getElapsedTime();
							userOb = {user:user_id,q_id: questions_id,course:paper_category_id,option_selected:correct_option,elapsed:elapsed,lang:lang_val}
						}
						return (userOb);
						
					}
					function set_Click(eClass,counting)
					{
						$self = document.getElementsByClassName(eClass)[0];
						//console.log($self,eClass);
						var classes="-";
						$class_split = $self.className.split(' ');
						
						$required_class_name = $class_split[2];
						$class_array = $required_class_name.split('-');
						$class_array.forEach(function(item){
							if(item != "not" && item != "selected"){classes+=item;}
							});
						if(classes == "-")
						{
							$class = "not-selected";
							$rclass = "selected";
						}
						else
						{
							$class = "not-selected"+classes;
							$rclass = "selected"+classes;
						}
						if(hasClass($self,$class))
						{
							$self.classList.remove($class);
							$self.classList.add($rclass);
						}
						question_count = counting;
					}
					function remove_Click(eClass)
					{
						$self = document.getElementsByClassName(eClass)[0];
						//console.log($self,eClass);
						var classes="-";
						$class_split = $self.className.split(' ');
						
						$required_class_name = $class_split[2];
						$class_array = $required_class_name.split('-');
						$class_array.forEach(function(item){
							if(item != "not" && item != "selected"){classes+=item;}
							});
						if(classes == "-")
						{
							$class = "not-selected";
							$rclass = "selected";
						}
						else
						{
							$class = "not-selected"+classes;
							$rclass = "selected"+classes;
						}
						if(hasClass($self,$rclass))
						{
							$self.classList.remove($rclass);
							$self.classList.add($class);
						}
					}
					function hideElement(qNumber,id)
					{
						//console.log(qNumber,id);
						$element = document.getElementById("getQuestion_"+qNumber+"_id_"+id);
						$element2 = document.getElementById("select_qOption_"+id);
						
						$element.classList.add("hide");
						$element2.classList.add("hide");
						return 1;
					}
					function showElement(qNumber,id)
					{
						//console.log(qNumber,id);
						$element = document.getElementById("getQuestion_"+qNumber+"_id_"+id);
						$element2 = document.getElementById("select_qOption_"+id);
						$element.classList.remove("hide");
						$element2.classList.remove("hide");
						return 1;
					}
					function alertPopup()
					{
						var m_modal = $('#msgBox'),
							m_body= $("#msg");
						$("#modal-class").removeClass("modal-lg").addClass("modal-sm");
						m_body.html("<p><font color=red>Do you want to Submit the Paper.<br>No further changes would be possible.<br>If Yes, press OK</font></p>");
						m_modal.modal("show");
						submit = 1;
					}
					$("#msgOK").on('click',function(e){
						if(submit)
						{
							var time_taken =time - c;
							var q_cat_id = paper_category_id;
							var attempted = 1;
							var paperOb = {time:time_taken,category:q_cat_id,user:user_id,attempted:attempted,finish:1};
							$.ajax({
							url:'processSubmission.php',
							type:'post',
							dataType:'json',
							data:{submit:paperOb},
							cache:false,
							success: function(res){
								/*m_title.html('<h2>PAPER FINISHED</h2>');
								m_body.html('<p class="text-color-text-green">Paper is finished</br>Press Ok To Logout.</p>');
								m_modal.modal('show');*/
								$.blockUI({ message: '<div class="text-center"><p>Paper is finished...<br>Saving your Result<br>Please do not refresh</p><div class="loader col-center"></div></div>' });
								
								setTimeout(function() {page("../index.php");},3000);
							},
							error:function(err){
								console.log(JSON.stringify(err));
							}
							});
						}
					});
					$('#submit').on('click',function(e){
						e.preventDefault();
						alertPopup();						
					});
					$('[name="save_next"]').on('click',function(e){
						e.preventDefault();
						$self = $(this);
						$id = $self.attr('id');
						dataObject = saveUserSelection($id,'save');
						$qNumber = $id.split('_')[4];
						$qID = $id.split('_')[6];
						if($qNumber == last_question)
						{
							$next_question = 1;
						}
						else
							$next_question = parseInt($qNumber)+1;
						$nextQElement = $('[name="question_entry_'+$next_question+'"]').attr('id');
						$nextQID = $nextQElement.split('_')[3];
						$category = getCurrentQCategory($nextQID);
						changeCategory($category);
						if(dataObject)
						$.ajax({
							url:'saveUserAnswer.php',
							type:'POST',
							dataType:'JSON',
							data:{data:dataObject},
							cache:false,
							success: function(res){
								if(res['response'] == 1)
								{
									question_time_elapsed = 0;
									hideElement($qNumber,$qID);
									showElement($next_question,$nextQID);
									$("#currentQuestion").val($nextQID);
								}
								else
								{
									console.log("failed :"+JSON.stringify(res));
								}
							},
							error: function(err){
								console.log("error :"+JSON.stringify(err));
							}							
						});	
						
					});
					$('[name="mark_next"]').on('click',function(e){
						e.preventDefault();
						$self = $(this);
						$id = $self.attr('id');
						
						dataObject = saveUserSelection($id,'mark');
						
						$qNumber = $id.split('_')[4];
						$qID = $id.split('_')[6];
						if($qNumber == last_question)
						{
							$next_question = 1;
						}
						else
							$next_question = parseInt($qNumber)+1;
						$nextQElement = $('[name="question_entry_'+$next_question+'"]').attr('id');
						$nextQID = $nextQElement.split('_')[3];
						$category = getCurrentQCategory($nextQID);
						changeCategory($category);
						$.ajax({
							url:'markUserAnswer.php',
							type:'POST',
							dataType:'JSON',
							data:{data:dataObject},
							cache:false,
							success: function(res){
								if(res['response'] == 1)
								{
									question_time_elapsed = 0;
									hideElement($qNumber,$qID);
									showElement($next_question,$nextQID);
									$("#currentQuestion").val($nextQID);
								}
								else
								{
									console.log("failed :"+JSON.stringify(res));
								}
							},
							error: function(err){
								console.log("error :"+JSON.stringify(err));
							}							
						});
					});
					
					function fetchQuestion(newID,qNumber)
					{
						var lang_val = $('#view_in option:selected').val();
						var selected,elapsed;
			
						elapsed = getElapsedTime();
						//return (userOb = {user:user_id,id:getCurrentQId(),course:paper_category_id,option_selected:correct_option,category_wise:0,lang:lang_val,elapsed:elapsed});
						return (userOb = {user:user_id,id:getCurrentQId(),category:paper_category_id,lang:lang_val,elapsed:elapsed});
					}
					function changeCategory(category)
					{
						$("#question_selected_category").html(category);
					}
				$('[name="q_category"]').on('click',function(e){
						e.preventDefault();
						var selected,elapsed;
						var lang_val = $('#view_in option:selected').val();
						var q_cat_id_full = $(this).attr('id');
						var q_cat_id_split = q_cat_id_full.split('q_category_');
						var q_cat = q_cat_id_split[1];
						
						$currentQID = getCurrentQId();
						$currentQNumber = getCurrentQNumber($currentQID);
						$nextElement = $('[rel="'+q_cat+'"]').attr('id');
						$splitNextElement = $nextElement.split('_');
						$nextQID = $splitNextElement[3];
						$nextQNumber = $splitNextElement[1];
						$category = getCurrentQCategory($nextQID);
						changeCategory($category);
						var nextTag = "question_number_count_"+$nextQNumber;
						var currentTag = "question_number_count_"+$currentQNumber;
						dataObject = fetchQuestion($nextQID,$nextQNumber);
						if($currentQNumber != $nextQNumber)
						{	
							remove_Click(currentTag);
							set_Click(nextTag,$nextQNumber);
						}	
						$.ajax({
							url:'fetchQuestion.php',
							type:'POST',
							dataType:'JSON',
							data:{data:dataObject},
							cache:false,
							success: function(res){
								if(res['response'] == 1)
								{
									question_time_elapsed = 0;
									hideElement($currentQNumber,$currentQID);
									showElement($nextQNumber,$nextQID);
									$("#currentQuestion").val($nextQID);
										
								}		
								else
								{
									console.log("failed :"+JSON.stringify(res));
								}
							},
							error: function(err){
								console.log("error :"+JSON.stringify(err));
							}
						});
					});
			$('[name="question_count"]').on('click',function(e){
						e.preventDefault();
						$that = $(this);
						question_id_full = $that.attr('id');
						question_id_split = question_id_full.split('question_no_');
						$qID = question_id_split[1];
						
						$qNumber = getCurrentQNumber($qID);
						$currentQID = getCurrentQId();
						$currentQNumber = getCurrentQNumber($currentQID);
						$category = getCurrentQCategory($qID);
						changeCategory($category);
						var nextTag = "question_number_count_"+$qNumber;
						var currentTag = "question_number_count_"+$currentQNumber;
						dataObject = fetchQuestion($qID,$qNumber);
						if($currentQNumber != $qNumber)
						{	
							remove_Click(currentTag);
							set_Click(nextTag,$qNumber);
						}
						$.ajax({
							url:'fetchQuestion.php',
							type:'post',
							dataType:'json',
							data:{data:dataObject},
							cache:false,
							success: function(res){
								if(res['response'] == 1)
								{
									question_time_elapsed = 0;
									hideElement($currentQNumber,$currentQID);
									showElement($qNumber,$qID);
									$("#currentQuestion").val($qID);
								}
								else
								{
									console.log("failed :"+JSON.stringify(res));
								}
							},
							error: function(err){
								console.log("error :"+JSON.stringify(err));
							}
						});
					});
					$(".modal").on("hidden.bs.modal", function(){
						var m_modal = $('#msgBox'),
							m_body= $("#msg"),
							m_title = $('#msgTitle');
							m_title.html("Attention!!!");
							m_body.html("");
							newcategory = 0;
					});	
			$('[name="clear"]').on('click',function(e){
						e.preventDefault();
						$self = $(this);
						$id = $self.attr('id');
						
						dataObject = saveUserSelection($id,'clear');
						
						$qNumber = $id.split('_')[4];
						$qID = $id.split('_')[6];
						//console.log(dataObject);
						$.ajax({
							url:'clearUserAnswer.php',
							type:'POST',
							dataType:'JSON',
							data:{data:dataObject},
							cache:false,
							success: function(res){
								if(res['response'] == 1)
								{
									question_time_elapsed = 0;
								}
								else
								{
									console.log("failed :"+JSON.stringify(res));
								}
							},
							error: function(err){
								console.log("error :"+JSON.stringify(err));
							}
						});
					});	
					$("#instructions").on('click',function(e){
						e.preventDefault();
						var m_modal = $('#msgBox'),
							m_body= $("#msg"),
							m_title = $('#msgTitle');
							$("#modal-class").removeClass("modal-sm").addClass("modal-lg");
							m_title.html("Instructions For The Exam");
							m_body.html("<iframe src=frameinstructions.html width=100% height=60%></iframe>");
							m_modal.modal('show');
					});
				});