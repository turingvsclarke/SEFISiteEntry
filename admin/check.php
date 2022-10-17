<!--
FILE NAME:view.php
PURPOSE:
-->
<?php
    session_start();
    if (isset($_SESSION["user"])) {
        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
        $email = $_SESSION["user"];
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
require_once "../assets/navbar.php";
require_once "../assets/sidebar.php";
?>
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main our-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">


    <!--
work here 
-->


<?php
   $dbhost = 'localhost';
   $dbuser = 'ryeades';
   $dbpass = 'ryeades';
   
   $conn = mysql_connect($dbhost, $dbuser, $dbpass);
   
   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
   
   $sql = 'SELECT ProjectNumber, ProjectID, Title, AverageRanking  
			FROM PROJECT 
			';
   mysql_select_db('ryeades_db');
   $retval = mysql_query( $sql, $conn );
   
   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }

   
  ?>
   <td> </td>
         <table border="1">
                    <th>Project Number</th>
                    <th>Project Title</th>
                    <th>AverageScroing</th>
		    <th>All Scores </th>
                    
                   

            </tr>

            
        <?php

             while($row = mysql_fetch_assoc($retval)) {                 
		?>
            <tr>
		
                <td><?php echo $row['ProjectNumber']; ?></td>
                <td><?php echo $row['Title']; ?></td>
                <td><?php echo $row['AverageRanking']; ?></td>
		<td><button> <a href="viewProject.php?id=<?php echo $row['ProjectID'];?>"> Cheack All Scoring </a></button></td>

             				
		

             
               
            </tr>
        <?php
             }
             ?>
             </table>
  
       
	

    <div id="tableDiv"></div>

    <div id="formSpace" class="w3-twothird w3-container">
      <h1 hidden class="w3-text-teal">Form area</h1><br/><br/><br/>
      <p hidden>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum
        dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div class="w3-third w3-container">

    </div>
  </div>

  <div style="display:none" class="w3-row">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Heading</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum
        dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div class="w3-third w3-container">

    </div>
  </div>

  <div style="display:none" class="w3-row w3-padding-64">
    <div class="w3-twothird w3-container">
      <h1 class="w3-text-teal">Heading</h1>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum
        dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
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


<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");
// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");
// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
  if (mySidebar.style.display === 'block') {
    mySidebar.style.display = 'none';
    overlayBg.style.display = "none";
  } else {
    mySidebar.style.display = 'block';
    overlayBg.style.display = "block";
  }
}
// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}
function showForm(id) {
    document.getElementById("formSpace").innerHTML = document.getElementById(id).innerHTML
}
</script>

</body>
</html>
