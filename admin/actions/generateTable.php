<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/dbconnect.php";
    if (isset($_SESSION["user"])) {
        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
        $email = $_SESSION["user"];
    }

    // list of tables to use with index from form
    $tables = ["ADMIN","BOOTH","CATEGORY","COUNTY","GRADE","JUDGE","JUDGE_CATEGORY_PREF","JUDGE_GRADE_PREF","PROJECT","PROJECT_GRADE_LEVEL","SCHEDULE","SCHOOL","SESSION","STUDENT"];


    // index will always be set if accessed from the list.php page, so it should be valid
    if (isset($_POST['idx'])) $idx = $_POST['idx'];
    else if (isset($_GET['idx'])) $idx = $_GET['idx'];

    // index is negative if no table is selected
    if ($idx > -1) {

        try {
            $conn = $con;
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // get all information from table

            $sql = "SELECT * FROM ".$tables[$idx];
            if ($_POST['idx'] != 6 && $_POST['idx'] != 7) $sql .= " WHERE Deleted=0 OR Deleted IS NULL";

            //if (isset($_POST['activeOnly'])) $sql .= " WHERE Active=1";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $rows = $stmt->fetchAll();

            // get column names from table for html table headers
            $sql = "SELECT COLUMN_NAME,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$tables[$idx]."'";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $attrs = $stmt->fetchAll();


            // if index is set in post array, page is requesting a table
            if (isset($_POST['idx'])) {
                // start generating table
                echo "<table id='theTable'>";
                echo "<thead>";
                echo "<tr>";

                // put column names in table headers
                for($i=0;$i<count($attrs);$i++) echo "<th>".$attrs[$i]['COLUMN_NAME']."</th>";

                echo "<th>edit</th>";
                echo "<th>delete</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";

                // make two new rows for each entry in table
                for($i=0;$i<count($rows);$i++) {
                    // first row is just information from database
                    echo "<tr>";

                    for($j=0;$j<count($attrs);$j++) {
                        // each table data tag is from the current entry at the current attribute
                        echo "<td>".$rows[$i][$attrs[$j]['COLUMN_NAME']]."</td>";
                    }

                    // add button to toggle the editing row hidden/not hidden
                    echo "<td><button onclick='toggleRow(\"tr$i\")'>edit</button></td>";
                    echo "<td><button onclick='deactivate(".$rows[$i][$attrs[0]['COLUMN_NAME']].")'>delete</button></td>";

                    echo "</tr>";

                    // second row is for editing
                    // starts hidden and is toggled in and out of existence by button in preceding row
                    echo "<tr hidden id='tr".$i."'>";

                    // hide the primary key input
                    echo "<td><input type='hidden' id='r".$i."d0' value='". $rows[$i][$attrs[0]['COLUMN_NAME']] ."'></td>";
                    
                    // loop through attributes to create inputs
                    for($j=1;$j<count($attrs);$j++) {

                        // set input id for javascript
                        $str = "<td><input id='r".$i."d".$j."' type=";

                        // change input type based on attribute data type
                        switch ($attrs[$j]['DATA_TYPE']) {
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
                        $str .= "value='" . $rows[$i][$attrs[$j]['COLUMN_NAME']] . "'></td>";

                        echo $str;

                    }

                    echo "<td><button onclick='submitInput(".$i.")'>submit</button></td>";
                    echo "</tr>";

                }
                echo "</tbody>";
                echo "</table>";

            }

            // if index is set in get array, the page is requesting a javascript function
            else if (isset($_GET['idx'])) {

?>
    // javascript function for submitting edits to database
    function submitInput(i) {
        
        var str = "form=<?php echo $tables[$idx] . "&idx=" . $idx . "&"; ?>i="+String(i)+"&";

        <?php for($j=0;$j<count($attrs);$j++) : ?>
        str += "<?php echo $attrs[$j]['COLUMN_NAME'];?>=" + $("#r"+i+"d<?php echo $j;?>").val();
        <?php if ($j < count($attrs)-1) : ?>
        str += "&";
        <?php endif; endfor; ?>
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

<?php
            }



        } catch (PDOException $e) {
            echo "didn't work " . $e;
        }

        $conn = null;
    } else {
        echo "invalid selection";
    }

?>
