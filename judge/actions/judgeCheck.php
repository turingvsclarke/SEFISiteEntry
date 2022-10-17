<?php
    require $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/dbconnect.php";
    session_start();
    if (isset($_SESSION["user"])) {
        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
        $email = $_SESSION["user"];
    }
    
    // form validation
    $valid = true;

    // session number
    if (isset($_POST["present"])) {
        $present = 1;
        $validPresent = true;
    } else {
        $present = 0;
    }

    if ($valid) {

        try {
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE `ryeades_db`.`JUDGE` SET Present=$present WHERE JudgeID=" . $_SESSION['id'];

            $con->exec($sql);

        } catch (PDOException $e) {
            echo "didn't work " . $e;
        }

        $con = null;

        echo strtoupper("success");
        
    } else {
        echo "invalid ";
    }

?>
