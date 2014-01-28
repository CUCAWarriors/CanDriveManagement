<?php
	//Start session
	
	session_start();
	
	//Include database connection details
	//require_once('connect.php');
include 'adLDAP/src/adLDAP.php';
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Connect to mysql server
	
	//Select database
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$login = $_POST['login'];
	$password = $_POST['password'];
	//Input Validations
	
	//If there are input validations, redirect back to the login form
		
	//Create query
	/*$qry="SELECT * FROM users WHERE uname ='$login' AND passwd='$password'";
	$result=mysql_query($qry);
	$member=mysql_fetch_array($result);*/
$adldap = new adLDAP();
$adldap->connect();

$authUser = $adldap->authenticate($login, $password);


//Check whether the query was successful or nots
	if($authUser) {
$ingroup=$adldap->user()->ingroup($login ,"ReservationUsers");
$inadmin=$adldap->user()->ingroup($login ,"ReservationAdmin");
if ($ingroup) {
		//if(mysql_num_rows($result) == 1) {
			//Login Successful
			$inadmin=$adldap->user()->ingroup($login ,"ReservationAdmin");
			//echo $inadmin;
			if ($inadmin) {
			$_SESSION['ADMIN'] = '1';
			}
			$_SESSION['USER_ID_ADMIN_LIBRARY']= 'AUTH'; 
			$_SESSION['SESS_MEMBER_ID'] = 'AUTH';
			$_SESSION['ADMIN'] = '1';		
$_SESSION['AUTH'] = 'YES';	
$_SESSION['USERNAME'] = $login;			
			
			header("location: index.php");
			exit();
		} 
else {
			//Login failed
			header("location: index.php?error=nogroup");
			exit();
		}
}
else {
header("location: index.php?error=noaccount");
			exit();
}
	?>
