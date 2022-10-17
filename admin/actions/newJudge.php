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

    // middle name
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
    // title
    if (isset($_POST["title"])) {
        $title = trim($_POST["title"]);
        $validTitle = true;
    } else {
        $valid = false;
        $validTitle = false;
    }

    // gender
    if (isset($_POST["gender"])) {
        $gender = trim($_POST["gender"]);
        $validGender = true;
    } else {
        $valid = false;
        $validGender = false;
    }

    // degree
    if (isset($_POST["degree"])) {
        $degree = trim($_POST["degree"]);
        $validDegree = true;
    } else {
        $valid = false;
        $validDegree = false;
    }
    // employer
    if (isset($_POST["employer"])) {
        $employer = trim($_POST["employer"]);
        $validEmployer = true;
    } else {
        $valid = false;
        $validEmployer = false;
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
    // grade level preference
    if (isset($_POST["gradeLevelPref"]) && $_POST["gradeLevelPref"] != "-- select --") {
        $gradeLevelPref = trim($_POST["gradeLevelPref"]);
        $validGradePref = true;
    } else {
        $valid = false;
        $validGradePref = false;
    }
    // category preference
    if (isset($_POST["categoryPref"]) && $_POST["categoryPref"] != "-- select --") {
        $categoryPref = trim($_POST["categoryPref"]);
        $validCatPref = true;
    } else {
        $valid = false;
        $validCatPref = false;
    }
    // grade level preference
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

            $sql = "INSERT INTO `ryeades_db`.`JUDGE` (`JudgeID`, `FirstName`, `MiddleName`, `LastName`,`Gender`, `Title`, `EducationLevel`, `Employer`, `Email`, `UserName`, `Password`, `Year`, `Present`) VALUES (NULL, '$firstName', '$middleName', '$lastName', '$gender', '$title', '$degree', '$employer', '$email', '$email', '$password', '$year', '0')";

            $conn->exec($sql);

            $sql = "CALL SP_FIND_JUDGE('$email','$password')";

            $theJudge = $conn->query($sql)->fetch(PDO::FETCH_OBJ);

            $sql = "INSERT INTO `ryeades_db`.`JUDGE_GRADE_PREF` (`JudgeID`, `GradeID`) VALUES ('".$theJudge->JudgeID."', '$gradeLevelPref')";

            $conn->exec($sql);

            $sql = "INSERT INTO `ryeades_db`.`JUDGE_CATEGORY_PREF` (`JudgeID`, `CategoryID`) VALUES ('".$theJudge->JudgeID."', '$categoryPref')";

            $conn->exec($sql);



        } catch (PDOException $e) {
            echo "didn't work " . $e;
        }

        $conn = null;

        if ($type == "admin") echo "success";
        else header("Location: /n342-final/judgeLogin.php");
    } else {
        if ($type == "admin") echo "invalid ";
        else header("Location: /n342-final/registerJudge.php?invalid=true");
        //echo $validFirst . " " . $validMiddle . " " . $validLast . " " . $validEmail . " " . $validPass . " " . $validLevel;
    }

?>
