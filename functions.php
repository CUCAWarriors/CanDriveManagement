<?php

if(!defined('INCLUDE_CHECK')) die('You are not allowed to execute this file directly');

function checkEmail($str)
{
	return preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", $str);
}


function send_mail($from,$to,$subject,$body)
{
	$headers = '';
	$headers .= "From: $from\n";
	$headers .= "Reply-to: $from\n";
	$headers .= "Return-Path: $from\n";
	$headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "Date: " . date('r', time()) . "\n";

	mail($to,$subject,$body,$headers);
}

function dbRowInsert($table_name, $form_data)
{
    // retrieve the keys of the array (column titles)
    $fields = array_keys($form_data);

    // build the query
    $sql = "INSERT INTO ".$table_name."
    (`".implode('`,`', $fields)."`)
    VALUES('".implode("','", $form_data)."')";

    // run and return the query result resource
    return mysql_query($sql);
}


function num_available($fmonth, $fday = 0, $fyear = 0, $ftime = 0, $fm, $type, $time = 0, $the_asset_id = 0) {
if (isset($time) and $time != 0){
$i = 0;

if($the_asset_id == 0) {
$result = mysql_query("select * from assets where type_id = $type");
}
else {
$result = $the_asset_id;

$result1 = mysql_query("SELECT count(*) as data from reservations WHERE asset_id=$result AND
start = $time") or die (mysql_error());

//$num = mysql_result($numquery, 0);

if ($result1) {
$data=mysql_fetch_assoc($result1);
$numquery= intval($data['data']);
 
//$numarray = mysql_fetch_array($numquery);
//var_dump($numquery);
if ($numquery == 0) {
//echo 1;
return true;
//echo 'test';


} 
else {
return false;
} 
}

}



while($row = mysql_fetch_array($result)) {
//echo 'test';
$assetid= $row['id'];
$result1 = mysql_query("SELECT count(*) as data from reservations WHERE asset_id=$assetid AND
start = $time") or die (mysql_error());

//$num = mysql_result($numquery, 0);

if ($result1) {
$data=mysql_fetch_assoc($result1);
$numquery= intval($data['data']);
 
//$numarray = mysql_fetch_array($numquery);
//var_dump($numquery);
if ($numquery == 0) {
//echo 1;
$i = $i +1;
//echo 'test';
} 
}
}
return $i;
}
$date="$fmonth-$fday-$fyear $ftime:00:00";
$utime = mktime($ftime, $fm, 0, $fmonth, $fday, $fyear);

$result = mysql_query("select * from assets where type_id = $type and available = 1 ");

$i = 0;


while($row = mysql_fetch_array($result)) {
//echo 'test';
$assetid= $row['id'];
$result1 = mysql_query("SELECT count(*) as data from reservations WHERE asset_id=$assetid AND
start = $utime") or die (mysql_error());

//$num = mysql_result($numquery, 0);

if ($result1) {
$data=mysql_fetch_assoc($result1);
$numquery= intval($data['data']);
 
//$numarray = mysql_fetch_array($numquery);
//var_dump($numquery);
if ($numquery == 0) {
//echo 1;
$i = $i +1;
//echo 'test';
} 
}
}

return $i;
}

function file_select($what, $file) {
if ($what == 'reserve') {
$files = array(
'' => 'reserve1.php',
'one' => 'reserve1.php',
'two' => 'reserve2.php',
'three' => 'reserve3.php'
);

if (array_key_exists($file, $files)) {
include 'files/'. $files[$file];
return;

}
else {
http_response_code(404);
return <<<END
These are not the drones you are looking for...
 <p style="text-align:right; font-family: &quot;Trebuchet MS&quot;,Arial, Helvetica, sans-serif;&quot;"></p><h1 style="font-size:900%; font-family: &quot;Trebuchet MS&quot;,Arial, Helvetica, sans-serif;&quot;" align="right">404 Error</h1><p></p>
END;
}
}
elseif ($what == 'page') {
$files = array(
'lookup' => 'lookup.php',
'incident' => 'incident.php',
'404error' => 'error404.php'
);

if (array_key_exists($file, $files)) {
include 'files/'. $files[$file];
return;
}
}
elseif ($what =='admin') {
$files = array(
'' => 'admin_home.php',
'home' => 'admin_home.php',
'add' => 'admin_add.php',
);

if (array_key_exists($file, $files)) {
include 'files/'. $files[$file];
return;

}
else {
http_response_code(404);
return <<<END
These are not the drones you are looking for...
 <p style="text-align:right; font-family: &quot;Trebuchet MS&quot;,Arial, Helvetica, sans-serif;&quot;"></p><h1 style="font-size:900%; font-family: &quot;Trebuchet MS&quot;,Arial, Helvetica, sans-serif;&quot;" align="right">404 Error</h1><p></p>
END;
}
}


else {
http_response_code(404);
return <<<END
These are not the drones you are looking for...
 <p style="text-align:right; font-family: &quot;Trebuchet MS&quot;,Arial, Helvetica, sans-serif;&quot;"></p><h1 style="font-size:900%; font-family: &quot;Trebuchet MS&quot;,Arial, Helvetica, sans-serif;&quot;" align="right">404 Error</h1><p></p>
END;
}

}

function generate_confimation($fh, $ftype, $frequested, $fusername, $end, $start) {

$assetquery = mysql_query("SELECT * FROM assets WHERE type_id = $ftype") or die(mysql_error());
if (false === $assetquery) {
    die( mysql_error());
	
} 



$item = mysql_fetch_array($assetquery) or die('ERROR OCCURED' . mysql_error());
mysql_query("INSERT INTO transactions (end, user, start) VALUES ('$end', '$fusername', $start)") or die(mysql_error());
$txn = mysql_insert_id();
//echo $txn . '<br>';
$the_time1 = 0;
$frequested = intval($frequested);

//var_dump($fh);
foreach($fh as &$time){
$i = 0;
$the_time2 = 0;
foreach($fh as $time1) {
$the_time1++;
$time1= $time1;

$theyear= date("Y", $time1);
$themonth= date("m", $time1);
$theday = date("d", $time1);
$themin = date("i", $time1); 
$thehr = date("H", $time1);

$num =  num_available( $themonth , $theday , $theyear, $thehr , $themin ,$ftype);
$time1= $time1;
//var_dump($num);
//echo "$num $frequested ";
//$frequested = $frequested -1;
if ($num < $frequested) {

return(array(
'error' => 'error01',
'num' => $num,

));
}

//$frequested++;


}




$r = 0;

while($row = mysql_fetch_array($assetquery)) {

$a = 0; 

$aID= $row["id"];
//var_dump($aID);

$indatabase = mysql_query("SELECT count(*) from assets WHERE type_id = $ftype") or die (mysql_error());
$indatabase=mysql_fetch_row($indatabase);
$indatabase= intval($indatabase[0]);
foreach($fh as $time) {
 $aa = mysql_query("SELECT count(*) from reservations WHERE start = $time and asset_id = $aID") or die (mysql_error());
$aa=mysql_fetch_row($aa);
$aa = $aa[0];
$aa= intval($aa);//  or die (mysql_error());
//var_dump($aa);
//var_dump($NumberAssets);
if ($aa > 0) {
$a++;

//continue;
}

}


$sql_data = array(
    'txnid' => $txn,
    'user' => $fusername,
    'asset_id' => $aID,
    
);

if ($a > 0) {
continue;
}
//var_dump($ava);




foreach($fh as $time) {

$sql_data['start'] = $time;
//ECHO $r;
$insert = dbRowInsert('reservations', $sql_data)  or die ('256: ' . mysql_error());
//var_dump( $insert);
if ($insert) {

}

//echo $a;

}




//$frequested = $frequested - 1;

//var_dump($frequested);
if ($frequested == 0) {
//var_dump($frequested);
//echo $r;
echo 'test2';
return $txn;
}
//$frequested = $frequested - 1;
}
//echo 'test';
return $txn;







}
echo 'test2';
return $txn;
}

function make_txn_table($txn_id, $uname) {
//echo 'test';
/*
$totalassets = mysql_query("SELECT count(*) as data from reservations WHERE txnid = $txn_id") or die ('test' . mysql_error());
$data=mysql_fetch_row($totalassets);
$totalassets= intval($data[0]);
if ($totalassets < 1) {
return "<font color='red'>ERROR:</font>That Transaction ID cannot be found please double check your entry and try again";
}
*/
/*
echo $uname;
$useraccess = mysql_query("SELECT id from transactions WHERE id = $txn_id and user = $uname");
var_dump( $useraccess);
$totaluser = mysql_num_rows($useraccess);
print_r($useraccess); 
if ($totaluser == 0) {
return <<<END
 Thou Shall Not Pass....
 <p style="text-align:right; font-family: &quot;Trebuchet MS&quot;,Arial, Helvetica, sans-serif;&quot;"></p><h1 style="font-size:400%; font-family: &quot;Trebuchet MS&quot;,Arial, Helvetica, sans-serif;&quot;" align="right">403 Forbidden</h1><p></p>
END;
}
*/

$selectr = mysql_query("SELECT * FROM reservations WHERE txnid = $txn_id");

$fetchassets = mysql_query("SELECT * FROM assets WHERE available = 1") or die('test' . mysql_error());

$sq = mysql_query("SELECT * FROM reservations WHERE txnid = $txn_id") or die('test1' . mysql_error());
$sa = array();
while($row = mysql_fetch_array($sq)) {
$sa[] = $row['start'];

}
//var_dump($sa);
$start1 = min($sa);
$end = max($sa);

$start = date("Y-m-d H:i:s", $start1);
$end = date("Y-m-d H:i:s", $end);
$table = "<pre><table border='1'><tr><td>Reservation Start</td><td>Reservation End</td></tr><tr><td>$start</td><td>$end</td></tr></table><br><br>";

$table .= "<table border='1'><tr><td>Transaction ID</td><td>Asset ID</td><td>Asset Name</td></tr>";
while($row = mysql_fetch_array($fetchassets)) {

$aID = $row["id"];
$aName = $row["name"];

$totalq = mysql_query("SELECT * from reservations WHERE txnid = $txn_id AND asset_id = $aID and start = $start1") or die(mysql_error()); 
$total = mysql_num_rows($totalq);
 if ($total > 0) {

$table.= "<tr><td>$txn_id</td><td>$aID</td><td>$aName</td></tr>";
}

}
$table.= "</table></pre>";

return $table;

}


function make_daily_table() {
$currentyear= date("Y");
$currentmonth= date("m");
$currentday = date("d");
$start =  mktime( 0 , 0 , 0);
$end = mktime(24, 59, 59);
$adldap = new adLDAP();
$adldap->connect();


$query = mysql_query("SELECT * FROM reservations.transactions WHERE start between $start and $end ORDER BY start ASC") or die(mysql_query());
//$test = mysql_fetch_array($query);
//
//echo 'good';
$table = '';
while($fetch = mysql_fetch_array($query)) {
//var_dump($fetch);
$txn_id = $fetch['id'];
$txn_user = $fetch['user'];
//echo $txn_id;
$selectr = mysql_query("SELECT * FROM reservations WHERE txnid = $txn_id");

$fetchassets = mysql_query("SELECT * FROM assets WHERE available = 1") or die('test' . mysql_error());

$sq = mysql_query("SELECT * FROM reservations WHERE txnid = $txn_id") or die('test1' . mysql_error());
$sa = array();
while($row = mysql_fetch_array($sq)) {
$sa[] = $row['start'];

}
//var_dump($sa);
$start1 = min($sa);
$end = max($sa);

$start = date("Y-m-d H:i:s", $start1);
$end = date("Y-m-d H:i:s", $end);
$ui=$adldap->user()->infoCollection($txn_user, array("*"));
$dp= $ui->displayName;
$table .= "<nobreak>";
$table .="<h3>Transaction Number: $txn_id</h3>";
$table.="<h4>Reservation for: $dp</h4>";

$table.= "<pre><table border='1'><tr><td>Reservation Start</td><td>Reservation End</td></tr><tr><td>$start</td><td>$end</td></tr></table><br><br>";

$table .= "<table border='1'><tr><td>Transaction ID</td><td>Asset ID</td><td>Asset Name</td></tr>";
while($row = mysql_fetch_array($fetchassets)) {

$aID = $row["id"];
$aName = $row["name"];

$totalq = mysql_query("SELECT * from reservations WHERE txnid = $txn_id AND asset_id = $aID and start = $start1") or die(mysql_error()); 
$total = mysql_num_rows($totalq);
 if ($total > 0) {

$table.= "<tr><td>$txn_id</td><td>$aID</td><td>$aName</td></tr>";
}

}
$table.= "</table></pre></nobreak>";
;

}
return $table;
}




function add_asset($item_type, $item_name) {
$timestamp = time();
$sql_data = array(
'name' => $item_name,
'available' => true,
'timestamp' => $timestamp,
'type_id' => $item_type,
); 
$insert = dbRowInsert('assets', $sql_data)  or die ('463: ' . mysql_error());

if ($insert) {
return true;
}

}

function readCSV($csvFile){
	$file_handle = fopen($csvFile, 'r');
	while (!feof($file_handle) ) {
		$line_of_text[] = fgetcsv($file_handle, 1024);
	}
	fclose($file_handle);
	return $line_of_text;
}


 
?>
