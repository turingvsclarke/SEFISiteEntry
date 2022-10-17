<?php

    // handle checkboxes manually
    if (isset($_POST['Active'])) {
        $_POST['Active'] = 1;
    } else {
        $_POST['Active'] = 0;
    }

    //if (isset($_SESSION["type"]) && $_SESSION["type"] == "admin") {
    if (true) {

        // mysql server
        $srv_hostname = "localhost";
        $srv_username = "ryeades";
        $srv_password = "ryeades";

        try {
            $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // get column names to use with update statement
            $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='".$_POST['form']."'";

            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $attrs = $stmt->fetchAll();

            // set Deleted to 1 where ID is the given id
            $sql = "UPDATE ".$_POST['form']." SET Deleted=1 WHERE ".$attrs[0]['COLUMN_NAME'] ."=". $_POST['id'];

            $conn->exec($sql);

            echo "success";

        } catch (PDOException $e) {
            echo "didn't work " . $e;
        }

        $conn = null;
    }

?>