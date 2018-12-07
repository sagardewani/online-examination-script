# Hetrotech
Hetrotech Projects
/*
	*** GIVE US CREDITS TO USE ***
You can change, replace, modify this patch as you want but you have to give credits to Us by including our website name : HetroTech and our website url: www.hetrotech.in on your web pages of this pack. Until you are giving us credits you are free to use it as you want.

*/
Hetrotech Online Portal
Hetortech Online Portal is an Examination Website that allows you conduct exams globally with a wide variety of functionality. This program allow candidates to face the issues(or scenario of examination) before their actual examination.
This is a simulation of Online Examination. Where Candidate Give thier exams as they give at Exam center. This program is focused to provide the actual examination environment.
Hetrotech Online Portal Website contains PHP, HTML, CSS, JS, TXT and other script and document based files that may be usable for documentation as well as website functioning.
This patch contains about 238 or above files with minimum size of 3.66 MB. Every files in this patch have its own functionality and operation require or require not for functioning of website or for test or further modification purposes. Some functionalities are not available or for the person to change accordingly who has purchased this script. This patch also contains MIT License.
#List of High Level Directory or files Patch Contains:
1)	Admin Folder
2)	User(or user) Folder
3)	Classes(or classes) Folder
4)	Css(or css)	Folder
5)	font-awesome-4.7.0.rar
6)	Images(or images) Folder
7)	Img(or img) Folder
8)	Includes(or includes) Folder
9)	Js(or js) Folder
10)	Notes(or notes) Folder
11)	Plugins(or plugins)	Folder
12)	index.php
13)	LICENSE.txt
14)	README.md

/****
FEATURES:-
	* Semi Responsive Bootstrap Layout.
	* Flexible User Interface.
	* Support of Powerful TinyMCE HTML Editor.
	* Easy to Modify.
	* SQL Injection Prevention.
	* Modular Source Code.
	* How To Help Guides for User and Admin.
	* Faster Response.
	* Secure Database Connectivity.
	* Easily Managable Code.
	* Compaitable to all latest browser (Chrome,FireFox,etc.)
	* Easy to setup just extract and enjoy.
	* PHP PDO Support.
	* Virtual Keyboard Support for users.
	* Actual Examination Simulation.

****/

