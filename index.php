<?php
include 'header.php';


?>


<div class="pageContent">
    <div id="main">
      <div class="container">
        <h1></h1>
        </div>
        
        
        <div class="container">
        <?if (isset($_SESSION['id'])) {
		if (isset($_GET['what'])) {
		if (isset($_GET['step'])) {
		echo file_select($_GET['what'], $_GET['step']);
		
}
elseif (isset($_GET['page'])) {
		echo file_select($_GET['what'], $_GET['page']);
		}
else {
	echo file_select('', '');	
	}
	}
	else {
	
	
		?>
<h3>Please Select from one of the options below</h3>

            
 <br><br>
			<h1>
			
			<center>
		<table border><tr><td>
           <a  href="/page/reports">Reports</a></td><td>
		   
		   <a  href="/page/checkin">CheckIn</a></td>
		   </tr>
		   </table>
		   </center>
		  
            </h1>
           
<?php
if (isset($_SESSION['USER_ID_ADMIN_RES']) and $_SESSION['USER_ID_ADMIN_RES'] == true) {
echo <<<END
<h3>Administration</h3><br>
<button type="button" onClick="parent.location='add-admin.php'">Add Assets</button><br>
<button type="button" onClick="parent.location='reservations-admin.php'">Manage Reservations</button><br>
END;
}
}
}
else {
?> <p>Welcome to the Can Management System please login using the above panel</p>

<?}?>
        </div>
        
      <div class="container tutorial-info">
     This System was Designed by <a href="http://rileychilds.net">Riley Childs</a> and is Licensed under the GNU GPL</div>
    </div>
</div>

</body>
</html>
