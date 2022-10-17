<?php
/******
File name:/n342-final/judgeLogin.php
Purpose:Judge login form
Modification history:
*****/
    session_start();
    if (isset($_SESSION["type"])) {
        $user = $_SESSION["id"];
        $type = $_SESSION["type"];
    }
?>

<!DOCTYPE html>
<html lang="en">
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="assets/css/w3.css">
<link rel="stylesheet" href="assets/css/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="assets/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/our.css">
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
   
require "assets/navbar.php";
require "assets/sidebar.php";

?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main our-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">
    <div id="formSpace" class="w3-twothird w3-container">
      <h2 class="w3-text-teal" id="formLabel">Judge login</h2><br/>

      <form id="loginForm" method="POST" action="actions/judgeLogin.php">
          <label for="username">username</label>
          <input type="text" name="username"><br/><br/>
          <label for="password">password</label>
          <input type="password" name="password"><br/><br/>
          <button type="submit">submit</button>

    </div>
    <div class="w3-third w3-container">

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

<script src="assets/js/sidebar.js"></script>

</body>
</html>
