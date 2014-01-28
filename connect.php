<?php


/* Database config */

$db_host		= 'EDIT ME'; //probley localhost
$db_user		= 'EDIT ME';
$db_pass		= 'EDIT ME';
$db_database	= 'EDIT ME'; 

/* End config */



mysql_connect($db_host,$db_user,$db_pass) or die('Unable to establish a DB connection');

mysql_select_db($db_database);



?>