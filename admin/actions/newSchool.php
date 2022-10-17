<?php
    session_start();
    if (isset($_SESSION["user"])) {
        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
        $email = $_SESSION["user"];
    }

    // form validation
    $valid = true;

    // school name
    if (isset($_POST["name"])) {
        $name = trim($_POST["name"]);
        $validName = true;
    } else {
        echo "name";
        $valid = false;
        $validName = false;
    }
    // city
    if (isset($_POST["city"])) {
        $city = trim($_POST["city"]);
        $validCity = true;
    } else {
        echo "city";
        $valid = false;
        $validCity = false;
    }
    // county
    if (isset($_POST["county"])) {
        $county = trim($_POST["county"]);
        $validCounty = true;
    } else {
        echo "county";
        $valid = false;
        $validCounty = false;
    }

    if ($valid) {

        // mysql server
        $srv_hostname = "localhost";
        $srv_username = "ryeades";
        $srv_password = "ryeades";

        try {
            $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO `ryeades_db`.`SCHOOL` (`SchoolID`, `SchoolName`, `SchoolCity`, `CountyID`) VALUES (NULL, '$name', '$city', '$county')";

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
