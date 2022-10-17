<?php

    require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/checkForAdmin.php";

	
    session_start();
    if (isset($_SESSION["user"])) {
        $user = $_SESSION["user"];
        $type = $_SESSION["type"];
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
<script src="js/admin.js"></script>

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
    <div id="formSpace" class="w3-twothird w3-container">
    <?php

        //if (isset($_SESSION["type"]) && $_SESSION["type"] == "admin") {
        if (true) {

            // mysql server
            $srv_hostname = "localhost";
            $srv_username = "ryeades";
            $srv_password = "ryeades";

            try {
                $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // get column names and data types for input tags
                $sql = "SELECT COLUMN_NAME,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$_GET['form']."'";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $attrs = $stmt->fetchAll();


                // get current information for specified entry in specified table
                $sql = "SELECT * FROM ".$_GET['form']." WHERE " . $attrs[0]['COLUMN_NAME'] ."=". $_GET['id'];

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $row = $stmt->fetchAll();

                // start building form
                echo "<form method='POST' action='actions/update.php'>";
                
                // hide the table name and primary key
                echo "<input type='hidden' name='form' value='" . $_GET['form'] . "'>";
                echo "<input type='hidden' name='" . $attrs[0]['COLUMN_NAME'] . "' value='" . $row[0][$attrs[0]['COLUMN_NAME']] . "'>";

                for($i=1;$i<count($attrs);$i++) {
                    // start building input for current attribute
                    $line = "<label for='" . $attrs[$i]['COLUMN_NAME'] . "'>" . $attrs[$i]['COLUMN_NAME'] . "</label><br/><input name='" . $attrs[$i]['COLUMN_NAME'] . "' type=";

                    // set input type using data type from database
                    switch ($attrs[$i]['DATA_TYPE']) {
                        case "varchar" :
                            $line .= "'text' ";
                            break;
                        case "int" :
                            $line .= "'number' ";
                            break;
                        case "tinyint" :
                            $line .= "'checkbox' ";
                            break;
                        case "year" :
                            $line .= "'number' ";
                    }

                    // default value is current value from database
                    // except checkboxes, that'll take a little more work
                    $line .= "value='" . $row[0][$attrs[$i]['COLUMN_NAME']] . "'><br/><br/>";

                    echo $line;

                }

                echo "<button type='submit'>submit</button>";

                echo "</form>";

                

            } catch (PDOException $e) {
                echo "didn't work " . $e;
            }

            $conn = null;

            
        }

        ?>
      <h1 class="w3-text-teal"></h1><br/><br/><br/>
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
/*
function showForm(id) {
        document.getElementById("formSpace").innerHTML = document.getElementById(id).innerHTML;
        var forms = document.getElementsByTagName("form");
        forms[0].addEventListener( "submit", function ( event ) {
            event.preventDefault();
        
            sendData(id);
        });
}

function sendData(id) {
        var xhr = new XMLHttpRequest();
    
        var formData = new FormData(document.getElementById(id).childNodes[3]);
    
        xhr.addEventListener( "load", function(event) {
            document.getElementById("response").textContent = event.target.responseText;
        } );
    
        xhr.addEventListener( "error", function(event) {
          alert('something broke');
        } );
    
        xhr.open("POST", "actions/" + id + ".php");
    
        xhr.send(formData);
    } */

</script>

</body>
</html>
