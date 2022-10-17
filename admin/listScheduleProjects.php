<?php
require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/dbconnect.php";
require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/checkForAdmin.php";


    session_start();
    if (isset($_SESSION["user"])) {
        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
        $email = $_SESSION["user"];
        $firstName = $_SESSION["firstName"];
    }

?>

<!DOCTYPE html>
<html lang="en">
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css"/>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="/n342-final/assets/css/w3.css">
<link rel="stylesheet" href="/n342-final/assets/css/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="css/our.css">
<link rel="stylesheet" href="/n342-final/admin/css/list.css">

<link rel="stylesheet" href="/n342-final/assets/css/font-awesome.min.css">
<link rel="stylesheet" href="/n342-final/assets/css/our.css">

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
require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/assets/navbar.php";
require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/assets/sidebar.php";
?>
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main our-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">
    <a id='test' href="actions/generateSchedule.php">Generate new schedule</a>


    <div style='overflow:auto;'>
    <?php
        if ($_SESSION["type"] == "admin") :

            $times = [];

            // generate time array because i didn't feel like typing it all out
            for($i=9;$i<18;$i++) {
                for($j=0;$j<60;$j+=15) {
                    $str = "";
                    if ($i<10) $str .= "0";
                    $str .= "$i:";
                    if ($j<15) $str .= "0";
                    $str .= "$j:00";
                    array_push($times,$str);
                }
            }
            
            try {
                $conn = $con;
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // get all schedule information
                $sql = "
                    SELECT * FROM SCHEDULE
                        INNER JOIN SESSION ON
                            SCHEDULE.SessionID=SESSION.SessionID
                        INNER JOIN PROJECT ON
                            SCHEDULE.ProjectID=PROJECT.ProjectID
                        INNER JOIN BOOTH ON
                            PROJECT.BoothID=BOOTH.BoothID
                        INNER JOIN JUDGE ON
                            SCHEDULE.JudgeID=JUDGE.JudgeID
                        ORDER BY SCHEDULE.JudgeID, StartTime
                ";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $rows = $stmt->fetchAll();

                // get judge names
                $sql = "SELECT FirstName,MiddleName,LastName,JudgeID FROM JUDGE";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $judges = $stmt->fetchAll();

                // get project names
                $sql = "SELECT ProjectID,ProjectNumber FROM PROJECT";

                $stmt = $conn->prepare($sql);
                $stmt->execute();

                $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $projects = $stmt->fetchAll();

                // initialize schedule dictionary
                $schedule = array();

                // initialize judge dictionaries within schedule
                for($i=0;$i<count($judges);$i++) {
                    $schedule[$projects[$i]['ProjectID']] = array();
                }

                // assign schedule information dictionaries to judge dictionaries with start time as key
                for($i=0;$i<count($rows);$i++) {
                    $schedule[$rows[$i]['ProjectID']][$rows[$i]['StartTime']] = $rows[$i];
                }

                // start generating table
                echo "<table id='theTable'>";
                echo "<thead>";
                echo "<tr>";
                echo "<th></th>";

                // put start times in table headers
                for($i=0;$i<count($times);$i++) echo "<th>".$times[$i]."</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // make a new row for each judge
                for($i=0;$i<count($projects);$i++) {
                    echo "<tr>";
                    echo "<td>Project #".$projects[$i]['ProjectNumber']."</td>";

                    // loop through each possible start time
                    for($j=0;$j<count($times);$j++) {
                        echo "<td class='dat' id='i".$projects[$i]['ProjectID']."j".$j."'>";

                        // if a session exists for judge at current start time,
                        // present project number, booth number, and an option to view more details
                        if (isset($schedule[$projects[$i]['ProjectID']][$times[$j]])) {
                            echo "Judge: ".$schedule[$projects[$i]['ProjectID']][$times[$j]]['FirstName']." ".$schedule[$projects[$i]['ProjectID']][$times[$j]]['LastName'];
                        } else echo "<span style='color:red;'>Special award judge</span>";
                        echo "</td>";
                    }

                    echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";

            } catch (PDOException $e) {
                echo "didn't work " . $e;
            }

            $conn = null;

        else :
            echo "<h3>administrator login required</h3>";
        endif;
    ?>
    </div>
    <div id="formSpace" class="w3-twothird w3-container"></div>
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

$(document).ready( function() {
    $(".detailRow").hide();
});

function fetchSchedDetails(i,j) {
    xhr = new XMLHttpRequest();

    xhr.addEventListener( "load", function(event) {

        $(".detailRow").hide();
        $("#tr"+i).html(event.target.responseText);
        $("#tr"+i).show();

    } );

    xhr.addEventListener( "error", function(event) {
        alert('something broke');
    } );

    xhr.open("POST","actions/fetchScheduleDetails.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.send("id="+i+"&time="+j);
}

function closeScheduleDetails(i) {
    document.getElementById("tr"+i).hidden = true;
    document.getElementById("tr"+i).innerHTML = "";
}

function showInputs(i) {
    $('.txt').hide();
    $('.projSelect').show();
    $('.buttonSpan1').hide();
    $('.buttonSpan2').show();
}

function hideInputs(i) {
    $('.projSelect').hide();
    $('.txt').show();
    $('.buttonSpan2').hide();
    $('.buttonSpan1').show();
}

function submitInputs(i,j) {
    xhr = new XMLHttpRequest();

    xhr.addEventListener( "load", function(event) {

        fetchSchedDetails(i,j);
        $("#i"+i+"j"+j).html(event.target.responseText);
        //console.log("test");
        //$('#test').text(event.target.responseText);

    } );

    xhr.addEventListener( "error", function(event) {
        alert('something broke');
    } );

    xhr.open("POST","actions/updateSchedule.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.send("projNum="+document.getElementById('projNum').value+"&id="+i+"&time="+j);
}

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

function genSched() {
    xhr = new XMLHttpRequest();

    xhr.addEventListener( "load", function(event) {
    
    } );

    xhr.addEventListener( "error", function(event) {
        alert('something broke');
    } );

    xhr.open("GET","actions/generateSchedule.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.send("");
}

// Close the sidebar with the close button
function w3_close() {
  mySidebar.style.display = "none";
  overlayBg.style.display = "none";
}

</script>

</body>
</html>
