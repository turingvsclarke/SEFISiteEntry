<?php
    if(!isset($_SESSION))     
        {         
            session_start();     
        }
    //if (isset($_SESSION["user"])) {
    //    $type = $_SESSION["type"];
    //   $id = $_SESSION["id"];
    //   $email = $_SESSION["user"];
    //}


    // mysql server
    $hostname = 'localhost';
    /*** mysql username ***/
    $username = 'ryeades';
    /*** mysql password ***/
    $password = 'ryeades';
   
    $con = new PDO("mysql:host=$hostname;dbname=ryeades_db", $username, $password);

    //mysql_connect('localhost', 'ryeades', 'ryeades');
    //mysql_select_db('ryeades_db');

    $sql = "SELECT * FROM SCHEDULE 
        INNER JOIN PROJECT ON SCHEDULE.ProjectID = PROJECT.ProjectID
        WHERE SCHEDULE.JudgeID = ".$_SESSION['id']."
    ";

    $stmt = $con->prepare($sql);
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $rows = $stmt->fetchAll();

    //$result = mysql_query($sql);

?>
<div id="judgeScore" hidden>
    <h2>Judge scoring</h2>
    <form method="POST" action="judge/judgeScore.php">
        <label for="projNum">project number</label><br/>
        <select name="projNum">
        <?php
        //while($row = mysql_fetch_array($result))
        for($j=0;$j<count($rows);$j++)
        {
            echo "<option value='" . $rows[$j]['ProjectID'] ."'>" . $rows[$j]['ProjectNumber'] ."</option>";
        }
        ?>
        </select><br/><br/>
        <label for="score">Score</label><br/>
        <input type="number" min="1" max="100" name="score"><br/><br/>

        <button type="submit">submit</button>

        
    </form>
</div>
