<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/checkForAdmin.php";

	
    session_start();
    if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];
        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
    }
?>

<!DOCTYPE html>
<html lang="en">
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="css/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/our.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script><script src="js/admin.js"></script>
<link rel="stylesheet" href="css/dashboard.css">

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
  <table style="border:1px solid black">
        <!--
        <tr>
            <td style="border:1px solid black" onclick="showForm('newAdmin')">new admin</td>
            <td style="border:1px solid black" onclick="showForm('newBooth')">new booth</td>
            <td style="border:1px solid black" onclick="showForm('newCategory')">new category</td>
            <td style="border:1px solid black" onclick="showForm('newCounty')">new county</td>
            <td style="border:1px solid black" onclick="showForm('newGrade')">new grade</td>
            <td style="border:1px solid black" onclick="showForm('newGradeLevel')">new grade level</td>
            <td style="border:1px solid black" onclick="showForm('newJudge')">new judge</td>
            <td style="border:1px solid black" onclick="showForm('newProject')">new project</td>
            <td style="border:1px solid black" onclick="showForm('newSchool')">new school</td>
            <td style="border:1px solid black" onclick="showForm('newSession')">new session</td>
            <td style="border:1px solid black" onclick="showForm('newStudent')">new student</td>
        </tr>
-->
    </table>
    <div id="formSpace" class="w3-twothird w3-container">
        <div id="accordion">
            <h3>new admin</h3>
            <?php include "forms/newAdmin.php";?>
            <h3>new booth</h3>
            <?php include "forms/newBooth.php";?>
            <h3>new category</h3>
            <?php include "forms/newCategory.php";?>
            <h3>new county</h3>
            <?php include "forms/newCounty.php";?>
            <h3>new grade</h3>
            <?php include "forms/newGrade.php";?>
            <h3>new grade level</h3>
            <?php include "forms/newGradeLevel.php";?>
            <h3>new judge</h3>
            <?php include "forms/newJudge.php";?>
            <h3>new project</h3>
            <?php include "forms/newProject.php";?>
            <h3>new school</h3>
            <?php include "forms/newSchool.php";?>
            <h3>new session</h3>
            <?php include "forms/newSession.php";?>
            <h3>new student</h3>
            <?php include "forms/newStudent.php";?>
        </div>
      <button onclick="genSched()">Generate Schedule</button>
      <p hidden>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum
        dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <p id="response"></p>
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

<?php /*
    include "forms/newAdmin.php";
    include "forms/newBooth.php";
    include "forms/newCategory.php";
    include "forms/newCounty.php";
    include "forms/newGrade.php";
    include "forms/newGradeLevel.php";
    include "forms/newJudge.php";
    include "forms/newProject.php";
    include "forms/newSchool.php";
    include "forms/newSession.php";
    include "forms/newStudent.php"; */
?>

<script src="/n342-final/assets/js/sidebar.js"></script>
<script>

</script>

</body>
</html>
