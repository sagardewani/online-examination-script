<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('Asia/Calcutta');

//database credentials
define('DBHOST','localhost');
define('DBUSER','root');
define('DBPASS','');
define('DBNAME','hetrotec_exams');


try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
//dirname(__FILE__) - provides the absolute path of directory instead of relative path which is a bad practice
include(dirname(__FILE__).DIRECTORY_SEPARATOR.'../classes/user.php');
$user = new User($db);
?>
