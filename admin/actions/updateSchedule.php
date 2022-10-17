<?php

    $times = [];

    // generate time array because i didn't feel like typing it all out
    for($i=9;$i<18;$i++) {
        for($j=0;$j<60;$j+=15) {
            $str = "";
            if ($i<10) $str .= "0";
            $str .= "$i:";
            if ($j<15) $str .= "0";
            $str .= "$j:00";
            array_push($times,$str);
        }
    }

    // mysql server
    $srv_hostname = "localhost";
    $srv_username = "ryeades";
    $srv_password = "ryeades";
    
    try {
        $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        $sql = "SELECT * FROM SESSION WHERE StartTime='".$times[$_POST['time']]."'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $SessionID = $stmt->fetchAll();

        $sql = "DELETE FROM SCHEDULE WHERE JudgeID='".$_POST['id']."' AND SessionID='".$SessionID[0]['SessionID']."'";

        $conn->exec($sql);


        $sql = "INSERT INTO `ryeades_db`.`SCHEDULE` (`SessionID`,`ProjectID`,`JudgeID`) VALUES ('".$SessionID[0]['SessionID']."','".$_POST['projNum']."','".$_POST['id']."');";
        $conn->exec($sql);

        $sql = "SELECT PROJECT.ProjectNumber,BOOTH.Number FROM SCHEDULE
                INNER JOIN PROJECT ON
                    SCHEDULE.ProjectID=PROJECT.ProjectID
                INNER JOIN BOOTH ON
                    PROJECT.BoothID = BOOTH.BoothID
                WHERE SCHEDULE.JudgeID='".$_POST['id']."' AND SCHEDULE.SessionID='".$SessionID[0]['SessionID']."'";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $output = $stmt->fetchAll();

        $response = "<p>Project Num: ".$output[0]['ProjectNumber']."<br />Booth Num: ".$output[0]['Number']."</p>";
        echo $response;


    } catch(PDOException $e) {
        echo "something broke";
    }

?>