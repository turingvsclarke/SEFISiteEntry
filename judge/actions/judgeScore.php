<?php
    if(!isset($_SESSION))     
        {         
            session_start();     
        }
    require $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/dbconnect.php";
    //require_once "../../actions/dbconnect.php";

    // form validation
    $valid = true;

    // project number
    if (isset($_POST["projNum"])) {
        $projNum = trim($_POST["projNum"]);
        $validProjNum = true;
    } else {
        $valid = false;
        $validProjNum = false;
    }
    // score
    if (isset($_POST["score"])) {
        $score = trim($_POST["score"]);
        $validScore = true;
    } else {
        $valid = false;
        $validScore = false;
    }



    if ($valid) {

        try {
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE SCHEDULE SET Score=$score WHERE JudgeID='".$_SESSION['id']."' AND ProjectID='$projNum'";
            
            $con->exec($sql);

            $sql = "SELECT SUM(Score) AS s,COUNT(Score) AS c FROM SCHEDULE WHERE ProjectID='$projNum'";

            $stmt = $con->prepare($sql);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $row = $stmt->fetchAll();

            $avg = (($row[0]['s'] + $score) / ($row[0]['c'] + 1));

            $sql = "UPDATE PROJECT SET AverageRanking='$avg' WHERE ProjectID='$projNum'";
            $con->exec($sql);


        } catch (PDOException $e) {
            echo "didn't work " . $e;
        }

        echo strtoupper("success");
        
    } else {
        echo "invalid ";
    }

?>
