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
    // grade
    if (isset($_POST["grade"])) {
        $grade = trim($_POST["grade"]);
        $validGrade = true;
    } else {
        $valid = false;
        $validGrade = false;
    }
    // gender
    if (isset($_POST["gender"])) {
        $gender = trim($_POST["gender"]);
        $validGender = true;
    } else {
        $valid = false;
        $validGender = false;
    }
    // school
    if (isset($_POST["school"]) && $_POST["school"] != "-- select --") {
        $school = trim($_POST["school"]);
        $validSchool = true;
    } else {
        $valid = false;
        $validSchool = false;
    }
    // project
    if (isset($_POST["projNum"])) {
        $projNum = trim($_POST["projNum"]);
        $validProjNum = true;
    } else {
        $valid = false;
        $validProjNum = false;
    }
    // year
    if (isset($_POST["year"])) {
        $year = trim($_POST["year"]);
        $validYear = true;
    } else {
        $valid = false;
        $validYear = false;
    }

    if ($valid) {

        // mysql server
        $srv_hostname = "localhost";
        $srv_username = "ryeades";
        $srv_password = "ryeades";

        try {
            $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //$sql = "INSERT INTO ADMIN VALUES ('$firstName','$middleName','$lastName','$email','$password','$level')";
            $sql = "INSERT INTO `ryeades_db`.`STUDENT` (`StudentID`, `FirstName`, `LastName`, `MiddleName`, `GradeID`, `Gender`, `SchoolID`, `ProjectID`,`Year`) VALUES (NULL, '$firstName', '$lastName', '$middleName', '$grade', '$gender', '$school', '$projNum', '$year')";

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
