<?php
define('INCLUDE_CHECK',true);

require 'connect.php';
require 'functions.php';
include 'adLDAP/src/adLDAP.php';
// Those two files can be included only if INCLUDE_CHECK is defined


session_name('tzLogin');
// Starting the session

session_set_cookie_params(2*7*24*60*60);
// Making the cookie live for 2 weeks
session_start();

if (isset($_SESSION['id'])){
if($_SESSION['id'] && !isset($_COOKIE['tzRemember']) && !$_SESSION['rememberMe'])
{
	// If you are logged in, but you don't have the tzRemember cookie (browser restart)
	// and you have not checked the rememberMe checkbox:

	$_SESSION = array();
	session_destroy();
	
	// Destroy the session
}

}
if(isset($_GET['logoff']))
{
	$_SESSION = array();
	session_destroy();
	
	header("Location: index.php");
	exit;
}
if (isset($_POST['submit'])) {
if($_POST['submit']=='Login')
{
	// Checking whether the Login form has been submitted
	
	$err = array();
	// Will hold our errors
	
	
	if(!$_POST['username'] || !$_POST['password'])
		$err[] = 'All the fields must be filled in!';
	
	if(!count($err))
	{
		
		$_POST['rememberMe'] = (int)$_POST['rememberMe'];
		}
		// Escaping all input data
$adldap = new adLDAP();
$adldap->connect();

$authUser = $adldap->authenticate($_POST['username'], $_POST['password']);


//Check whether the query was successful or nots
	if($authUser) {
	
$ingroup=$adldap->user()->ingroup($_POST['username'] ,"ReservationUsers");
$inadmin=$adldap->user()->ingroup($_POST['username'] ,"ReservationAdmin");
		

		if($ingroup)
		{
		$ui=$adldap->user()->infoCollection($_POST['username'], array("*"));
$dp= $ui->displayName;
$em= $ui->mail;
			// If everything is OK login
			
			$_SESSION['usr']= $_POST['username'];
			$_SESSION['usr_email'] = $em;
			$_SESSION['id'] = $_POST['username'];
			$_SESSION['name'] = $dp;
			$_SESSION['rememberMe'] = $_POST['rememberMe'];
			if ($inadmin) {
			$_SESSION['admin'] = true;
			}
			// Store some data in the session
			
			setcookie('tzRemember',$_POST['rememberMe']);
		}
		else $err[]='Wrong username and/or password!';
	}
	else $err[]='Wrong username and/or password!';
	if($err)
	$_SESSION['msg']['login-err'] = implode('<br />',$err);
	// Save the error messages in the session


}
}
$script = '';

if(isset($_SESSION['msg']))
{
	// The script below shows the sliding panel on page load
	
	$script = '
	<script type="text/javascript">
	
		$(function(){
		
			$("div#panel").show();
			$("#toggle a").toggle();
		});
	
	</script>';
	
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo '$site_name' ?></title>
    
    <link rel="stylesheet" type="text/css" href="/site.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/login_panel/css/slide.css" media="screen" />
    
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    
    <!-- PNG FIX for IE6 -->
    <!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
    <!--[if lte IE 6]>
        <script type="text/javascript" src="login_panel/js/pngfix/supersleight-min.js"></script>
    <![endif]-->
    
    <script src="/login_panel/js/slide.js" type="text/javascript"></script>
    
    <?php echo $script; ?>
</head>

<body>

<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
			<?if (!isset($_SESSION['usr'])) {?>
				<h1><?=$site_name ?></h1>
				<h2>How To Use:</h2>		
				<p class="grey">Use the system to manage the can drive</p>
				<h2>Help?</h2>
				<p class="grey">Please see the IT administrator<br></p>
				<?}?>
			</div>
            
            
            <?php
			
			if(!isset($_SESSION['id'])):
			
			?>
            
			<div class="left">
				<!-- Login Form -->
				<form class="clearfix" action="" method="post">
					<h1>System Login</h1>
                    
                    <?php
						if (isset($_SESSION['msg']['login-err']))
						if($_SESSION['msg']['login-err'])
						{
							echo '<div class="err">'.$_SESSION['msg']['login-err'].'</div>';
							unset($_SESSION['msg']['login-err']);
						}
					?>
					<p class="grey"><i>Please use your network credentials</i></p>
					<label class="grey" for="username">Username:</label>
					<input class="field" type="text" name="username" id="username" value="" size="23" />
					<label class="grey" for="password">Password:</label>
					<input class="field" type="password" name="password" id="password" size="23" />
	            	<label><input name="rememberMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> &nbsp;Remember me</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Login" class="bt_login" />
				</form>
			</div>
			
            
            <?php
			
			else:
			
			?>
            
            <div class="left">
            
            <h1><?php echo '$site_name' ?></h1>
			<h2>
           <a  href="/page/reports">Reports</a> | <a  href="/page/checkin">Checkin</a>
            </h2>
            </div>
            
            <div class="left right">
            </div>
            
            <?php
			endif;
			?>
		</div>
	</div> <!-- /login -->	

    <!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
	    	<li class="left">&nbsp;</li>
	        <li>Hello <?php if (isset($_SESSION['usr'])) { echo $_SESSION['name']; } else { echo 'Guest';}?>!</li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#">Open Panel</a>
				<a id="close" style="display: none;" class="close" href="#">Close Panel</a>			
			</li>
	    	<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div>
