<?php
    session_start();

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

        // get all schedule information
        $sql = "
            SELECT PROJECT.ProjectID,PROJECT.ProjectNumber,SESSION.StartTime,BOOTH.Number,JUDGE_GRADE_PREF.GradeID,JUDGE_CATEGORY_PREF.CategoryID FROM SCHEDULE
                INNER JOIN SESSION ON
                    SCHEDULE.SessionID=SESSION.SessionID
                INNER JOIN PROJECT ON
                    SCHEDULE.ProjectID=PROJECT.ProjectID
                INNER JOIN BOOTH ON
                    PROJECT.BoothID=BOOTH.BoothID
                INNER JOIN JUDGE ON
                    SCHEDULE.JudgeID=JUDGE.JudgeID
                INNER JOIN JUDGE_GRADE_PREF ON
                    SCHEDULE.JudgeID=JUDGE_GRADE_PREF.JudgeID
                INNER JOIN JUDGE_CATEGORY_PREF ON
                    SCHEDULE.JudgeID=JUDGE_CATEGORY_PREF.JudgeID
                WHERE SCHEDULE.JudgeID=".$_POST['id']." AND SESSION.StartTime='".$times[$_POST['time']]."'
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll();

        $stmt = $conn->prepare("SELECT * FROM PROJECT");
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $projects = $stmt->fetchAll();



        $response = "<td style='' colspan='".(count($times)+1)."'>
        Start time: ".$times[$_POST['time']]."<br />
        <span class='txt'>Project Number: ".$rows[0]['ProjectNumber']."</span>";

        if ($_SESSION['type'] == "admin") {
            $response .= "<span style='display : none;' class='projSelect'>
            <select id='projNum'>";

            for($i=0;$i<count($projects);$i++) {
                $response .= "<option ";
                if ($rows[0]['ProjectID'] == $projects[$i]['ProjectID']) $response .= "selected ";
                $response .= "value='".$projects[$i]['ProjectID']."'>Project Number ".$projects[$i]['ProjectNumber']." ";
                if ($rows[0]['CategoryID'] == $projects[$i]['CategoryID']) $response .= "--Category Match-- ";
                if ($rows[0]['GradeID'] == $projects[$i]['GradeLevelID']) $response .= "--Grade Level Match-- ";
                $response .= "</option>";
            }
            $response .= "</select></span><br/>";
        }

        $response .= "
            Booth: ".$rows[0]['Number']."<br />
            <a href='viewScheduleDetails.php?id=".$_POST['id']."&time=".$_POST['time']."'>details</a><br />";
            if ($_SESSION['type'] == "admin") {
                $response .= "<span class='buttonSpan1'><button onclick='showInputs(".$_POST['id'].")'>edit</button></span>
                <span class='buttonSpan2' style='display:none;'><button onclick='submitInputs(".$_POST['id'].",".$_POST['time'].")'>submit</button>
                <button onclick='hideInputs(".$_POST['id'].")'>cancel</button></span>";
            }

        $response .= "</td>";

        echo $response;

    } catch (PDOException $e) {
        echo "didn't work " . $e;
    }

    $conn = null;


?>