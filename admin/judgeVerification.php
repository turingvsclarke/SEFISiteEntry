<!--
FileName: judgeVerification.php
Purpose: Show all the judges before the schedule is verified
Modification history:
11/16/20 Original build date
-->
<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/checkForAdmin.php";
    require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/dbconnect.php";

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

<script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<link rel="stylesheet" href="/n342-final/assets/css/w3.css">
<link rel="stylesheet" href="/n342-final/assets/css/w3-theme-black.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="/n342-final/assets/css/font-awesome.min.css">
<link rel="stylesheet" href="/n342-final/assets/css/our.css">

<link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css"/>
<link rel="stylesheet" type="text/css" href="/n342-final/assets/css/list.css">
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
require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/assets/navbar.php";
require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/assets/sidebar.php";
?>
<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- Main content: shift it to the right by 250 pixels when the sidebar is visible -->
<div class="w3-main our-main" style="margin-left:250px; margin-top:45px">

  <div class="w3-row w3-padding-64">

    <div id="tableDiv" style="overflow:auto"></div>
    <form action = "actions/generateSchedule.php">
      
        <input type="Submit" value="Generate Schedule With These Judges">      
    </form>

<?php
   
    // list of tables to use with index from form
    $tables = ["JUDGE"];
    $idx = 0;
    // index will always be set if accessed from the list.php page, so it should be valid
    

    // index is negative if no table is selected
    if ($idx > -1) {

        try {
            $conn = $con;
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // get all information from table
            $sql = "SELECT * FROM JUDGE WHERE Deleted=0 or Deleted is null";
            //if (isset($_POST['activeOnly'])) $sql .= " WHERE Active=1";

            $stmt = $conn->prepare($sql);
            $stmt->execute();
                
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();
            
            // get column names from table for html table headers
            $sql = "SELECT COLUMN_NAME,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='JUDGE'";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $attrs = $stmt->fetchAll();
            
            unset($attrs[12]);
            unset($attrs[13]);
            unset($attrs[11]);
            unset($attrs[5]);
            unset($attrs[0]);
            unset($attrs[6]);
            unset($attrs[7]);

            $_POST['idx']=0;
            // if index is set in post array, page is requesting a table
            if (isset($_POST['idx'])) {
                // start generating table
                echo "<table id='theTable'>";
                echo "<thead>";
                echo "<tr>";

                // put column names in table headers
                foreach($attrs as &$attr) echo "<th>".$attr['COLUMN_NAME']."</th>";
                unset($attr);
                echo "<th>edit</th>";
                echo "<th>delete</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // make two new rows for each entry in table
                for($i=0;$i<count($rows);$i++) {
                    // first row is just information from database
                    if($rows[$i]['Active']==1){
                    echo "<tr>";
                    foreach($attrs as &$attr) {
                       
                        // each table data tag is from the current entry at the current attribute
                        echo "<td>".$rows[$i][$attr['COLUMN_NAME']]."</td>";
                    }
                    unset($attr);

                    // add button to toggle the editing row hidden/not hidden
                    echo "<td><button onclick='toggleRow(\"tr$i\")'>Edit</button></td>";
                    echo "<td><button onclick='deactivate(".$rows[$i]['JudgeID'].")'>Delete</button></td>";

                    echo "</tr>";

                    // second row is for editing
                    // starts hidden and is toggled in and out of existence by button in preceding row
                    echo "<tr hidden id='tr".$i."'>";

                    // hide the primary key input
                    echo "<td><input type='hidden' id='r".$i."d0' value='". $rows[$i]['JudgeID'] ."'></td>";
                    
                    // loop through attributes to create inputs
                    $j=0;
                    foreach($attrs as &$attr) {
                        // set input id for javascript
                        $str = "<td><input id='r".$i."d".$j."' type=";

                        // change input type based on attribute data type
                        switch ($attr['DATA_TYPE']) {
                            case "varchar" :
                                $str .= "'text' ";
                                break;
                            case "int" :
                                $str .= "'number' ";
                                break;
                            case "tinyint" :
                                $str .= "'checkbox' ";
                                break;
                            case "year" :
                                $str .= "'number' ";
                                break;
                        }
                        
                        // add default value to make editing easier
                        $str .= "value='" . $rows[$i][$attr['COLUMN_NAME']] . "'></td>";

                        echo $str;
                        $j++;
                    }
                    unset($attr);
                    echo "<td><button onclick='submitInput(".$i.")'>submit</button></td>";
                    echo "</tr>";
                }
                }
                echo "</tbody>";
                echo "</table>";

            }
            
            // if index is set in get array, the page is requesting a javascript function


?>
      <script>
    // javascript function for submitting edits to database
    function submitInput(i) {
        <?php $_POST['form']='JUDGE'; ?>
        var str = "form=<?php echo $tables[$idx] . "&idx=" . $idx . "&"; ?>i="+String(i)+"&";

        <?php $j=0; 
              foreach($attrs as &$attr) { ?>
       
        str += "<?php echo $attr['COLUMN_NAME'];?>=" + $("#r"+i+"d<?php echo $j;?>").val();
        <?php if ($j < count($attrs)-1) { ?>
        str += "&";
        <?php }  
        $j++;
        }
        ?>
        //console.log(str);
        
        xhr = new XMLHttpRequest();

        xhr.addEventListener( "load", function(event) {
            $("tbody").children().eq(2*i).html(event.target.responseText);
            toggleRow("tr"+String(i));
            //console.log($("tbody").children().get(2*i));
            //console.log(event.target.responseText);
        } );
    
        xhr.addEventListener( "error", function(event) {
            alert('something broke');
        } );

        xhr.open("POST","actions/update.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.send(str);
    }

    function deactivate(i) {
        var str = "form=<?php echo $tables[$idx] ."&"; ?>i=<?php echo $attrs[0]['COLUMN_NAME']; ?>&id="+String(i);

        xhr = new XMLHttpRequest();

        xhr.addEventListener( "load", function(event) {
            alert("record successfully deleted");
            //console.log($("tbody").children().get(2*i));
            //console.log(event.target.responseText);
        } );
    
        xhr.addEventListener( "error", function(event) {
            alert('something broke');
        } );

        xhr.open("POST","actions/deactivate.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.send(str);
    }
      </script>
<?php

        } catch (PDOException $e) {
            echo "didn't work " . $e;
        }

        $conn = null;
    } else {
        echo "invalid selection";
    }

?>
    
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

function toggleRow(i) {
    //document.getElementById(i).style.display = "inline";
    //document.getElementById(i).removeAttribute("hidden");
    document.getElementById(i).hidden = !document.getElementById(i).hidden;
}
</script>

</body>
</html>
