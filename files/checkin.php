<form method="post" name='form1'>
Last Name: <input type="text" value="<?php if (isset($_POST['term'])) { echo $_POST['term'];} ?>" name="term"/>

<input type="submit" name="submit" />

</form>
<br><br>
<hr>
<?php
if (isset($_POST['submit'])) {

global $db;

$term = $_POST['term'];
//$where = $_GET['where'];



$sql = "select * from students where lastName like '%$term%'";
if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}
$num_rows = $result->num_rows; 

if ($num_rows == 0) {
echo "<font color='red'> <b><i>ERROR:</i> No People Found Please Try Again</b> </font>";
}
while ($row = $result->fetch_assoc()){
	$code = $row['id'];
    $lastName = $row['lastName'];
    $firstName = $row['firstName'];
    echo $lastName . ', ' . $firstName;
    echo '<br>';
    echo "
    <form action='/process' method='post' name='$code'><br><label for='numcans'>Cans:</label><input type='text' name='number_of_cans' id='numcans' /><br>
    <label for='ounces'>Ounces:</label><input type='text' name='ounces' id='ounces' /><br><label for='owes'>Owes:</label> <input type='checkbox' name='owes' id='owescheck'/>
    <input type='text' id='owes'name='owesnum'/><input type='hidden' value='$code' name='stuid' /><input type='submit' value='submit' name='checkin_student'/> <hr>
    ";
	


    }
	}