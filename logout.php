<?php
	//Start session
	session_start();

$v_ip = $REMOTE_ADDR;
$v_date = date("l d F H:i:s");

$fp = fopen("ips.txt", "a");
fputs($fp, "LOGOUT ACTION IP: $v_ip - DATE: $v_date\n\n");
fclose($fp);
	
	//Unset the variables stored in session
	unset($_SESSION['SESS_MEMBER_ID']);
	unset($_SESSION['SESS_FIRST_NAME']);
	unset($_SESSION['SESS_LAST_NAME']);
	unset($_SESSION['AUTH']);
	header("Location: index.php?logout=logout");
?>