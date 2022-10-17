<?php
    session_start();

    if (isset($_SESSION["user"])) {

        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
        $email = $_SESSION["user"];
        $firstName = $_SESSION["firstName"];
    }


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

    // mysql server
    $srv_hostname = "localhost";
    $srv_username = "ryeades";
    $srv_password = "ryeades";
    
    try {
        $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // get all schedule information
        $sql = "
            SELECT JUDGE.FirstName,JUDGE.LastName,PROJECT.ProjectID,PROJECT.ProjectNumber,SESSION.StartTime,SESSION.EndTime,BOOTH.Number,JUDGE_GRADE_PREF.GradeID,JUDGE_CATEGORY_PREF.CategoryID,SCHEDULE.Score FROM SCHEDULE
                INNER JOIN SESSION ON
                    SCHEDULE.SessionID=SESSION.SessionID
                INNER JOIN PROJECT ON
                    SCHEDULE.ProjectID=PROJECT.ProjectID
                INNER JOIN BOOTH ON
                    PROJECT.BoothID=BOOTH.BoothID
                INNER JOIN JUDGE ON
                    SCHEDULE.JudgeID=JUDGE.JudgeID
                INNER JOIN JUDGE_GRADE_PREF ON
                    SCHEDULE.JudgeID=JUDGE_GRADE_PREF.JudgeID
                INNER JOIN JUDGE_CATEGORY_PREF ON
                    SCHEDULE.JudgeID=JUDGE_CATEGORY_PREF.JudgeID
                WHERE SCHEDULE.JudgeID='".$_GET['id']."' AND SESSION.StartTime='".$times[$_GET['time']]."'
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();


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
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
<script src="js/admin.js"></script>


<link rel="stylesheet" href="/n342-final/assets/css/w3.css">
<link rel="stylesheet" href="/n342-final/assets/css/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
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
	require "../assets/sidebar.php";
	require "../assets/navbar.php";
?>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main our-main" style="margin-left:250px">

  <div class="w3-row w3-padding-64">


    <?php
        if ($_SESSION["type"] == "admin") {
            echo "<h2>Start Time: ".$rows[0]['StartTime']."</h2>";
            echo "<h2>End Time: ".$rows[0]['EndTime']."</h2>";
            echo "<h2>Location: Booth ".$rows[0]['Number']."</h2>";
            echo "<h2>Judge: ".$rows[0]['FirstName']." ".$rows[0]['LastName']."</h2>";
            echo "<h2>Project Number: ".$rows[0]['ProjectNumber']."</h2>";
            echo "<h2>Score: ";
            if (isset($rows[0]['Score'])) echo $rows[0]['Score'];
            else echo "not set";
            echo "</h2>";
        } else {
            echo "<h3>administrator login required</h3>";
        }


    } catch (PDOException $e) {
        echo "didn't work " . $e;
    }

    $conn = null;
    ?>

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


</script>

</body>
</html>
