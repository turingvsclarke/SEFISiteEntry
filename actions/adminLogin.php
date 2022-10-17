<!-- 
FILE NAME:n342-final/actions/adminLogin.php
PURPOSE:Check that the admin login exists and redirect to either the home page or the admin page based on this
MODIFICATION HISTORY:
11/04/20 Added comments, created redirect to admin login page if the login fails
-->
<?php
    session_start();
    require_once "dbconnect.php";

    // check if form inputs have been set
    $valid = true;

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
    
    // if all inputs present, try to login
    if ($valid) {
        // mysql server
            // count number of admins with these credentials
            // this can break with duplicate entries in database
            $sql = "CALL SP_COUNT_ADMIN('$email','$password')";

            $count = $con->query($sql)->fetchColumn();

            if ($count == 1) {

                // if exactly one entry, get the information for that admin
                $sql = "CALL SP_FIND_ADMIN('$email','$password')";

                $row = $con->query($sql)->fetch(PDO::FETCH_OBJ);

                if ($row->Level != "chair") $_SESSION["type"] = "admin";
                else $_SESSION["type"] = "chair";
                $_SESSION["id"] = $row->AdminID;
                $_SESSION["user"] = $row->Email;
                $_SESSION["firstName"] = $row->FirstName;
                $_SESSION["lastName"] = $row->LastName;

                // redirect to landing page
                header("Location: /n342-final/admin/admin.php");
	    }

	    else {
	    	header("Location: /n342-final/adminLogin.php");
	    }



    } else {
        echo "Invalid login";
    }
?>
