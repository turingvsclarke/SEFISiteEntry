<?php
    session_start();
    if (isset($_SESSION["user"])) {
        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
        $email = $_SESSION["user"];
    }
    
    // form validation
    $valid = true;

    // session number
    if (isset($_POST["sessNum"])) {
        $sessNum = trim($_POST["sessNum"]);
        $validSessNum = true;
    } else {
        $valid = false;
        $validSessNum = false;
    }
    // start time
    if (isset($_POST["start"])) {
        $start = trim($_POST["start"]);
        $validStart = true;
    } else {
        $valid = false;
        $validStart = false;
    }
    // end time
    if (isset($_POST["end"])) {
        $end = trim($_POST["end"]);
        $validEnd = true;
    } else {
        $valid = false;
        $validEnd = false;
    }

    if ($valid) {

        // mysql server
        $srv_hostname = "localhost";
        $srv_username = "ryeades";
        $srv_password = "ryeades";

        try {
            $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO `ryeades_db`.`SESSION` (`SessionID`, `SessionNumber`, `StartTime`, `EndTime`, `ActiveValue`) VALUES (NULL, '$sesshNum', 'start', 'end', '1')";

            $conn->exec($sql);

        } catch (PDOException $e) {
            echo "didn't work " . $e;
        }

        $conn = null;

        echo "success";

    } else {
        echo "invalid ";
    }

?>