Before use please follow these instructions to set up your server database connectivity:-
	SETUP DATABASE CONNECTIVITY:-
	
	-> open includes >> config.php :-
									Replace DBUSER => with your Database User name
									Replace DBPASS => with your Database User password
	-> now open "DB.sql" and copy its content and paste in SQL tab in phpmyadmin and execute it.
	-> Afte successful execution extract "finalproduct.zip" in your website directory (say you have uploaded your file in root folder).
	
	SETUP YOUR SITE DETAILS:-
	
	-> open includes >> sitedetails.php:-
									Replace Your Website details with default details;
	
	-> Please change the details of help.html file inside "notes/help.html" & "notes/user/help.html" as you want.
	
 ** ADMIN AREA **
 
	ACCESS ADMIN CONTROLS:-
	
	-> Once you have setup the database and extracted the "finalproduct.zip" file on your website. And Copy all the files inside it and move to root folder. Head on the "www.yourwebsiteurl.com/admin/"
	-> Now enter these details:-
	-> The default Admin password and Username is:
			Username : Hetrotech
			Password : default
	-> Block it after you have added new admin. To add new admin go to -> Add Tab(of admin dashboard) >> Admins(of Add Tab), Add admin details here and click on ADD ADMIN button. A popup will occur saying Admin has added Successfully.
	-> To Block or review admin go to "View >> Admins"
	
	PAPER EDITOR:-
	
	-> Paper Editor Allows your to edit new papers with a powerful editing. Just fill the required information and you will be redirected to Question adding Tab
	-> Click on "Next" to add your new paper. 
	-> After click on "Next" you will be redirected to "questionlayout.php" to add your questions just fill the details of questions and click on "Save" button.
		
			Button Information :-
						1) Save - To Save your question.
						2) Edit - To edit question and other information.
						3) Cancel - To reset question form.
						4) Submit Paper - To end paper editing.
			Other Features:-
						1) Options  Tab - You can select number of options maximum 6
						2) Question Type - Specify the type of question category such as (general, reasoning, etc...)
						3) Type - Specify question type such as (Regualr or normal, Paragraphical)
						4) Image - Default No, Specify that question doesn't contain any Image.
						5) Paper Set - Shows the set no. paper editing currently.
						6) Question Related - When you choose "Type -> Paragraphical or Other" then this option become active here you have to specify number of question related with paragraph.
			Help : Video available at that link www.youtube.com/hetrotech?video=xxxx
	ADD Tab:-
			1) User Courses - Enroll already existed user in new courses available.
			2) User - Add New User so that he would be able to login at User Area (www.example.com)
			3) Admin - Add New Admins.

	VIEW Tab:-
			1) Papers - Activate, Deactivate, edit and view already existed papers.
			2) Admins - Block, Unblock and Analyze Already Existed admins.
			3) User - View particular user area and details.
	
	ACTIVATE Tab:-
			1) User Courses - As your enroll the user into Course you have to activate user course. Activate, Deactivate user courses from here.
			2) User - To activate, deactivate and alayze user details.
			
			
 ** USER AREA **			

	-> user area will open as soon as someone click on your website link (say www.example.com) OR if you have put your website in some subfolder then (say www.example.com/subfolder)
	
	USER FEATURES:-
	
		1) PROFILE - Show user details
		2) SIGNOUT - To Logout logged in users or destroy the sessions.
		3) Contact Us - To contact the site owner (you have to change it manually from : "includes >> sitedetails.php", search for "$site_contact_us" variable and change the link provided there).
		4) New Updates - This feature is not added yet(if you want to add this contact us)or create yourself manually.
		5) Help - To read Help documentation for user operation.
		6) The table on User Area show all courses active papers in which user is enrolled with details.
				-> Title : Title show the name of the exam.
				-> Time : Show the user timing slot in 24 hour format.
					This slot is decided by the admin only. Once it is saved, no change would be further possible.
					User can take exams only during this timing slot or within next (15 minutes) duration of timing slot.
				-> Take Exam : This feature enable user to give the exam if it is active.
						The user will be forced to accept Instructions Before the examination starts.
						The verification process will be done before user attempt to take the examination(or starting of quiz).
						User will receieve the error messages:-
								USER SITUATIONS																ERROR MESSAGE OR ACTIONS
							a)If user is not logged in 													User will be redirected to login page.
							b)If there is no paper active(or available) of the category choosen			Maybe paper of this category is not active yet. 
							c)If candidate have not attempt the paper during specified time slot		Your time has been passed please come tomorrow.
							  or within 15 minute duration.
							d)If candidate has already attempted the paper and finished it.				Paper is Finished Yet.
							e)If candidate attempt the paper and the timing duration of 				Paper is not available.
							the examination	has over already.
				-> View Exam : This feature enable user to check their result.
							a)If  user have not attempted the exam and finished it yet then it would not show the result of specified exam.
							b) View result shows the result data of specific candidate.
								-> Score card: It show the candidate score during the specific exam.
								-> Solution Report: It shows the questions with their correct solutions.
								-> Question Report: It shows the complete report of candidate performance during exam.
				-> Status : This shows the status of paper course, i.e, it shows wether the specified course is currently active or not it does not show the paper is active yet or not.
				
		7) If due to some techincal or electrical fault candidate get disconnected from examination then candidate can re-appear the exam within examination time. And the user saved data will be retrieved from server
		but the exam clock will not be initialized again, and it will be set to the remaining time from first time appearing of candidate to the examination.
		
 ** FOR MORE INFORMATION **
	Visit at (https://www.youtube.com/channel/UCoxX5ZbA81RaiP-sWGMUO5g) to watch the video on all features and their usage.This is link to our youtube channel.
		