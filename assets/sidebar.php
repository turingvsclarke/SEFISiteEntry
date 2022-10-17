<!-- Sidebar -->
<nav class="w3-sidebar w3-bar-block w3-collapse w3-large w3-theme-l5 w3-animate-left our-sidebar" id="mySidebar">
  <a href="javascript:void(0)" onclick="w3_close()" class="w3-right w3-xlarge w3-padding-large w3-hover-black w3-hide-large" title="Close Menu">
    <i class="fa fa-remove"></i>
  </a>
  <img src="/n342-final/assets/images/logo.png" width="190px">
  <h4 class="w3-bar-item"><b>Menu</b></h4>
<ul style="margin-bottom:45px">
<?php
    if (isset($_SESSION['type'])){
	    if($_SESSION['type'] == "admin") {

        		echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/'>Admin home</a>".
        		"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/dashboard.php'>Dashboard</a>".
			"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/list.php'>List data</a>".
            "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/uploadFile.php'>Upload data file</a>";
            echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/listJudges.php'>Judge Attendance</a>";
            echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/listSchedule.php'>List Schedule By Judge</a>";
            echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/listScheduleProjects.php'>List Schedule By Project</a>".
			"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/view.php'>View judge, session, booth, project assignments</a>".
                        "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/check.php'>Check Project Scoring / Average Ranking</a>";

		 }
	    else if ($_SESSION['type'] == "judge") {
        		echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/judge/'>Judge home</a>".
        		"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/judge/dashboard.php'>Dashboard</a>".
		    	"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/judge/view.php'>Schedule</a>";
	    } else if ($_SESSION['type'] == "chair") {

		echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/'>Session Chairs home</a>".
	 	"<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/listSchedule.php'>View judge, session, booth, project assignments</a>".
    		 "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/viewProject.php'>View Scores</a>".
		 "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/admin/check.php'>View Average Rankings for Projects</a>";
            
        }

	echo "<li><a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/actions/logout.php'>Logout</a></li>";
    }		    
    else {

        echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/adminLogin.php'>Admin Login</a>";
        echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/chairLogin.php'>Chair Login</a>";
        echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/judgeLogin.php'>Judge Login</a>";
        echo "<a class='w3-bar-item w3-button w3-hover-black' href='/n342-final/registerJudge.php'>Judge Sign Up</a>";
    }

?>
</ul>
</nav>
