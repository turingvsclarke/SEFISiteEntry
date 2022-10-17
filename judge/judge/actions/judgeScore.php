<?php
    require $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/dbconnect.php";

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

            //$sql = "INSERT INTO `ryeades_db`.`SESSION` (`SessionID`, `SessionNumber`, `StartTime`, `EndTime`, `Active`) VALUES (NULL, '$sesshNum', 'start', 'end', '1')";
            $sql = "UPDATE SCHEDULE SET Score=$score WHERE JudgeID=".$_SESSION['id']." AND ProjectID=$projNum";

            $con->query($sql);

        } catch (PDOException $e) {
            echo "didn't work " . $e;
        }

        echo "success";
        
    } else {
        echo "invalid ";
    }

?>
