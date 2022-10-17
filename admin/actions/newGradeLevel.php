<?php
    session_start();
    if (isset($_SESSION["user"])) {
        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
        $email = $_SESSION["user"];
    }
    
    // form validation
    $valid = true;

    // first name
    if (isset($_POST["name"])) {
        $name = trim($_POST["name"]);
        $validName = true;
    } else {
        $valid = false;
        $validName = false;
    }

    if ($valid) {

        // mysql server
        $srv_hostname = "localhost";
        $srv_username = "ryeades";
        $srv_password = "ryeades";

        try {
            $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO `ryeades_db`.`PROJECT_GRADE_LEVEL` (`GradeLevelID`, `LevelName`, `ActiveValue`) VALUES (NULL, '$name', '1')";

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
