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

function file_select($what, $file) {
if ($what == 'page') {
$files = array(
'' => 'error',
'checkin' => 'checkin.php',
'reports' => 'reports.php'
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
