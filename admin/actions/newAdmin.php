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
    if (isset($_POST["firstName"])) {
        $firstName = trim($_POST["firstName"]);
        $validFirst = true;
    } else {
        $valid = false;
        $validFirst = false;
    }
    //middle name
    if (isset($_POST["middleName"])) {
        $middleName = trim($_POST["middleName"]);
        $validMiddle = true;
    } else {
        $valid = false;
        $validMiddle = false;
    }
    // last name
    if (isset($_POST["lastName"])) {
        $lastName = trim($_POST["lastName"]);
        $validLast = true;
    } else {
        $valid = false;
        $validLast = false;
    }
    // email
    if (isset($_POST["email"])) {
        $email = trim($_POST["email"]);
        $validEmail = true;
    } else {
        $valid = false;
        $validEmail = false;
    }
    // password
    if (isset($_POST["password"]) && !empty($_POST["password"])) {
        $password = trim($_POST["password"]);
        $validPass = true;
    } else {
        $valid = false;
        $validPass = false;
    }
    // admin level
    if (isset($_POST["level"]) && $_POST["level"] != "-- select --") {
        $level = trim($_POST["level"]);
        $validLevel = true;
    } else {
        $valid = false;
        $validLevel = false;
    }

    if ($valid) {

        // mysql server
        $srv_hostname = "localhost";
        $srv_username = "ryeades";
        $srv_password = "ryeades";

        try {
            $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO `ryeades_db`.`ADMIN` (`AdminID`, `FirstName`, `LastName`, `MiddleName`, `Email`, `Password`, `Level`, `ActiveValue`) VALUES (NULL, '$firstName', '$lastName', '$middleName', '$email', '$password', '$level', '1')";

            $conn->exec($sql);

        } catch (PDOException $e) {
            echo "didn't work " . $e;
        }

        $conn = null;

        echo "success";
    } else {
        echo "invalid ";
        echo $validFirst . " " . $validMiddle . " " . $validLast . " " . $validEmail . " " . $validPass . " " . $validLevel;
    }

?>
