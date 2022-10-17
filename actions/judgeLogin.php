<?php
/******
File name:/n342-final/actions/judgeLogin.php
Purpose:Checks database for judge and either redirects to judge landing page or back to login form if it's invalid
Modification history:
11/12/20 Added comments and specified judge/judge.php is where an effective login should redirect
*******/
    session_start();
    require_once "dbconnect.php";
    $valid = true;


    // check if form inputs have been set
    if (isset($_POST["username"])) {
        $email = trim($_POST["username"]);
    } else {
        $valid = false;
    }

    if (isset($_POST["password"]) && !empty($_POST["password"])) {
        $password = trim($_POST["password"]);
    } else {
        $valid = false;
    }
    
    // if inputs are present, try to login
    if ($valid) {

            // find number of judges with these credentials
            $sql = "CALL SP_COUNT_JUDGE('$email','$password')";

            $count = $con->query($sql)->fetchColumn();

            if ($count == 1) {
                // get this judge's information
                $sql = "CALL SP_FIND_JUDGE('$email','$password')";

                $row = $con->query($sql)->fetch(PDO::FETCH_OBJ);

                $_SESSION["type"] = "judge";
                $_SESSION["id"] = $row->JudgeID;
                $_SESSION["user"] = $row->Email;
                $_SESSION["firstName"] = $row->FirstName;
                $_SESSION["lastName"] = $row->LastName;

                // redirect to landing page
                header("Location: /n342-final/judge/judge.php");
            }
	else{
		header("Location: /n342-final/judgeLogin.php");
	}

      }
     else {
        header("Location: /n342-final/judgeLogin.php");
    }
?>
