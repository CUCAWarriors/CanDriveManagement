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

    return $db->query($sql);
}



// again where clause is left optional
function dbRowUpdate($table_name, $form_data, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    // start the actual SQL statement
    }
    $sql = "UPDATE ".$table_name." SET ";

    // loop and build the column /
    $sets = array();
    foreach($form_data as $column => $value)
    {
         $sets[] = "`".$column."` = '".$value."'";
    }
    $sql .= implode(', ', $sets);

    // append the where statement
    $sql .= $whereSQL;

    // run and return the query result
    return $db->query($sql);
}

// the where clause is left optional incase the user wants to delete every row!
function dbRowDelete($table_name, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add keyword
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // build the query
    $sql = "DELETE FROM ".$table_name.$whereSQL;

    // run and return the query result resource
    return $db->query($sql);
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
