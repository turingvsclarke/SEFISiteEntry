<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left our-sidebar" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <img src="/n342-final/assets/images/logo.png" width="190px">
  <h4 class="w3-bar-item"><b>Menu</b></h4>

<?php
    if (isset($_SESSION['type'])){
	    if($_SESSION['type'] == "admin") {
        		echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/'>Admin home</a>".
        		"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/dashboard.php'>Dashboard</a>".
			"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/list.php'>List data</a>".
			"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/view.php'>View judge, session, booth, project assignments</a>".
                        "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/check.php'>Check Project Scoring / Average Ranking</a>".

			"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/uploadFile.php'>Upload data file</a>";  
		 }
	    else if ($_SESSION['type'] == "judge") {
        		echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/judge/'>Judge home</a>".
        		"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/judge/dashboard.php'>Dashboard</a>".
		    	"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/judge/view.php'>Schedule</a>";
	    }		

	echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/actions/logout.php'>Logout</a>";
    }		    
    else {
        echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/adminLogin.php'>Admin Login</a>";
        echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/judgeLogin.php'>Judge Login</a>";
    }

?>
</nav>
