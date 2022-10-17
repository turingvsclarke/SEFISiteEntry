<?php

require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/checkForAdmin.php";
require_once $_SERVER['DOCUMENT_ROOT']."/n342-final/actions/dbconnect.php";

    // form validation
    $valid = true;

    // first name
    if (isset($_POST["firstName"])) {
        $firstName = $_POST["firstName"];
        $validFirst = true;
    } else {
        $valid = false;
        $validFirst = false;
    }

    //middle name
    if (isset($_POST["middleName"])) {
        $middleName = $_POST["middleName"];
        $validMiddle = true;
    } else {
        $valid = false;
        $validMiddle = false;
    }
    // last name
    if (isset($_POST["lastName"])) {
        $lastName = $_POST["lastName"];
        $validLast = true;
    } else {
        $valid = false;
        $validLast = false;
    }
    // email
    if (isset($_POST["email"])) {
        $email = $_POST["email"];
        $validEmail = true;
    } else {
        $valid = false;
        $validEmail = false;
    }
    // password
    if (isset($_POST["password"]) && !empty($_POST["password"])) {
        $password = $_POST["password"];
        $validPass = true;
    } else {
        $valid = false;
        $validPass = false;
    }
    // admin level
    if (isset($_POST["level"]) && $_POST["level"] != "-- select --") {
        $level = $_POST["level"];
        $validLevel = true;
    } else {
        $valid = false;
        $validLevel = false;
    }

    if ($valid) {

        // mysql server
        $srv_hostname = "corsair.cs.iupui.edu";
        $srv_username = "ryeades";
        $srv_password = "ryeades";

        try {

            $conn = $con;
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO ADMIN VALUES ($firstName,$middleName,$lastName,$email,$password,$level)";

            $conn->exec($sql);

        } catch (PDOException $e) {
            echo "didn't work ";
        }

        $conn = null;
    }

?>
<html>
<body>test</body>
</html>
