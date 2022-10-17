<?php

    // mysql server
    $srv_hostname = "localhost";
    $srv_username = "ryeades";
    $srv_password = "ryeades";

    
    try {

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



        $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



        // get all judges
        $sql = "
            SELECT * FROM JUDGE
                INNER JOIN JUDGE_CATEGORY_PREF ON
                    JUDGE.JudgeID = JUDGE_CATEGORY_PREF.JudgeID
                INNER JOIN JUDGE_GRADE_PREF ON
                JUDGE.JudgeID = JUDGE_GRADE_PREF.JudgeID
                
        ";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $judges = $stmt->fetchAll();

        // get all projects
        $sql = "SELECT * FROM PROJECT";

        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $projects = $stmt->fetchAll();
        //print_r($projects);

        $schedule = array();

        function hasJudged($k,$judge) {
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

            for($i=0;$i<count($times)-1;$i++) {
                if (isset($judge[$times[$i]]) && $judge[$times[$i]] == $k) {
                    //echo "true";
                    return true;
                } 
            }
            //echo "false";
            return false;

            //try {
            //    return array_search($k,$judge);
            //} catch(Exception $e) {
            //    return false;
            //}
        }


        for($i=0;$i<count($judges);$i++) {
            $schedule[$judges[$i]['JudgeID']] = array();
        }


        
        
        for($i=0;$i<count($times);$i++) {
            
            for($k=0;$k<count($projects);$k++) {
                $possibleJudge = 0;
                for($j=0;$j<count($judges);$j++) {
                    
                    if (!isset($schedule[$judges[$j]['JudgeID']][$times[$i]])) {
                        if ((($judges[$j]['GradeID'] == $projects[$k]['GradeLevelID']) && ($judges[$j]['CategoryID'] == $projects[$k]['CategoryID'])) && !hasJudged($projects[$k]['ProjectID'],$schedule[$judges[$j]['JudgeID']])) {
                            //$schedule[$judges[$j]['JudgeID']][$times[$i]] = $projects[$k]['ProjectID'];
                            $possibleJudge = $j;
                        //break;
                        } else if (($judges[$j]['GradeID'] == $projects[$k]['GradeLevelID']) && !hasJudged($projects[$k]['ProjectID'],$schedule[$judges[$j]['JudgeID']])) {
                            //$schedule[$judges[$j]['JudgeID']][$times[$i]] = $projects[$k]['ProjectID'];
                            $possibleJudge = $j;
                        //break;
                        } else if (($judges[$j]['CategoryID'] == $projects[$k]['CategoryID']) && !hasJudged($projects[$k]['ProjectID'],$schedule[$judges[$j]['JudgeID']])) {
                            //$schedule[$judges[$j]['JudgeID']][$times[$i]] = $projects[$k]['ProjectID'];
                            $possibleJudge = $j;
                        //break;
                        } else if (!hasJudged($projects[$k]['ProjectID'],$schedule[$judges[$j]['JudgeID']])) {
                            //$schedule[$judges[$j]['JudgeID']][$times[$i]] = $projects[$k]['ProjectID'];
                            $possibleJudge = $j;
                        //break;
                        } else; //break;
                    }
                }
                if ($possibleJudge > 0) {
                    
                    $schedule[$judges[$possibleJudge]['JudgeID']][$times[$i]] = $projects[$k]['ProjectID'];
                }
            }
        }
        
        $conn->exec('DELETE FROM SCHEDULE');
        

        for($i=0;$i<count($times)-1;$i++) {
            //file_put_contents('php://stderr',$times[$i]);
            for($j=0;$j<count($judges);$j++) {
                
                if (isset($schedule[$judges[$j]['JudgeID']][$times[$i]]) && !empty($schedule[$judges[$j]['JudgeID']][$times[$i]])) {
                    $sql = "SELECT SessionID FROM SESSION WHERE StartTime='".$times[$i]."'";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $SessionIDs = $stmt->fetchAll();
                    $SessionID = $SessionIDs[0]['SessionID'];

                    $ProjectID = $schedule[$judges[$j]['JudgeID']][$times[$i]];
                    $JudgeID = $judges[$j]['JudgeID'];
                    
                    $score= $i * 2;

                    $sql = "INSERT INTO `ryeades_db`.`SCHEDULE` (`ScheduleID`, `SessionID`, `ProjectID`, `JudgeID`, `Score`) VALUES (NULL, '$SessionID', '$ProjectID', '$JudgeID', '$score');";
                    $conn->exec($sql);
                }
            }
        }

        header("Location: /n342-final/admin/listSchedule.php");


    } catch(PDOException $e) {
        echo $e;
    }
    header("Location: /n342-final/admin/listSchedule.php");

?>