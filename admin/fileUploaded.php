<!--
FILE NAME:fileUploaded.php
PURPOSE:Page for admin once they've uploaded a file. Makes sure the file is right and shows data if it is.
MODIFICATION HISTORY:
11/04/20 Added file header
-->
<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<!---  Needs styling to display message and display table  -->
<?php

// initialize variables
$message="";
$displayData = false;

// make sure an administrator has logged in 
require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/checkForAdmin.php";

// Read the uploaded file and return it in table format if valid
require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/readfile.php";

// If the user verifies, post the data
if(isset($_POST['enter']))
    Header("Location: /n342-final/actions/insertData.php");

// If the user cancels head back to the previous page
if(isset($_POST['cancel']))
		Header("Location: /n342-final/admin/uploadFile.php");

if($displayData){
$student_table = '<table id="students">
                 <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>School</th>
                        <th>City</th>
                        <th>County</th>
                        <th>Grade</th>
                        <th>Gender</th>
                    </tr>
                   </thead>
                   <tbody>'.
                        $students."
                    </tbody>
                    </table>";
$project_table = '<table id="projects">
			<thead>
				<tr>
                    <th>Project Number</th>
					<th>Title</th>
					<th>Abstract</th>
                    <th>Grade</th>
                    <th>Grade Level</th>
                    <th>Category</th>
                    <th>CourseNetworking ID</th>
					<th>Booth</th>
				<tr>
			</thead>
            <tbody>'.
                $projects."    
            </tbody>    
		<table>";  
}
?>
<!DOCTYPE html>
<html lang="en">
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/n342-final/assets/css/w3.css">
<link rel="stylesheet" href="/n342-final/assets/css/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="/n342-final/assets/css/font-awesome.min.css">
<link rel="stylesheet" href="/n342-final/assets/css/our.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.22/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/jq-3.3.1/dt-1.10.22/datatables.min.js"></script>
<script src="js/list.js"></script>
<style>
html,body,h1,h2,h3,h4,h5,h6 {font-family: "Roboto", sans-serif;}
.w3-sidebar {
  z-index: 3;
  width: 250px;
  top: 43px;
  bottom: 0;
  height: inherit;
}
</style>
<body>
<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/n342-final/assets/navbar.php";
require_once $_SERVER["DOCUMENT_ROOT"]."/n342-final/assets/sidebar.php";
?>
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main our-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">
    <h4><?php echo $message; ?></h4>
   	<form method="post" action='#'> 
	<input name="enter" type="submit" value="Verify" /> 
	<input name="cancel" type="submit" value="Don't add" /> 
	</form>
    <div id="tableDiv">The following information will be added to the database if you hit verify(Hit 'Don't add' to go back):</div>
	<?php echo $student_table ?>
    <?php echo $project_table ?>
    <div id="formSpace" class="w3-twothird w3-container">
      <h1 hidden class="w3-text-teal">Form area</h1><br/><br/><br/></br></br></br></br></br></br></br></br>

    </div>
    <div class="w3-third w3-container">

    </div>
  </div>

  <div style="display:none" class="w3-row">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Heading</h1>
    </div>
    <div class="w3-third w3-container">

    </div>
  </div>

  <!-- Pagination -->
  <div style="display:none" class="w3-center w3-padding-32">
    <div class="w3-bar">
      <a class="w3-button w3-black" href="#">1</a>
      <a class="w3-button w3-hover-black" href="#">2</a>
      <a class="w3-button w3-hover-black" href="#">3</a>
      <a class="w3-button w3-hover-black" href="#">4</a>
      <a class="w3-button w3-hover-black" href="#">5</a>
      <a class="w3-button w3-hover-black" href="#">&raquo;</a>
    </div>
  </div>

  <footer id="myFooter">
    <div class="w3-container w3-theme-l2 w3-padding-32">
      <h4>Footer</h4>
    </div>

    <div class="w3-container w3-theme-l1">
      <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
    </div>
  </footer>

<!-- END MAIN -->
</div>

<script src="/n342-final/assets/js/sidebar.js"></script>

</body>
</html>
