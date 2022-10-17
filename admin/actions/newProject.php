<?php
    //session_start();
    if (isset($_SESSION["user"])) {
        $type = $_SESSION["type"];
        $id = $_SESSION["id"];
        $email = $_SESSION["user"];
    }
    
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

    // title
    if (isset($_POST["title"])) {
        $title = trim($_POST["title"]);
        $validTitle = true;
    } else {
        $valid = false;
        $validTitle = false;
    }
    // abstract
    if (isset($_POST["abstract"])) {
        $lastName = trim($_POST["abstract"]);
        $validAbstract = true;
    } else {
        $valid = false;
        $validAbstract = false;
    }
    // grade level
    if (isset($_POST["gradeLevel"])) {
        $gradeLevel = trim($_POST["gradeLevel"]);
        $validGradeLevel = true;
    } else {
        $valid = false;
        $validGradeLevel = false;
    }
    // category
    if (isset($_POST["category"])) {
        $category = trim($_POST["category"]);
        $validCategory = true;
    } else {
        $valid = false;
        $validCategory = false;
    }
    // booth number
    if (isset($_POST["booth"])) {
        $booth = trim($_POST["booth"]);
        $validBooth = true;
    } else {
        $valid = false;
        $validBooth = false;
    }
    // CourseNetworking
    if (isset($_POST["cn"])) {
        $cn = trim($_POST["cn"]);
        $validCN = true;
    } else {
        $valid = false;
        $validCN = false;
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
            $sql = "INSERT INTO `ryeades_db`.`PROJECT` (`ProjectID`, `ProjectNumber`, `Title`, `Abstract`,`GradeLevelID`, `CategoryID`, `BoothNumberID`, `CourseNetworkID`, `AverageRanking`, `Year`) VALUES (NULL, '$projNum', '$title', '$abstract', '$gradeLevel', '$category', '$booth', '$cn', NULL, '$year')";

            $conn->exec($sql);

        } catch (PDOException $e) {
            echo "didn't work " . $e;
        }

        $conn = null;
        echo "success";
    } else {
        echo "invalid ";
        //echo $validFirst . " " . $validMiddle . " " . $validLast . " " . $validEmail . " " . $validPass . " " . $validLevel;
    }

?>
