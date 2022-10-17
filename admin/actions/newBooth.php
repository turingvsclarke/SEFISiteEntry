<?php
    session_start();
    if (isset($_SESSION["user"])) {
        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
        $email = $_SESSION["user"];
    }
    
    // form validation
    $valid = true;

    // booth number
    if (isset($_POST["boothNum"])) {
        $boothNum = trim($_POST["boothNum"]);
        $validBoothNum = true;
    } else {
        $valid = false;
        $validBoothNum = false;
    }

    if ($valid) {

        // mysql server
        $srv_hostname = "localhost";
        $srv_username = "ryeades";
        $srv_password = "ryeades";

        try {
            $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO `ryeades_db`.`BOOTH` (`BoothID`, `Number`, `Active`) VALUES (NULL, '$boothNum', '1')";

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
