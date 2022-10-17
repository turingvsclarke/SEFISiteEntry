<?php


    // mysql server
    $srv_hostname = "localhost";
    $srv_username = "ryeades";
    $srv_password = "ryeades";

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
    
    try {
        $conn = new PDO("mysql:host=$srv_hostname;dbname=ryeades_db",$srv_username,$srv_password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


        //$conn->exec("DELETE FROM SESSION");
        for ($i=0;$i<count($times)-1;$i++) {
            $j=$i+1;
            $ti = $times[$i];
            $tj = $times[$j];
            $conn->exec("INSERT INTO `ryeades_db`.`SESSION` (`SessionNumber`, `StartTime`, `EndTime`, `ActiveValue`) VALUES ('$j', '$ti', '$tj', '1')");
        }

    } catch(PDOException $e) {
        echo $e;
    }

?>
