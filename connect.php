<?php


/* Site config */
//Database Config
$db_host		= 'EDIT ME'; //probley localhost
$db_user		= 'EDIT ME';
$db_pass		= 'EDIT ME';
$db_database	= 'EDIT ME'; 
//END DATABASE
//LDAP Config
$ldapPort = '389'; //LDAP Port
$ldapsPort ='636'; //LDAPS Port The server cert must be signed or imported into the server key store
$userAccountSuffix = '@domain.example.com' //your domain suffix, for example our domain is garr.org so for us it is @garr.org
$userBaseDn = 'DC=DOMAIN, DC=EXAMPLE, DC=COM'; //your base dn for authenticiation, this can also drill down to OUs
$ldapServers = Array('DC.domain.example.com'); //the address of your domain controller, you can add more in the form on an array
$domainAdminUser ='Administrator'; //the username of the account you want to use to bind to the domain, I recomened that this is the Domain Admin
$domainAdminPassword = 'PASSWORD'; //the password of the previous account
$LDAPadminGroup = 'CanAdmins' //the LDAP group that has admin privs on the site, this DOES NOT have to be domain admins
$LDAPuserGroup ='CanUsers' //The ladp group that can login, a standard user
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