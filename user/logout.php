<?php require(dirname(__FILE__).DIRECTORY_SEPARATOR.'../includes/config.php');

//logout
$user->logout(); 

//logged in return to index page
header('Location: ../index.php');
exit;
?>
