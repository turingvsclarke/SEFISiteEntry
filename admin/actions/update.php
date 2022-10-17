<?php
     require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/dbconnect.php";

    // handle checkboxes manually
    if (isset($_POST['Active'])) {
        $_POST['Active'] = 1;
    } else {
        $_POST['Active'] = 0;
    }

    //if (isset($_SESSION["type"]) && $_SESSION["type"] == "admin") {
    if (true) {

        try {
            $conn = $con;
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // get column names to use with update statement
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$_POST['form']."'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $attrs = $stmt->fetchAll();

            // start building update statement
            $sql = "UPDATE " . $_POST['form'] . " SET ";

            for($i=1;$i<count($attrs);$i++) {
                // update each column name except primary key using information from POST request
                $sql .= $attrs[$i]['COLUMN_NAME'] . "='" . $_POST[$attrs[$i]['COLUMN_NAME']] . "'";
                if ($i != count($attrs)-1) $sql.= ",";
            }
            $sql .= " WHERE " . $attrs[0]['COLUMN_NAME'] . "=" . $_POST[$attrs[0]['COLUMN_NAME']];

            $conn->exec($sql);

            // build response
            $response = "";
            for($i=0;$i<count($attrs);$i++) {
                $response .= "<td>".$_POST[$attrs[$i]['COLUMN_NAME']]."</td>";
            }
            
            $response .= "<td><button onclick=\"toggleRow('tr".$_POST['i']."')\">edit</button></td>";
            $response .= "<td><button onclick='deactivate(".$_POST[$attrs[0]['COLUMN_NAME']].")'>delete</button></td>";
            
            echo $response;

        } catch (PDOException $e) {
            echo "didn't work " . $e;
        }

        $conn = null;
    }

?>
