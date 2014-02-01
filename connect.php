<?php


/* Site config */
//Database Config
$db_host		= 'EDIT ME'; //probley localhost
$db_user		= 'EDIT ME';
$db_pass		= 'EDIT ME';
$db_database	= 'EDIT ME'; 
//END DATABASE
//LDAP Config
$LDAPadminGroup = 'CanAdmins' //the LDAP group that has admin privs on the site, this DOES NOT have to be domain admins
$LDAPuserGroup ='CanUsers' //The ladp group that can login, a standard user
//configure the rest in adLDAP/src/adLDAP.php
//END LDAP
//Site Config
$site_name= 'EDIT ME'
//END SITE
/* End config */

$db = new mysqli($db_host, $db_user, $db_pass, $db_database);

if($db->connect_error > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}



?>